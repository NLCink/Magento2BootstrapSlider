<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Model\ResourceModel\Slider;

use Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface;
use Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\items\Collection;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\State\InvalidTransitionException;
use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
/**
 * Slider CRUD class
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ItemsRepository implements \Stepzerosolutions\Tbslider\Api\SlideritemsRepositoryInterface
{


    /**
     * @var \Stepzerosolutions\Tbslider\Model\Slider\SlideritemsRegistry
     */
    protected $slideritemsRegistry;

    /**
     * @var \Stepzerosolutions\Tbslider\Model\Slider\ItemsFactory
     */
    protected $slideritemsFactory;

    /**
     * @var \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterfaceFactory
     */
    protected $slideritemsDataFactory;

    /**
     * @var \Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Items
     */
    protected $slideritemsResourceModel;

    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Stepzerosolutions\Tbslider\Api\Data\SlideritemsSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Framework\ObjectManagerInterface  $objectManager
     */
	protected $_objectManager;


	protected $_imageprocessor;
    /**
     * @param \Stepzerosolutions\Tbslider\Model\Slider\ItemsRegistry $slideritemsRegistry
     * @param \Stepzerosolutions\Tbslider\Model\Slider\ItemsFactory $slideritemsFactory
     * @param \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterfaceFactory $slideritemsDataFactory
     * @param \Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Items $slideritemsResourceModel
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
     * @param \Stepzerosolutions\Tbslider\Api\Data\SlideritemsSearchResultsInterfaceFactory $searchResultsFactory
	 * @param \Magento\Framework\ObjectManagerInterface $objectManager
	 * @param \Stepzerosolutions\Tbslider\Model\Image $imageprocessor
     */
    public function __construct(
        \Stepzerosolutions\Tbslider\Model\Slider\ItemsRegistry $slideritemsRegistry,
        \Stepzerosolutions\Tbslider\Model\Slider\ItemsFactory $slideritemsFactory,
        \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterfaceFactory $slideritemsDataFactory,
        \Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Items $slideritemsResourceModel,
		\Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Stepzerosolutions\Tbslider\Api\Data\SlideritemsSearchResultsInterfaceFactory $searchResultsFactory,
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Stepzerosolutions\Tbslider\Model\Image $imageprocessor
    ) {
        $this->slideritemsRegistry = $slideritemsRegistry;
        $this->slideritemsFactory = $slideritemsFactory;
        $this->slideritemsDataFactory = $slideritemsDataFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->slideritemsResourceModel = $slideritemsResourceModel;
        $this->searchResultsFactory = $searchResultsFactory;
		$this->_objectManager = $objectManager;
		$this->_imageprocessor = $imageprocessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface $slider)
    {
        $this->_validate($slider);

        /** @var \Stepzerosolutions\Tbslider\Model\Bookings\Slideritems $sliderModel */
        $sliderModel = null;
        if ($slider->getId()) {
            $sliderModel = $this->slideritemsRegistry->retrieve($slider->getId());
            $sliderDataAttributes = $this->dataObjectProcessor->buildOutputDataArray(
                $slider,
                '\Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface'
            );
            foreach ($sliderDataAttributes as $attributeCode => $attributeData) {
                $sliderModel->setDataUsingMethod($attributeCode, $attributeData);
            }
        } else {
            $sliderModel = $this->slideritemsFactory->create();
            $sliderModel->setSlideritemTitle($slider->getSlideritemTitle());
			$sliderModel->setSlideritem_description($slider->getSlideritemDescription());
			$sliderModel->setSlideritemSlider($slider->getSlideritemSlider());
			$sliderModel->setSliderImagePath($slider->getSliderImagePath());
			$sliderModel->setSliderImageMdPath($slider->getSliderImageMdPath());
			$sliderModel->setSliderImageSmPath($slider->getSliderImageSmPath());
			$sliderModel->setSliderImageXsPath($slider->getSliderImageXsPath());
			$sliderModel->setSliderUrl($slider->getSliderUrl());
			$sliderModel->setDate($slider->getDate());
			$sliderModel->setTimestamp($slider->getTimestamp());
			$sliderModel->setSliderSort($slider->getSliderSort());
			$sliderModel->setCaptionmeta($slider->getCaptionmeta());
			$sliderModel->setIsActive($slider->getIsActive());
        }

        try {
            $this->slideritemsResourceModel->save($sliderModel);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            /**
             * Would like a better way to determine this error condition but
             *  difficult to do without imposing more database calls
             */
			 die($e->getMessage());
            if ($e->getMessage() == (string)__('Slideritems already exists.')) {
                throw new InvalidTransitionException(__('Slideritems already exists.'));
            }
            throw $e;
        }

        $this->slideritemsRegistry->remove($sliderModel->getId());

        $sliderDataObject = $this->slideritemsDataFactory->create();
		$sliderDataObject->setSlideritemTitle($sliderModel->getSlideritemTitle());
		$sliderDataObject->setSlideritemDescription($sliderModel->getSlideritemDescription());
		$sliderDataObject->setSlideritemSlider($sliderModel->getSlideritemSlider());
		$sliderDataObject->setSliderImagePath($sliderModel->getSliderImagePath());
		$sliderDataObject->setSliderImageMdPath($sliderModel->getSliderImageMdPath());
		$sliderDataObject->setSliderImageSmPath($sliderModel->getSliderImageSmPath());
		$sliderDataObject->setSliderImageXsPath($sliderModel->getSliderImageXsPath());
		$sliderDataObject->setSliderUrl($sliderModel->getSliderUrl());
		$sliderDataObject->setDate($sliderModel->getDate());
		$sliderDataObject->setTimestamp($sliderModel->getTimestamp());
		$sliderDataObject->setSliderSort($sliderModel->getSliderSort());
		$sliderDataObject->setCaptionmeta($sliderModel->getCaptionmeta());
		$sliderDataObject->setIsActive($sliderModel->getIsActive());
        return $sliderDataObject;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $sliderModel = $this->slideritemsRegistry->retrieve($id);
        $sliderDataObject = $this->slideritemsDataFactory->create();
        $sliderDataObject->setId($sliderModel->getId());
		$sliderDataObject->setSlideritemTitle($sliderModel->getSlideritemTitle());
		$sliderDataObject->setSlideritemDescription($sliderModel->getSlideritemDescription());
		$sliderDataObject->setSlideritemSlider($sliderModel->getSlideritemSlider());
		$sliderDataObject->setSliderImagePath($sliderModel->getSliderImagePath());
		$sliderDataObject->setSliderImageMdPath($sliderModel->getSliderImageMdPath());
		$sliderDataObject->setSliderImageSmPath($sliderModel->getSliderImageSmPath());
		$sliderDataObject->setSliderImageXsPath($sliderModel->getSliderImageXsPath());
		$sliderDataObject->setSliderUrl($sliderModel->getSliderUrl());
		$sliderDataObject->setDate($sliderModel->getDate());
		$sliderDataObject->setTimestamp($sliderModel->getTimestamp());
		$sliderDataObject->setSliderSort($sliderModel->getSliderSort());
		$sliderDataObject->setCaptionmeta($sliderModel->getCaptionmeta());
		$sliderDataObject->setIsActive($sliderModel->getIsActive());
        return $sliderDataObject;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Items\Collection $collection */
        $collection = $this->slideritemsFactory->create()->getCollection();

        //Add filters from root filter group to the collection
        /** @var FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $slider) {
            $this->addFilterGroupToCollection($slider, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $this->translateField($sortOrder->getField());
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            // set a default sorting order since this method is used constantly in many
            // different blocks
            $field = $this->translateField('id');
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        /** @var \Stepzerosolutions\Tbslider\Api\Data\SliderInterface[] $slider */
        $groups = [];
        /** @var \Stepzerosolutions\Tbslider\Model\Slider $slider */
        foreach ($collection as $slider) {
            /** @var \Stepzerosolutions\Tbslider\Api\Data\SliderInterface $sliderDataObject */
            $sliderDataObject = $this->sliderDataFactory->create()
                ->setId($slider->getId())
                ->setSlideritemTitle($slider->getSlideritemTitle())
                ->setSlideritemDescription($slider->getSlideritemDescription())
                ->setSlideritemSlider($slider->getSlideritemSlider())
                ->setSliderImagePath($slider->getSliderImagePath())
                ->setSliderImageMdPath($slider->getSliderImageMdPath())
                ->setSliderImageSmPath($slider->getSliderImageSmPath())
                ->setSliderImageXsPath($slider->getSliderImageXsPath())
                ->setSliderUrl($slider->getSliderUrl())
                ->setDate($slider->getDate())
                ->setTimestamp($slider->getTimestamp())
                ->setSliderSort($slider->getSliderSort())
                ->setIsActive($slider->getIsActive());
            $data = $slider->getData();
            $data = $this->extensionAttributesJoinProcessor->extractExtensionAttributes($sliderInterfaceName, $data);
            if (isset($data[ExtensibleDataInterface::EXTENSION_ATTRIBUTES_KEY])
                && ($data[ExtensibleDataInterface::EXTENSION_ATTRIBUTES_KEY] instanceof GroupExtensionInterface)
            ) {
                $groupDataObject->setExtensionAttributes($data[ExtensibleDataInterface::EXTENSION_ATTRIBUTES_KEY]);
            }
            $slider[] = $sliderDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($slider);
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param FilterGroup $filterGroup
     * @param Collection $collection
     * @return void
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function addFilterGroupToCollection(FilterGroup $filterGroup, Collection $collection)
    {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = $this->translateField($filter->getField());
            $conditions[] = [$condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * Translates a field name to a DB column name for use in collection queries.
     *
     * @param string $field a field name that should be translated to a DB column name.
     * @return string
     */
    protected function translateField($field)
    {
        switch ($field) {
            case slideritemsInterface::SLIDERITEM_ID:
                return 'slideritem_id';
            case slideritemsInterface::SLIDERITEM_TITLE:
                return 'slideritem_title';
            default:
                return $field;
        }
    }

    /**
     * Delete Slider Item.
     *
     * @param SliderInterface $slideritems
     * @return bool true on success
     * @throws \Magento\Framework\Exception\StateException If customer group cannot be deleted
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(slideritemsInterface $slideritems)
    {
        return $this->deleteById($slideritems->getId());
    }

    /**
     * Delete Slider items by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException If customer group cannot be deleted
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id)
    {
        $slideritemModel = $this->slideritemsRegistry->retrieve($id);
		$imagename = array();
		$imagename[] = $slideritemModel->getSliderImagePath();
		$imagename[] = $slideritemModel->getSliderImageMdPath();
		$imagename[] = $slideritemModel->getSliderImageSmPath();
		$imagename[] = $slideritemModel->getSliderImageXsPath();
		
		$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
			->getDirectoryRead(DirectoryList::MEDIA);
		$result = $mediaDirectory->getAbsolutePath();
	
		
        if ($id <= 0 ) {
            throw new \Magento\Framework\Exception\StateException(__('Cannot delete Slider item.'));
        }

        $slideritemModel->delete();
        $this->slideritemsRegistry->remove($id);
		foreach( $imagename as $image ){
			$imagefile = $result . $image;
			$this->_imageprocessor->deleteImage($imagefile);
		}
        return true;
    }

    /**
     * Validate Slider Item values.
     *
     * @param \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface $slider
     * @throws InputException
     * @return void
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function _validate($slider)
    {
        $exception = new InputException();
        if (!\Zend_Validate::is($slider->getSlideritemTitle(), 'NotEmpty')) {
            $exception->addError(__(InputException::REQUIRED_FIELD, ['fieldName' => 'slideritem_title']));
        }

        if ($exception->wasErrorAdded()) {
            throw $exception;
        }
    }


}
