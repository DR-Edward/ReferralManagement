<?php

namespace WolfSellers\ReferralManagement\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ReferralDetails extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('referral', 'entity_id');
    }
}
