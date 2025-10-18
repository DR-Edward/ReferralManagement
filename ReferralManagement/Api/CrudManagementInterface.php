<?php

namespace WolfSellers\ReferralManagement\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsSearchResultsInterface;

interface CrudManagementInterface
{
    /**
     * @param int $id
     * @return \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $id): ReferralDetailsInterface;

    /**
     * @param \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface $request
     * @return \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function create(ReferralDetailsInterface $request): ReferralDetailsInterface;

    /**
     * @param int $id
     * @return array<string, mixed> Json Response
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function delete(int $id): array;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ReferralDetailsSearchResultsInterface;
}
