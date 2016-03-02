<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Block\Adminhtml\Slider\Edit;

use Stepzerosolutions\Tbslider\Controller\RegistryConstants;
/**
 * Adminhtml customer groups edit form
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{


    /**
     * @var \Stepzerosolutions\Tbslider\Api\SliderRepositoryInterface
     */
    protected $_sliderRepository;

    /**
     * @var \Stepzerosolutions\Tbslider\Api\Data\SliderInterfaceFactory
     */
    protected $sliderDataFactory;

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
	
    /**
     * @var \Stepzerosolutions\Tbslider\Helper\Data
     */
    protected $_sliderHelper;
    /**
     * @var \Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Store\Collection
     */
	protected $sliderstoreCollectionFactory;

	
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Stepzerosolutions\Tbslider\Api\SliderRepositoryInterface $sliderRepository
     * @param \Stepzerosolutions\Tbslider\Api\Data\SliderInterfaceFactory $sliderDataFactory
	 * @param \Stepzerosolutions\Tbslider\Helper\Data $sliderHelper
	 * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Stepzerosolutions\Tbslider\Api\SliderRepositoryInterface $sliderRepository,
        \Stepzerosolutions\Tbslider\Api\Data\SliderInterfaceFactory $sliderDataFactory,
		\Stepzerosolutions\Tbslider\Helper\Data $sliderHelper,
		\Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_sliderRepository = $sliderRepository;
        $this->sliderDataFactory = $sliderDataFactory;
		$this->_systemStore = $systemStore;
		$this->_sliderHelper = $sliderHelper;
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
        $form = $this->_formFactory->create();

        $sliderId = $this->_coreRegistry->registry(RegistryConstants::CURRENT_SLIDER_ID);
        /** @var \Stepzerosolutions\Tbslider\Api\Data\sliderInterface $slider */
        if ($sliderId === null) {
            $slider = $this->sliderDataFactory->create();
        } else {
            $slider = $this->_sliderRepository->getById($sliderId);
        }
		
		// Get slider stores in an array, if not return null
		$sliderstores = $this->_sliderRepository->getSliderStoreList($slider);

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Slider Information')]);
        $validateClass ='required-entry validate-length maximum-length-100';
        $sliderTitle = $fieldset->addField(
            'slider_title',
            'text',
            [
                'name' => 'slider_title',
                'label' => __('Title'),
                'title' => __('Title'),
                'class' => $validateClass,
                'required' => true
            ]
        );

        $sliderDescription = $fieldset->addField(
            'slider_description',
            'textarea',
            [
                'name' => 'slider_description',
                'label' => __('Description'),
                'title' => __('Description'),
                'class' => $validateClass,
                'required' => true
            ]
        );
		
		
		
        /* Check is single store mode */
        if (!$this->_storeManager->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'stores[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true),
					'value' => $sliderstores
                ]
            );
            $renderer = $this->getLayout()->createBlock(
                'Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element'
            );
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'store_id',
                'hidden',
                ['name' => 'stores[]', 'value' => $this->_storeManager->getStore(true)->getId()]
            );
            $slider->setStoreId($this->_storeManager->getStore(true)->getId());
        }
		
		
        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')],
				'value' => (( empty($slider->getStatus()))?0:$slider->getStatus())
            ]
        );
		
		
		$responsiveFieldset = $form->addFieldset('responsive_fieldset', ['legend' => __('Responsive Information')]);
		$dimentionClass ='validate-length maximum-length-6';
        $sliderWidth = $responsiveFieldset->addField(
            'slider_width',
            'text',
            [
                'name' => 'slider_width',
                'label' => __('Width'),
                'title' => __('Width'),
                'class' => 'required-entry '.$dimentionClass,
				'note' => 'Add % sign for width in presentage',
                'required' => true
            ]
        );
        $sliderHeight = $responsiveFieldset->addField(
            'slider_height',
            'text',
            [
                'name' => 'slider_height',
                'label' => __('Height'),
                'title' => __('Height'),
				'note' => 'Insert "auto" to set auto height',
                'class' => 'required-entry '.$dimentionClass,
                'required' => true
            ]
        );

        $slider_widthxs = $responsiveFieldset->addField(
            'slider_widthxs',
            'text',
            [
                'name' => 'slider_widthxs',
                'label' => __('Mobile device width'),
                'title' => __('Mobile device width'),
                'class' => $dimentionClass
            ]
        );
        $slider_heighthxs = $responsiveFieldset->addField(
            'slider_heighthxs',
            'text',
            [
                'name' => 'slider_heighthxs',
                'label' => __('Mobile device height'),
                'title' => __('Mobile device height'),
                'class' => $dimentionClass
            ]
        );
        $slider_widthsm = $responsiveFieldset->addField(
            'slider_widthsm',
            'text',
            [
                'name' => 'slider_widthsm',
                'label' => __('Small device width'),
                'title' => __('Small device width'),
                'class' => $dimentionClass
            ]
        );
        $slider_heightsm = $responsiveFieldset->addField(
            'slider_heightsm',
            'text',
            [
                'name' => 'slider_heightsm',
                'label' => __('Small device height'),
                'title' => __('Small device height'),
                'class' => $dimentionClass
            ]
        );
        $slider_widthmd = $responsiveFieldset->addField(
            'slider_widthmd',
            'text',
            [
                'name' => 'slider_widthmd',
                'label' => __('Medium device width'),
                'title' => __('Medium device width'),
                'class' => $dimentionClass
            ]
        );
        $slider_heightmd = $responsiveFieldset->addField(
            'slider_heightmd',
            'text',
            [
                'name' => 'slider_heightmd',
                'label' => __('Medium device height'),
                'title' => __('Medium device height'),
                'class' => $dimentionClass
            ]
        );
		$designFieldset = $form->addFieldset('design_fieldset', ['legend' => __('Design Information')]);
		$designClass ='validate-length maximum-length-7';
        $slider_class = $designFieldset->addField(
            'slider_class',
            'text',
            [
                'name' => 'slider_class',
                'label' => __('CSS Class'),
                'title' => __('CSS Class'),
                'class' => $dimentionClass
            ]
        );
        $slider_bgcolor = $designFieldset->addField(
            'slider_bgcolor',
            'text',
            [
                'name' => 'slider_bgcolor',
                'label' => __('Background Color'),
                'title' => __('Background Color'),
                'class' => $designClass
            ]
        );
        $slider_autoresoponsive = $designFieldset->addField(
            'slider_autoresoponsive',
            'text',
            [
                'name' => 'slider_autoresoponsive',
                'label' => __('Auto Responsive'),
                'title' => __('Auto Responsive'),
                'class' => ''
            ]
        );
        $slider_type = $designFieldset->addField(
            'slider_type',
            'select',
            [
                'name' => 'slider_type',
                'label' => __('Slider Type'),
                'title' => __('Slider Type'),
                'class' => '',
				'options' => $this->_sliderHelper->getSliderTypeName(),
				'value' => (( empty($slider->getSliderType()))?0:$slider->getSliderType())
            ]
        );
        $pauseonhover = $designFieldset->addField(
            'pauseonhover',
            'select',
            [
                'name' => 'pauseonhover',
                'label' => __('Pause on hover'),
                'title' => __('Pause on hover'),
                'class' => '',
				'options' => ['1' => __('Enabled'), '0' => __('Disabled')],
				'value' => (( empty($slider->getPauseonhover()))?0:$slider->getPauseonhover())
            ]
        );
        $wrap = $designFieldset->addField(
            'wrap',
            'select',
            [
                'name' => 'wrap',
                'label' => __('Wrap'),
                'title' => __('Wrap'),
                'class' => '',
				'options' => ['1' => __('Enabled'), '0' => __('Disabled')],
				'value' => (( empty($slider->getWrap()))?0:$slider->getWrap())
            ]
        );
        $keyboard = $designFieldset->addField(
            'keyboard',
            'select',
            [
                'name' => 'keyboard',
                'label' => __('Keyboard'),
                'title' => __('Keyboard'),
                'class' => '',
				'options' => ['1' => __('Enabled'), '0' => __('Disabled')],
				'value' => (( empty($slider->getKeyboard()))?0:$slider->getKeyboard())
            ]
        );
        $slidermeta = $designFieldset->addField(
            'slidermeta',
            'text',
            [
                'name' => 'slidermeta',
                'label' => __('Slider Meta'),
                'title' => __('Slider Meta'),
                'class' => ''
            ]
        );
		
        $hidexs = $designFieldset->addField(
            'slider_hidexs',
            'select',
            [
                'name' => 'slider_hidexs',
                'label' => __('Hide On Mobile Devices'),
                'title' => __('Hide On Mobile Devices'),
                'class' => '',
				'options' => ['1' => __('Enabled'), '0' => __('Disabled')],
				'value' => (( empty($slider->getSliderHidexs()))?0:$slider->getSliderHidexs())
            ]
        );

        $duration = $designFieldset->addField(
            'slider_duration',
            'select',
            [
                'name' => 'slider_duration',
                'label' => __('Slider Durations'),
                'title' => __('Slider Duration'),
                'class' => '',
				'options' => ['500' => __('500'), '1000' => __('1000'), '2000' => __('2000'),
				'4000' => __('4000'), '5000' => __('5000'), '6000' => __('6000'), '7000' => __('7000'),
				'8000' => __('8000'), '9000' => __('9000'), '10000' => __('10000'), '15000' => __('15000'),
				'20000' => __('20000')],
				'value' => (( empty($slider->getSliderDuration()))?500:$slider->getSliderDuration())
            ]
        );

        if (!$slider->getId()) {
            $slider->setData('status', '0');
        }
		
		//var_dump($slider->getData());
        if ($slider->getId() !== null) {
            // If edit add id
            $form->addField('id', 'hidden', ['name' => 'id', 'value' => $slider->getId()]);
        }

        if ($this->_backendSession->getsliderData()) {
            $form->addValues($this->_backendSession->getsliderData());
            $this->_backendSession->setsliderData(null);
        } else {
            // TODO: need to figure out how the DATA can work with forms
            $form->addValues(
                [
                    'slider_id' => $slider->getId(),
                    'slider_title' => $slider->getSliderTitle(),
					'slider_description' => $slider->getSliderDescription(),
					'slider_width' => $slider->getSliderWidth(),
					'slider_height' => $slider->getSliderHeight()
                ]
            );
        }

        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('tbslider/*/save'));
        $form->setMethod('post');
        $this->setForm($form);
    }
}
