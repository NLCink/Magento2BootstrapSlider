<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Items;

/**
 * @stepzerosolutions
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Stepzerosolutions\Tbslider\Model\Slider\Items', 'Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Items');
    }

}
