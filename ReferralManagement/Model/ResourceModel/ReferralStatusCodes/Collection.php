<?php

namespace WolfSellers\ReferralManagement\Model\ResourceModel\ReferralStatusCodes;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use WolfSellers\ReferralManagement\Model\ReferralStatusCodes;
use WolfSellers\ReferralManagement\Model\ResourceModel\ReferralStatusCodes as ResourceReferralStatusCodes;;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(ReferralStatusCodes::class, ResourceReferralStatusCodes::class);
    }

    protected function _initSelect() {
        parent::_initSelect();
        $this->addFieldToFilter('deleted_at', ['null' => true]);
        return $this;
    }
}
