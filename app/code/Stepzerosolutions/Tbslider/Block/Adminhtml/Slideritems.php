<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Block\Adminhtml;

/**
 * Adminhtml slideritems blocks content block
 */
class Slideritems extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Block constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'tbslider_slideritems';
        $this->_headerText = __('Slider Items');
        $this->_addButtonLabel = __('Add Slider Item');
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
