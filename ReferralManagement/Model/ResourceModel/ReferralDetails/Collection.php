<?php

namespace WolfSellers\ReferralManagement\Model\ResourceModel\ReferralDetails;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use WolfSellers\ReferralManagement\Model\ReferralDetails;
use WolfSellers\ReferralManagement\Model\ResourceModel\ReferralDetails as ResourceReferralDetails;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(ReferralDetails::class, ResourceReferralDetails::class);
    }

    protected function _initSelect() {
        parent::_initSelect();
        $this->addFieldToFilter('deleted_at', ['null' => true]);
    }
}
