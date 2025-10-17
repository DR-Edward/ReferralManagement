<?php

namespace WolfSellers\ReferralManagement\Api\Data;

interface ReferralDetailsInterface
{
    public function getEntityId();

    public function getFirstName(): ?string;

    public function setFirstName(string $firstName): ReferralDetailsInterface;

    public function getLastName(): ?string;

    public function setLastName(string $lastName): ReferralDetailsInterface;

    public function getEmail(): string;

    public function setEmail(string $email): ReferralDetailsInterface;

    public function getTelephone(): ?string;

    public function setTelephone(string $telephone): ReferralDetailsInterface;

    public function getStatusId(): int;

    public function setStatusId(int $statusId): ReferralDetailsInterface;

    public function getCustomerId(): int;

    public function setCustomerId(int $customerId): ReferralDetailsInterface;

    public function getDeletedAt(): ?\DateTime;

    public function setDeletedAt(?\DateTime $deletedAt): ReferralDetailsInterface;

    public function getIsDeleted(): bool;
}
