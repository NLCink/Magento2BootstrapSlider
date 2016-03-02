<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
/**
 * Slideritems CRUD interface
 */
interface SlideritemsRepositoryInterface
{
    /**
     * Save Slideritems.
     *
     * @api
     * @param \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface $slideritems
     * @return \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface
     * @throws \Magento\Framework\Exception\InputException If there is a problem with the input
     * @throws \Magento\Framework\Exception\NoSuchEntityException If a group ID is sent but the group does not exist
     * @throws \Magento\Framework\Exception\State\InvalidTransitionException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface $slideritems);

    /**
     * Get Slideritems by id.
     *
     * @api
     * @param int $id
     * @return \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface 
     * @throws \Magento\Framework\Exception\NoSuchEntityException 
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve Slideritems.
     *
     * The list of variations can be filtered by title.
     *
     * @api
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return Stepzerosolutions\Tbslider\Api\Data\SlideritemsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Slideritems.
     *
     * @api
     * @param \Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface $slideritems
     * @return bool true on success
     * @throws \Magento\Framework\Exception\StateException If customer group cannot be deleted
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface $slideritems);

    /**
     * Delete Slideritems by ID.
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
