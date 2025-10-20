<?php

namespace WolfSellers\ReferralManagement\Api;

use Magento\Framework\App\RequestInterface;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface;

interface ValidateReferralDetailsInterface
{
    public function enabled();

    public function validate(ReferralDetailsInterface $request);

    public function isCustomerAuthorized(int $customerId, int $referralId): bool;

    public function isCustomerLoggedInBySession() : bool;

    public function isReferralIdValidByPath(string $path) : int;

    public function validateFormKey(RequestInterface $request): bool;

    public function isEmailInRequest(RequestInterface $request) : bool;

    public function exist(string $email) : bool;

    public function isCustomerAuthorizedByEmail(string $email) : bool;


}
