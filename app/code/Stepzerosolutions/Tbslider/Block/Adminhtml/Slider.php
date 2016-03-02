<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Block\Adminhtml;

/**
 * Adminhtml slider blocks content block
 */
class Slider extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Block constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'tbslider_slider';
        $this->_headerText = __('Slider');
        $this->_addButtonLabel = __('Add Slider');
        parent::_construct();
    }
	

    /**
     * Redefine header css class
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'icon-head head-customer-groups';
    }
}
