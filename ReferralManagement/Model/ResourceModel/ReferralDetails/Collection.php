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

    protected function _initSelect()
    {
        parent::_initSelect();
        $this->addFieldToFilter('main_table.deleted_at', ['null' => true]);

        $this->getSelect()->joinLeft(
            ['referral_status_codes' => $this->getTable('referral_status_codes')],
            'main_table.status_id = referral_status_codes.id',
            ['status_code' => 'referral_status_codes.code']
        );
        return $this;
    }
}
