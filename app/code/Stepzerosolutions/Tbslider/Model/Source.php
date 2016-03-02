<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Model;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Convert\DataObject as Converter;
use Stepzerosolutions\Tbslider\Api\SliderRepositoryInterface;

/**
 * Slider source model.
 */
class Source implements \Magento\Framework\Data\OptionSourceInterface
{
    /** @var array */
    protected $options;

    /** @var SliderRepositoryInterface */
    protected $sliderRepository;

    /** @var SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /** @var Converter */
    protected $converter;

    /**
     * Initialize dependencies.
     *
     * @param SliderRepositoryInterface $sliderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Converter $converter
     */
    public function __construct(
        SliderRepositoryInterface $sliderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Converter $converter
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->converter = $converter;
    }

    /**
     * Retrieve all tax rates as an options array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $searchResults = $this->sliderRepository->getList($searchCriteria);
            $this->options = $this->converter->toOptionArray(
                $searchResults->getItems(),
                Slider::ID,
                Slider::SLIDER_TITLE
            );
        }
        return $this->options;
    }
}
