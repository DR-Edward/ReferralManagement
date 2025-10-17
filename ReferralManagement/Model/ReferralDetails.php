<?php

namespace WolfSellers\ReferralManagement\Model;

use Magento\Framework\Model\AbstractModel;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface;
use WolfSellers\ReferralManagement\Model\ResourceModel\ReferralDetails as ResourceReferralDetails;

class ReferralDetails extends AbstractModel implements ReferralDetailsInterface
{
    protected function _construct()
    {
        $this->_init(ResourceReferralDetails::class);
    }

    public function getFirstName(): ?string
    {
        return ($this->hasData('first_name')) ? (string) $this->getData('first_name') : null;
    }

    public function setFirstName(string $firstName): ReferralDetailsInterface
    {
        $this->setData('first_name', $firstName);
        return $this;
    }

    public function getLastName(): ?string
    {
        return ($this->hasData('last_name')) ? (string) $this->getData('last_name') : null;
    }

    public function setLastName(string $lastName): ReferralDetailsInterface
    {
        $this->setData('last_name', $lastName);
        return $this;
    }

    public function getEmail(): string
    {
        return (string) $this->getData('email');
    }

    public function setEmail(string $email): ReferralDetailsInterface
    {
        $this->setData('email', $email);
        return $this;
    }

    public function getTelephone(): ?string
    {
        return ($this->hasData('telephone')) ? (string) $this->getData('telephone') : null;
    }

    public function setTelephone(string $telephone): ReferralDetailsInterface
    {
        $this->setData('telephone', $telephone);
        return $this;
    }

    public function getStatusId(): int
    {
        return (int) $this->getData('status_id');
    }

    public function setStatusId(int $statusId): ReferralDetailsInterface
    {
        $this->setData('status_id', $statusId);
        return $this;
    }

    public function getCustomerId(): int
    {
        return (int) $this->getData('customer_id');
    }

    public function setCustomerId(int $customerId): ReferralDetailsInterface
    {
        $this->setData('customer_id', $customerId);
        return $this;
    }

    public function getDeletedAt(): ?\DateTime
    {
        $dateString = $this->getData('deleted_at');
        return ($dateString) ? new \DateTime($dateString) : null;
    }

    public function setDeletedAt(?\DateTime $deletedAt): ReferralDetailsInterface
    {
        if ($deletedAt) {
            $deletedAt = $deletedAt->format('Y-m-d H:i:s');
        }
        $this->setdata('deleted_at', $deletedAt);
        return $this;
    }

    public function getIsDeleted(): bool
    {
        return (bool) $this->getData('deleted_at');
    }
}
