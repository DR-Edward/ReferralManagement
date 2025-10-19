<?php

namespace WolfSellers\ReferralManagement\Model;

use Magento\Framework\Model\AbstractModel;
use WolfSellers\ReferralManagement\Api\Data\ReferralStatusCodesInterface;
use WolfSellers\ReferralManagement\Model\ResourceModel\ReferralStatusCodes as ResourceReferralStatusCodes;

class ReferralStatusCodes extends AbstractModel implements ReferralStatusCodesInterface
{
    protected function _construct()
    {
        $this->_init(ResourceReferralStatusCodes::class);
    }

    public function getCode(): string
    {
        return (string) $this->getData('code');
    }

    public function setCode(string $code): ReferralStatusCodesInterface
    {
        $this->setData('code', $code);
        return $this;
    }

    public function getDescription(): string
    {
        return (string) $this->getData('description');
    }

    public function setDescription(string $description): ReferralStatusCodesInterface
    {
        $this->setData('description', $description);
        return $this;
    }
}
