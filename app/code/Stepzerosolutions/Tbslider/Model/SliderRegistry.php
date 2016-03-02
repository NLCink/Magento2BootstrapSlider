<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Model;

use Stepzerosolutions\Tbslider\Api\Data\SliderInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Registry for Slider models
 */
class SliderRegistry
{
    /**
     * @var array
     */
    protected $registry = [];

    /**
     * @var sliderFactory
     */
    protected $sliderFactory;

    /**
     * @param sliderFactory $sliderFactory
     */
    public function __construct(SliderFactory $sliderFactory)
    {
        $this->sliderFactory = $sliderFactory;
    }

    /**
     * Get instance of the Slider Model identified by an id
     *
     * @param int $sliderId
     * @return Slider
     * @throws NoSuchEntityException
     */
    public function retrieve($sliderId)
    {
        if (isset($this->registry[$sliderId])) {
            return $this->registry[$sliderId];
        }
        $slider = $this->sliderFactory->create();
        $slider->load($sliderId);
        if ($slider->getId() === null || $slider->getId() != $sliderId) {
            throw NoSuchEntityException::singleField(SliderInterface::ID, $sliderId);
        }
        $this->registry[$sliderId] = $slider;
        return $slider;
    }

    /**
     * Remove an instance of the Slider Model from the registry
     *
     * @param int $sliderId
     * @return void
     */
    public function remove($sliderId)
    {
        unset($this->registry[$sliderId]);
    }
}
