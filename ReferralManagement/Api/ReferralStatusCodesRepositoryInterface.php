<?php

namespace WolfSellers\ReferralManagement\Api;

use WolfSellers\ReferralManagement\Api\Data\ReferralStatusCodesInterface;

interface ReferralStatusCodesRepositoryInterface
{
    /**
     * @param \WolfSellers\ReferralManagement\Api\Data\ReferralStatusCodesInterface | \Magento\Framework\Model\AbstractModel $referralStatusCodes
     * @return \WolfSellers\ReferralManagement\Api\Data\ReferralStatusCodesInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(ReferralStatusCodesInterface $referralStatusCodes): ReferralStatusCodesInterface;

    /**
     * @param int $referralStatusCodesId
     * @return \WolfSellers\ReferralManagement\Api\Data\ReferralStatusCodesInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $referralStatusCodesId): ReferralStatusCodesInterface;
}
