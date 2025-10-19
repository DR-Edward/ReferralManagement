<?php

namespace WolfSellers\ReferralManagement\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ReferralStatusCodes extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('referral_status_codes', 'id');
    }
}
