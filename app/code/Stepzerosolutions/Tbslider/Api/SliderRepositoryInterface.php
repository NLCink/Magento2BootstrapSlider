<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
/**
 * Slider CRUD interface
 */
interface SliderRepositoryInterface
{
    /**
     * Save Slider.
     *
     * @api
     * @param \Stepzerosolutions\Tbslider\Api\Data\SliderInterface $slider
     * @return \Stepzerosolutions\Tbslider\Api\Data\SliderInterface
     * @throws \Magento\Framework\Exception\InputException If there is a problem with the input
     * @throws \Magento\Framework\Exception\NoSuchEntityException If a group ID is sent but the group does not exist
     * @throws \Magento\Framework\Exception\State\InvalidTransitionException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Stepzerosolutions\Tbslider\Api\Data\SliderInterface $slider);

    /**
     * Get Slider by id.
     *
     * @api
     * @param int $id
     * @return \Stepzerosolutions\Tbslider\Api\Data\SliderInterface 
     * @throws \Magento\Framework\Exception\NoSuchEntityException 
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve Slider list.
     *
     * The list of Sliders can be filtered by title.
     *
     * @api
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return Stepzerosolutions\Tbslider\Api\Data\SliderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Slider.
     *
     * @api
     * @param \Stepzerosolutions\Tbslider\Api\Data\SliderInterface $slider
     * @return bool true on success
     * @throws \Magento\Framework\Exception\StateException If customer group cannot be deleted
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Stepzerosolutions\Tbslider\Api\Data\SliderInterface $slider);

    /**
     * Delete Slider by ID.
     *
     * @api
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException If customer group cannot be deleted
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}
