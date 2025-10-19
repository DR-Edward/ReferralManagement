<?php

namespace WolfSellers\ReferralManagement\Api\Data;

interface ReferralStatusCodesInterface
{
    public function getId();

    public function getCode(): string;

    public function setCode(string $code): ReferralStatusCodesInterface;

    public function getDescription(): string;

    public function setDescription(string $description): ReferralStatusCodesInterface;
}
