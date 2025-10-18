<?php

namespace WolfSellers\ReferralManagement\Api\Data;

interface ReferralDetailsInterface
{
    /**
     * @return mixed
     */
    public function getEntityId();

    /**
     * @return string|null
     */
    public function getFirstName(): ?string;

    /**
     * @param string $firstName
     * @return ReferralDetailsInterface
     */
    public function setFirstName(string $firstName): ReferralDetailsInterface;

    /**
     * @return string|null
     */
    public function getLastName(): ?string;

    /**
     * @param string $lastName
     * @return ReferralDetailsInterface
     */
    public function setLastName(string $lastName): ReferralDetailsInterface;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return ReferralDetailsInterface
     */
    public function setEmail(string $email): ReferralDetailsInterface;

    /**
     * @return string|null
     */
    public function getTelephone(): ?string;

    /**
     * @param string $telephone
     * @return ReferralDetailsInterface
     */
    public function setTelephone(string $telephone): ReferralDetailsInterface;

    /**
     * @return int
     */
    public function getStatusId(): int;

    /**
     * @param int $statusId
     * @return ReferralDetailsInterface
     */
    public function setStatusId(int $statusId): ReferralDetailsInterface;

    /**
     * @return int
     */
    public function getCustomerId(): int;

    /**
     * @param int $customerId
     * @return ReferralDetailsInterface
     */
    public function setCustomerId(int $customerId): ReferralDetailsInterface;

    /**
     * @return \DateTime|null
     */
    public function getDeletedAt(): ?\DateTime;

    /**
     * @param \DateTime|null $deletedAt
     * @return ReferralDetailsInterface
     */
    public function setDeletedAt(?\DateTime $deletedAt): ReferralDetailsInterface;

    /**
     * @return bool
     */
    public function getIsDeleted(): bool;
}
