<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Model\ResourceModel;

use Stepzerosolutions\Tbslider\Api\Data\SliderInterface;
use Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Collection;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\State\InvalidTransitionException;


/**
 * Slider CRUD class
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SliderRepository implements \Stepzerosolutions\Tbslider\Api\SliderRepositoryInterface
{


    /**
     * @var \Stepzerosolutions\Tbslider\Model\SliderRegistry
     */
    protected $sliderRegistry;

    /**
     * @var \Stepzerosolutions\Tbslider\Model\SliderFactory
     */
    protected $sliderFactory;

    /**
     * @var \Stepzerosolutions\Tbslider\Api\Data\SliderInterfaceFactory
     */
    protected $sliderDataFactory;

    /**
     * @var \Stepzerosolutions\Tbslider\Model\ResourceModel\slider
     */
    protected $sliderResourceModel;

    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Stepzerosolutions\Tbslider\Api\Data\SliderSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;
	
    /**
     * @param \Stepzerosolutions\Tbslider\Model\SliderRegistry $sliderRegistry
     * @param \Stepzerosolutions\Tbslider\Model\SliderFactory $sliderFactory
     * @param \Stepzerosolutions\Tbslider\Api\Data\SliderInterfaceFactory $sliderDataFactory
     * @param \Stepzerosolutions\Tbslider\Model\ResourceModel\Slider $sliderResourceModel
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
	 * @param \Stepzerosolutions\Tbslider\Api\Data\SliderSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        \Stepzerosolutions\Tbslider\Model\SliderRegistry $sliderRegistry,
        \Stepzerosolutions\Tbslider\Model\SliderFactory $sliderFactory,
        \Stepzerosolutions\Tbslider\Api\Data\SliderInterfaceFactory $sliderDataFactory,
        \Stepzerosolutions\Tbslider\Model\ResourceModel\Slider $sliderResourceModel,
		\Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Stepzerosolutions\Tbslider\Api\Data\SliderSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->sliderRegistry = $sliderRegistry;
        $this->sliderFactory = $sliderFactory;
        $this->sliderDataFactory = $sliderDataFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->sliderResourceModel = $sliderResourceModel;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Stepzerosolutions\Tbslider\Api\Data\SliderInterface $slider)
    {
        $this->_validate($slider);

        /** @var \Stepzerosolutions\Tbslider\Model\Bookings\Slider $sliderModel */
        $sliderModel = null;
        if ($slider->getId()) {
            $sliderModel = $this->sliderRegistry->retrieve($slider->getId());
            $sliderDataAttributes = $this->dataObjectProcessor->buildOutputDataArray(
                $slider,
                '\Stepzerosolutions\Tbslider\Api\Data\SliderInterface'
            );
            foreach ($sliderDataAttributes as $attributeCode => $attributeData) {
                $sliderModel->setDataUsingMethod($attributeCode, $attributeData);
            }
        } else {
            $sliderModel = $this->sliderFactory->create();
            $sliderModel->setSliderTitle($slider->getSliderTitle());
			$sliderModel->setSliderDescription($slider->getSliderDescription());
			$sliderModel->setSliderWidth($slider->getSliderWidth());
			$sliderModel->setSliderHeight($slider->getSliderHeight());
			$sliderModel->setSliderWidthxs($slider->getSliderWidthxs());
			$sliderModel->setSliderHeightxs($slider->getSliderHeightxs());
			$sliderModel->setSliderWidthsm($slider->getSliderWidthsm());
			$sliderModel->setSliderHeightsm($slider->getSliderHeightsm());
			$sliderModel->setSliderWidthmd($slider->getSliderWidthmd());
			$sliderModel->setSliderHeightmd($slider->getSliderHeightmd());
			$sliderModel->setSliderClass($slider->getSliderClass());
			$sliderModel->setSliderBgcolor($slider->getSliderBgcolor());
			$sliderModel->setSliderAutoresponsive($slider->getSliderAutoresponsive());
			$sliderModel->setSliderType($slider->getSliderType());
			$sliderModel->setPauseonhover($slider->getPauseonhover());
			$sliderModel->setWrap($slider->getWrap());
			$sliderModel->setKeyboard($slider->getKeyboard());
			$sliderModel->setSlidermeta($slider->getSlidermeta());
			$sliderModel->setSliderHidexs($slider->getSliderHidexs());
			$sliderModel->setSliderDuration($slider->getSliderDuration());
			$sliderModel->setDate($slider->getDate());
			$sliderModel->setStatus($slider->getStatus());
			$sliderModel->setTimestamp($slider->getTimestamp());
			$sliderModel->setStores($slider->getStores());
        }
        try {
            $this->sliderResourceModel->save($sliderModel);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            /**
             * Would like a better way to determine this error condition but
             *  difficult to do without imposing more database calls
             */
            if ($e->getMessage() == (string)__('Slider already exists.')) {
                throw new InvalidTransitionException(__('Slider already exists.'));
            }
            throw $e;
        }

        $this->sliderRegistry->remove($sliderModel->getId());

        $sliderDataObject = $this->sliderDataFactory->create();
		$sliderDataObject->setSliderTitle($sliderModel->getSliderTitle());
		$sliderDataObject->setSliderDescription($sliderModel->getSliderDescription());
		$sliderDataObject->setSliderWidth($sliderModel->getSliderWidth());
		$sliderDataObject->setSliderHeight($sliderModel->getSliderHeight());
		$sliderDataObject->setSliderWidthxs($slider->getSliderWidthxs());
		$sliderDataObject->setSliderHeightxs($sliderModel->getSliderHeightxs());
		$sliderDataObject->setSliderWidthsm($sliderModel->getSliderWidthsm());
		$sliderDataObject->setSliderHeightsm($sliderModel->getSliderHeightsm());
		$sliderDataObject->setSliderWidthmd($sliderModel->getSliderWidthmd());
		$sliderDataObject->setSliderHeightmd($sliderModel->getSliderHeightmd());
		$sliderDataObject->setSliderClass($sliderModel->getSliderClass());
		$sliderDataObject->setSliderBgcolor($sliderModel->getSliderBgcolor());
		$sliderDataObject->setSliderAutoresponsive($sliderModel->getSliderAutoresponsive());
		$sliderDataObject->setSliderType($sliderModel->getSliderType());
		$sliderDataObject->setPauseonhover($sliderModel->getPauseonhover());
		$sliderDataObject->setWrap($sliderModel->getWrap());
		$sliderDataObject->setKeyboard($sliderModel->getKeyboard());
		$sliderDataObject->setSlidermeta($sliderModel->getSlidermeta());
		$sliderDataObject->setSliderHidexs($sliderModel->getSliderHidexs());
		$sliderDataObject->setSliderDuration($sliderModel->getSliderDuration());
		$sliderDataObject->setDate($sliderModel->getDate());
		$sliderDataObject->setStatus($sliderModel->getStatus());
		$sliderDataObject->setTimestamp($sliderModel->getTimestamp());
		$sliderDataObject->setStores($sliderModel->getStores());
        return $sliderDataObject;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $sliderModel = $this->sliderRegistry->retrieve($id);
        $sliderDataObject = $this->sliderDataFactory->create();
        $sliderDataObject->setId($sliderModel->getId());
		$sliderDataObject->setSliderTitle($sliderModel->getSliderTitle());
		$sliderDataObject->setSliderDescription($sliderModel->getSliderDescription());
		$sliderDataObject->setSliderWidth($sliderModel->getSliderWidth());
		$sliderDataObject->setSliderHeight($sliderModel->getSliderHeight());
		$sliderDataObject->setSliderWidthxs($sliderModel->getSliderWidthxs());
		$sliderDataObject->setSliderHeightxs($sliderModel->getSliderHeightxs());
		$sliderDataObject->setSliderWidthsm($sliderModel->getSliderWidthsm());
		$sliderDataObject->setSliderHeightsm($sliderModel->getSliderHeightsm());
		$sliderDataObject->setSliderWidthmd($sliderModel->getSliderWidthmd());
		$sliderDataObject->setSliderHeightmd($sliderModel->getSliderHeightmd());
		$sliderDataObject->setSliderClass($sliderModel->getSliderClass());
		$sliderDataObject->setSliderBgcolor($sliderModel->getSliderBgcolor());
		$sliderDataObject->setSliderAutoresponsive($sliderModel->getSliderAutoresponsive());
		$sliderDataObject->setSliderType($sliderModel->getSliderType());
		$sliderDataObject->setPauseonhover($sliderModel->getPauseonhover());
		$sliderDataObject->setWrap($sliderModel->getWrap());
		$sliderDataObject->setKeyboard($sliderModel->getKeyboard());
		$sliderDataObject->setSlidermeta($sliderModel->getSlidermeta());
		$sliderDataObject->setSliderHidexs($sliderModel->getSliderHidexs());
		$sliderDataObject->setSliderDuration($sliderModel->getSliderDuration());
		$sliderDataObject->setDate($sliderModel->getDate());
		$sliderDataObject->setStatus($sliderModel->getStatus());
		$sliderDataObject->setTimestamp($sliderModel->getTimestamp());
		$sliderDataObject->setStores($sliderModel->getStores());
        return $sliderDataObject;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Collection $collection */
        $collection = $this->sliderFactory->create()->getCollection();
        $sliderInterfaceName = 'Stepzerosolutions\Tbslider\Api\Data\SliderInterface';
		//die( var_dump($collection) );


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
            $field = $this->translateField('slider_id');
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        /** @var \Stepzerosolutions\Tbslider\Api\Data\SliderInterface[] $slider */
        $groups = [];
        /** @var \Stepzerosolutions\Tbslider\Model\Slider $slider */
        foreach ($collection as $slide) {
            /** @var \Stepzerosolutions\Tbslider\Api\Data\SliderInterface $sliderDataObject */
            $sliderDataObject = $this->sliderDataFactory->create()
                ->setId($slide->getId())
                ->setSliderTitle($slide->getSliderTitle());
            $data = $slide->getData();
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
            case SliderInterface::ID:
                return 'slider_id';
            case SliderInterface::SLIDER_TITLE:
                return 'slider_title';
            default:
                return $field;
        }
    }

    /**
     * Delete variation types.
     *
     * @param SliderInterface $slider
     * @return bool true on success
     * @throws \Magento\Framework\Exception\StateException If customer group cannot be deleted
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(sliderInterface $slider)
    {
        return $this->deleteById($slider->getId());
    }

    /**
     * Delete Slider by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException If customer group cannot be deleted
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id)
    {
        $sliderModel = $this->sliderRegistry->retrieve($id);

        if ($id <= 0 ) {
            throw new \Magento\Framework\Exception\StateException(__('Cannot delete Slider.'));
        }

        $sliderModel->delete();
        $this->sliderRegistry->remove($id);
        return true;
    }

    /**
     * Validate variation types values.
     *
     * @param \Stepzerosolutions\Tbslider\Api\Data\SliderInterface $slider
     * @throws InputException
     * @return void
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function _validate($slider)
    {
        $exception = new InputException();
        if (!\Zend_Validate::is($slider->getSliderTitle(), 'NotEmpty')) {
            $exception->addError(__(InputException::REQUIRED_FIELD, ['fieldName' => 'slider_title']));
        }

        if ($exception->wasErrorAdded()) {
            throw $exception;
        }
    }
	
	public function getSliderStoreList( $slider ){
		//var_dump($this->storeModel->create());
		$stores = $slider->getStores();
		if( empty( $stores ) ) return NULL;
		return $stores;
	}


}
