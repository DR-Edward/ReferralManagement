<?php

namespace WolfSellers\ReferralManagement\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use WolfSellers\ReferralManagement\Actions\UpdateStatus;
use Psr\Log\LoggerInterface;

class UpdateRferralStatus implements ObserverInterface
{
    /**
     * @var UpdateStatus
     */
    private $updateStatus;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        UpdateStatus $updateStatus,
        LoggerInterface $logger
    ) {
        $this->updateStatus = $updateStatus;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $observer->getEvent()->getCustomer();
        try {
            $email = $customer->getEmail();
            $this->updateStatus->setRegisteredStatus($email);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
