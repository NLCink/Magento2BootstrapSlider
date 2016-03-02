<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Block\Adminhtml\Block\Grid\Renderer;

class Isactive extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Renders grid column
     *
     * @param   \Magento\Framework\DataObject $row
     * @return  string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
		$isactive = ( empty( $row->getIsActive() ) )?'Disabled':'Enabled';
        return '<span class="grid-row-title">' .
            $isactive .
            '</span>';
    }
}
