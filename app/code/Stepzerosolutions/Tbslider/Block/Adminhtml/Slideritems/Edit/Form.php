<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Block\Adminhtml\Slideritems\Edit;

use Stepzerosolutions\Tbslider\Controller\RegistryConstants;

/**
 * Adminhtml customer groups edit form
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{


    /**
     * @var \Stepzerosolutions\Tbslider\Api\SlideritemsRepositoryInterface
     */
    protected $_slideritemsRepository;

    /**
     * @var \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterfaceFactory
     */
    protected $slideritemsDataFactory;

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
	

    /**
     * @var \Stepzerosolutions\Tbslider\Model\Source
     */
    protected $sliderSource;

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
	
	
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Stepzerosolutions\Tbslider\Api\SlideritemsRepositoryInterface $slideritemsRepository
     * @param \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterfaceFactory $sliderDataFactory
	 * @param \Stepzerosolutions\Tbslider\Helper\Data $slideritemsHelper
	 * @param \Stepzerosolutions\Tbslider\Model\Source $sliderSource,
	 * @param \Magento\Store\Model\System\Store $systemStore
	 * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Stepzerosolutions\Tbslider\Api\SlideritemsRepositoryInterface $slideritemsRepository,
        \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterfaceFactory $slideritemsDataFactory,
		\Stepzerosolutions\Tbslider\Model\Source $sliderSource,
		\Magento\Store\Model\System\Store $systemStore,
		\Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    ) {
        $this->_slideritemsRepository = $slideritemsRepository;
        $this->slideritemsDataFactory = $slideritemsDataFactory;
		$this->_systemStore = $systemStore;
		$this->sliderSource = $sliderSource;
		$this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form for render
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('tbslider/*/save'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ],
            ]
		);

        $slideritemsId = $this->_coreRegistry->registry(RegistryConstants::CURRENT_SLIDERITEM_ID);
        /** @var \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface $slideritem */
        if ($slideritemsId === null) {
            $slider = $this->slideritemsDataFactory->create();
        } else {
            $slider = $this->_slideritemsRepository->getById($slideritemsId);
        }
		
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Slider item Information')]);
        $validateClass ='required-entry validate-length maximum-length-100';
        $slideritemTitle = $fieldset->addField(
            'slideritem_title',
            'text',
            [
                'name' => 'slideritem_title',
                'label' => __('Title'),
                'title' => __('Title'),
                'class' => $validateClass,
                'required' => true
            ]
        );


       $fieldset->addField(
            'slideritem_description',
            'editor',
            [
                'name' => 'slideritem_description',
                'label' => __('Content'),
                'title' => __('Content'),
                'style' => 'height:25em',
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );
		

        $fieldset->addField(
            'slideritem_slider',
            'select',
            [
                'name' => 'slideritem_slider',
                'label' => __('Select Slider'),
                'class' => 'required-entry',
                'values' => $this->sliderSource->toOptionArray(),
                'value' => isset($formValues['slideritem_slider']) ? $formValues['slideritem_slider'] : [],
                'required' => true,
            ]
        );
		
        $slideritemTitle = $fieldset->addField(
            'slider_url',
            'text',
            [
                'name' => 'slider_url',
                'label' => __('URL'),
                'title' => __('URL'),
                'class' => ''
            ]
        );
		
		
        $fieldset->addField(
            'filename',
            'image',
            [
                'title' => __('Slider Image'),
                'label' => __('Slider Image'),
                'name' => 'filename',
                'note' => 'Allow image type: jpg, jpeg, gif, png',
				'class' => 'required-entry',
				'required' => true,
            ]
        );
		
		
		
        $fieldset->addField(
            'filenamemd',
            'image',
            [
                'title' => __('Slider Image (Medium Devices). Leave empty for auto generate'),
                'label' => __('Slider Image (Medium Devices). Leave empty for auto generate'),
                'name' => 'filenamemd',
                'note' => 'Allow image type: jpg, jpeg, gif, png',
            ]
        );
		
		
		
        $fieldset->addField(
            'filenamesm',
            'image',
            [
                'title' => __('Slider Image (Small Devices). Leave empty for auto generate'),
                'label' => __('Slider Image (Small Devices). Leave empty for auto generate'),
                'name' => 'filenamesm',
                'note' => 'Allow image type: jpg, jpeg, gif, png',
            ]
        );
		
		
		
        $fieldset->addField(
            'filenamexs',
            'image',
            [
                'title' => __('Slider Image (Extra Small Devices). Leave empty for auto generate'),
                'label' => __('Slider Image (Extra Small Devices). Leave empty for auto generate'),
                'name' => 'filenamexs',
                'note' => 'Allow image type: jpg, jpeg, gif, png',
            ]
        );
		
		
        $fieldset->addField(
            'is_active',
            'select',
            [
                'label' => __('Is Active'),
                'title' => __('Is Active'),
                'name' => 'is_active',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );
		
		
        $slideritemTitle = $fieldset->addField(
            'slider_sort',
            'text',
            [
                'name' => 'slider_sort',
                'label' => __('Sort Order'),
                'title' => __('Sort Order'),
                'class' => 'validate-length maximum-length-4',
				'width' => '80px'
            ]
        );

		//var_dump($slider->getData());
        if ($slider->getId() !== null) {
            // If edit add id
            $form->addField('id', 'hidden', ['name' => 'id', 'value' => $slider->getId()]);
        }

        if ($this->_backendSession->getslideritemsData()) {
            $form->addValues($this->_backendSession->getslideritemsData());
            $this->_backendSession->setslideritemsData(null);
        } else {
            // TODO: need to figure out how the DATA can work with forms
			$filename = ( !empty($slider->getSliderImagePath()) )?$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ) . $slider->getSliderImagePath():null;
			$filenamemd = ( !empty($slider->getSliderImageMdPath()) )?$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ) . $slider->getSliderImageMdPath():null;
			$filenamesm = ( !empty($slider->getSliderImageSmPath()) )?$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ) . $slider->getSliderImageSmPath():null;
			$filenamexs = ( !empty($slider->getSliderImageXsPath()) )?$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ) . $slider->getSliderImageXsPath():null;
            $form->addValues(
                [
                    'slideritem_id' => $slider->getId(),
                    'slideritem_title' => $slider->getSlideritemTitle(),
					'slideritem_description' => $slider->getSlideritemDescription(),
					'filename' => $filename,
					'filenamemd' => $filenamemd,
					'filenamesm' => $filenamesm,
					'filenamexs' => $filenamexs,
					'slideritem_slider' => $slider->getSlideritemSlider(),
					'is_active' => $slider->getIsActive(),
					'slider_sort' => $slider->getSliderSort()
                ]
            );
        }
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('tbslider/*/save'));
        $form->setMethod('post');
        $this->setForm($form);
    }
	
    /**
     * Extract slider data in a format which is
     *
     * @param \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterfaceFactory $sliderRule
     * @return array
     */
    protected function extractSliderData($sliderRule)
    {
        $sliderData = [
            'slideritem_slider' => $sliderRule->getSlideritemSlider(),
        ];
        return $sliderData;
    }
}
