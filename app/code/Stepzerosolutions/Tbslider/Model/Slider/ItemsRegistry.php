<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Model\Slider;

use Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Registry for Slider items models
 */
class ItemsRegistry
{
    /**
     * @var array
     */
    protected $registry = [];

    /**
     * @var slideritemsFactory
     */
    protected $slideritemsFactory;

    /**
     * @param ItemsFactory $slideritemsFactory
     */
    public function __construct(ItemsFactory $slideritemsFactory)
    {
        $this->slideritemsFactory = $slideritemsFactory;
    }

    /**
     * Get instance of the Slideritem Model identified by an id
     *
     * @param int $slideritemId
     * @return Slider
     * @throws NoSuchEntityException
     */
    public function retrieve($slideritemId)
    {
        if (isset($this->registry[$slideritemId])) {
            return $this->registry[$slideritemId];
        }
        $slideritems = $this->slideritemsFactory->create();
        $slideritems->load($slideritemId);
        if ($slideritems->getId() === null || $slideritems->getId() != $slideritemId) {
            throw NoSuchEntityException::singleField(SlideritemsInterface::SLIDERITEM_ID, $slideritemId);
        }
        $this->registry[$slideritemId] = $slideritems;
        return $slideritems;
    }

    /**
     * Remove an instance of the Slider items Model from the registry
     *
     * @param int $slideritemId
     * @return void
     */
    public function remove($slideritemId)
    {
        unset($this->registry[$slideritemId]);
    }
}
