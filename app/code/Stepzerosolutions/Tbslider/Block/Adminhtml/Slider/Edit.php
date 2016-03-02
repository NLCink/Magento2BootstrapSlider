<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Block\Adminhtml\Slider;

use Stepzerosolutions\Tbslider\Api\SliderInterface;
use Stepzerosolutions\Tbslider\Api\SliderRepositoryInterface;
use Stepzerosolutions\Tbslider\Controller\RegistryConstants;

/**
 * Customer group edit block
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var SliderRepositoryInterface
     */
    protected $sliderRepository;


    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SliderRepositoryInterface $sliderRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        SliderRepositoryInterface $sliderRepository,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->sliderRepository = $sliderRepository;
        parent::__construct($context, $data);
    }

    /**
     * Update Save and Delete buttons. Remove Delete button if group can't be deleted.
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_slider';
        $this->_blockGroup = 'Stepzerosolutions_Tbslider';

        $this->buttonList->update('save', 'label', __('Save Slider'));
        $this->buttonList->update('delete', 'label', __('Delete Slider'));

        $sliderId = $this->coreRegistry->registry(RegistryConstants::CURRENT_SLIDER_ID);
        if (!$sliderId ) {
            $this->buttonList->remove('delete');
        }
    }

    /**
     * Retrieve the header text, either editing an existing group or creating a new one.
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        $sliderId = $this->coreRegistry->registry(RegistryConstants::CURRENT_SLIDER_ID);
        if ($sliderId === null) {
            return __('New Slider');
        } else {
            $slider = $this->sliderRepository->getById($sliderId);
            return __('Edit Slider "%1"', $this->escapeHtml($slider->getSliderTitle()));
        }
    }

    /**
     * Retrieve CSS classes added to the header.
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'icon-head head-customer-groups';
    }
}
