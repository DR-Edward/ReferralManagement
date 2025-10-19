<?php

namespace WolfSellers\ReferralManagement\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsSearchResultsInterface;
interface ReferralDetailsRepositoryInterface
{
    /**
     * @param \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface|\Magento\Framework\Model\AbstractModel $referralDetails
     * @return \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(ReferralDetailsInterface $referralDetails): ReferralDetailsInterface;

    /**
     * @param int $detailsId
     * @param bool $includeDeleted
     * @return \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $detailsId, $includeDeleted = false): ReferralDetailsInterface;

    /**
     * @param \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface|\Magento\Framework\Model\AbstractModel $referralDetails
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(ReferralDetailsInterface $referralDetails): bool;

    /**
     * @param int $detailsId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $detailsId): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param bool | null $includeDeleted
     * @return \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria, ?bool $includeDeleted = false): ReferralDetailsSearchResultsInterface;

    /**
     * @param \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface|\Magento\Framework\Model\AbstractModel $referralDetails
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function softDelete(ReferralDetailsInterface $referralDetails): bool;

    /**
     * @param int $referralId
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function softDeleteById(int $referralId): bool;

    /**
     * @param \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface|\Magento\Framework\Model\AbstractModel $referralDetails
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function restore(ReferralDetailsInterface $referralDetails): bool;

    /**
     * @param int $referralId
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function restoreById(int $referralId): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsSearchResultsInterface
     */
    public function getListWithDeleted(SearchCriteriaInterface $searchCriteria): ReferralDetailsSearchResultsInterface;
}
