<?php

namespace WolfSellers\ReferralManagement\Actions;

use WolfSellers\ReferralManagement\Model\ReferralDetailsRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;

class UpdateStatus
{
    const STATUS_PENDING = 1;
    const STATUS_REGISTERED = 2;
    /**
     * @var ReferralDetailsRepository
     */
    private $referralDetailsRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        ReferralDetailsRepository $referralDetailsRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->referralDetailsRepository = $referralDetailsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function setRegisteredStatus(string $email)
    {
        $this->updateStatus($email, self::STATUS_REGISTERED);
    }

    public function updateStatus(string $email, int $statusId)
    {
        $this->searchCriteriaBuilder
            ->addFilter('email', $email)
            ->setCurrentPage(1)
            ->setPageSize(1);
        $items = $this->referralDetailsRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $referralDetails = reset($items);
        $referralDetails->setStatusId($statusId);
        $this->referralDetailsRepository->save($referralDetails);
    }
}
