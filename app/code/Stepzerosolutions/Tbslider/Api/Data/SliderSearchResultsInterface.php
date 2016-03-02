<?php
/**
 * Copyright © 2015  Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Api\Data;

/**
 * Interface for Slider search results.
 */
interface SliderSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Slider list.
     *
     * @api
     * @return \Stepzerosolutions\Tbslider\Api\Data\SliderInterface[]
     */
    public function getItems();

    /**
     * Set Slider list.
     *
     * @api
     * @param \Stepzerosolutions\Tbslider\Api\Data\SliderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
