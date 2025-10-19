<?php

namespace WolfSellers\ReferralManagement\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use WolfSellers\ReferralManagement\Api\Data\ReferralStatusCodesInterface;
use WolfSellers\ReferralManagement\Api\ReferralStatusCodesRepositoryInterface;
use WolfSellers\ReferralManagement\Model\ResourceModel\ReferralStatusCodes as ResourceReferralStatusCodes;;
use WolfSellers\ReferralManagement\Model\ReferralStatusCodes;
use WolfSellers\ReferralManagement\Model\ReferralStatusCodesFactory;

class ReferralStatusCodesRepository implements ReferralStatusCodesRepositoryInterface
{
    /**
     * @var ResourceReferralStatusCodes
     */
    private $referralDetailsResourceModel;
    /**
     * @var \WolfSellers\ReferralManagement\Model\ReferralStatusCodesFactory
     */
    private $referralStatusCodesFactory;

    public function __construct(
        ResourceReferralStatusCodes $referralDetailsResourceModel,
        ReferralStatusCodesFactory $referralStatusCodesFactory
    ) {
        $this->referralDetailsResourceModel = $referralDetailsResourceModel;
        $this->referralStatusCodesFactory = $referralStatusCodesFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ReferralStatusCodesInterface $referralStatusCodes): ReferralStatusCodesInterface
    {
        if (!($referralStatusCodes instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('The implementation of ReferralDetails has changed'));
        }
        try {
            $this->referralDetailsResourceModel->save($referralStatusCodes);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $referralStatusCodes;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $referralStatusCodesId): ReferralStatusCodesInterface
    {
        /** @var ReferralStatusCodes $referralStatusCodes */
        $referralStatusCodes = $this->referralStatusCodesFactory->create();
        $this->referralDetailsResourceModel->load($referralStatusCodes, $referralStatusCodesId);
        if (!$referralStatusCodes->getId()) {
            throw new NoSuchEntityException(__('Status id not found'));
        }
        return $referralStatusCodes;
    }
}
