<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Block\Adminhtml\Slideritems;

use Stepzerosolutions\Tbslider\Api\SlideritemsInterface;
use Stepzerosolutions\Tbslider\Api\SlideritemsRepositoryInterface;
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
     * @var SlideritemsRepositoryInterface
     */
    protected $slideritemsRepository;


    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SlideritemsRepositoryInterface $slideritemsRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        SlideritemsRepositoryInterface $slideritemsRepository,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->slideritemsRepository = $slideritemsRepository;
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
        $this->_controller = 'adminhtml_slideritems';
        $this->_blockGroup = 'Stepzerosolutions_Tbslider';

        $this->buttonList->update('save', 'label', __('Save Slideritems'));
        $this->buttonList->update('delete', 'label', __('Delete Slideritems'));

        $slideritemsId = $this->coreRegistry->registry(RegistryConstants::CURRENT_SLIDERITEM_ID);
        if (!$slideritemsId ) {
            $this->buttonList->remove('delete');
        }
		

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'block_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
                }
            }
        ";
    }

    /**
     * Retrieve the header text, either editing an existing group or creating a new one.
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        $slideritemsId = $this->coreRegistry->registry(RegistryConstants::CURRENT_SLIDERITEM_ID);
        if ($slideritemsId === null) {
            return __('New Slideritems');
        } else {
            $slideritems = $this->slideritemsRepository->getById($slideritemsId);
            return __('Edit Slideritems "%1"', $this->escapeHtml($slideritems->getSlideritemsTitle()));
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
