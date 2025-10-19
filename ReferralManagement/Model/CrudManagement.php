<?php

namespace WolfSellers\ReferralManagement\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;
use WolfSellers\ReferralManagement\Api\CrudManagementInterface;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsSearchResultsInterface;
use WolfSellers\ReferralManagement\Api\ReferralDetailsRepositoryInterface;
use WolfSellers\ReferralManagement\Actions\ValidateReferralDetails;

class CrudManagement implements CrudManagementInterface
{
    /**
     * @var ReferralDetailsRepositoryInterface
     */
    private $referralDetailsRepository;
    /**
     * @var ValidateReferralDetails
     */
    private $validator;

    public function __construct(
        ReferralDetailsRepositoryInterface $referralDetailsRepository,
        ValidateReferralDetails $validator
    ) {
        $this->referralDetailsRepository = $referralDetailsRepository;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ReferralDetailsInterface $request): ReferralDetailsInterface
    {
        $this->validator->enabled();
        $this->validator->validate($request);
        return $this->referralDetailsRepository->save($request);
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $id): ReferralDetailsInterface
    {
        $this->validator->enabled();
        return $this->referralDetailsRepository->getById($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): array
    {
        $this->validator->enabled();
        return ['success' => $this->referralDetailsRepository->deleteById($id)];
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ReferralDetailsSearchResultsInterface
    {
        $this->validator->enabled();
        return $this->referralDetailsRepository->getList($searchCriteria);
    }

}
