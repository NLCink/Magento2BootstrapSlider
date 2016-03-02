<?php
/**
 * Copyright © 2015  Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Api\Data;

/**
 * Interface for Slideritems search results.
 */
interface SlideritemsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Slider items list.
     *
     * @api
     * @return \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface[]
     */
    public function getItems();

    /**
     * Set Slider items  list.
     *
     * @api
     * @param \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
