<?php

namespace WolfSellers\ReferralManagement\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ReferralDetailsSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface[]
     */
    public function getItems();

    /**
     * @param \WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
