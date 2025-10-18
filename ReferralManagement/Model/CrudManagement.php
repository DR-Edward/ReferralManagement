<?php

namespace WolfSellers\ReferralManagement\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;
use WolfSellers\ReferralManagement\Api\CrudManagementInterface;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsSearchResultsInterface;
use WolfSellers\ReferralManagement\Api\ReferralDetailsRepositoryInterface;
USE WolfSellers\ReferralManagement\Model\Config;

class CrudManagement implements CrudManagementInterface
{
    /**
     * @var ReferralDetailsRepositoryInterface
     */
    private $referralDetailsRepository;
    /**
     * @var \WolfSellers\ReferralManagement\Model\Config
     */
    private $config;

    public function __construct(
        ReferralDetailsRepositoryInterface $referralDetailsRepository,
        Config $config
    ) {
        $this->referralDetailsRepository = $referralDetailsRepository;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ReferralDetailsInterface $request): ReferralDetailsInterface
    {
        if (!$this->config->isEnabled()) {
            throw new LocalizedException(__('Referral Details is disabled.'));
        }
        try {
            $results = $this->referralDetailsRepository->save($request);
        } catch (\Throwable $e) {
            $results = ['error' => $e->getMessage()];
        }

        return $results;
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $id): ReferralDetailsInterface
    {
        if (!$this->config->isEnabled()) {
            throw new LocalizedException(__('Referral Details is disabled.'));
        }
        try {
            $results = $this->referralDetailsRepository->getById($id);
        } catch (\Throwable $e) {
            $results = ['error' => $e->getMessage()];
        }

        return $results;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): array
    {
        if (!$this->config->isEnabled()) {
            throw new LocalizedException(__('Referral Details is disabled.'));
        }
        try {
            if ($this->config->isEnabledSoftDeletes()) {
                $results = ['success' => $this->referralDetailsRepository->softDeleteById($id)];
            } else {
                $results = ['success' => $this->referralDetailsRepository->deleteById($id)];
            }
        } catch (\Throwable $e) {
            $results = ['error' => $e->getMessage()];
        }

        return $results;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ReferralDetailsSearchResultsInterface
    {
        if (!$this->config->isEnabled()) {
            throw new LocalizedException(__('Referral Details is disabled.'));
        }

        return $this->referralDetailsRepository->getList($searchCriteria);
    }

}
