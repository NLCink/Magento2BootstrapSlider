<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Model\ResourceModel\Slider;

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
        $this->_init('Stepzerosolutions\Tbslider\Model\Slider', 'Stepzerosolutions\Tbslider\Model\ResourceModel\Slider');
    }
	

    /**
     * Filter collection by specified store ids
     *
     * @param array|int[] $storeIds
     * @return $this
     */
    public function addStoreFilter($storeIds)
    {
        $this->getSelect()->where('main_table.slider_id IN (?)', $storeIds);
        return $this;
    }
	
	public function addItemsList(){
        $this->getSelect()->joinLeft(
            ['slideritems_table' => $this->getTable('slider_items')],
            "main_table.slider_id = slideritems_table.slideritem_slider"
        );
		return $this;
	}
}
