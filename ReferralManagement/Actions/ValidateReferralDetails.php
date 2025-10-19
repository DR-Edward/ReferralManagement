<?php

namespace WolfSellers\ReferralManagement\Actions;

use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface;
use Magento\Framework\Exception\LocalizedException;
use WolfSellers\ReferralManagement\Api\ReferralDetailsRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use WolfSellers\ReferralManagement\Model\Config;

class ValidateReferralDetails
{
    /**
     * @var ReferralDetailsRepositoryInterface
     */
    private $referralRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        ReferralDetailsRepositoryInterface $referralRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Config $config
    ) {
        $this->referralRepository = $referralRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->config = $config;
    }

    public function enabled()
    {
        if (!$this->config->isEnabled()) {
            throw new LocalizedException(__('Referral Details is disabled.'));
        }
    }

    public function validate(ReferralDetailsInterface $request)
    {
        if ($this->exist($request->getEmail())) {
            throw new LocalizedException(__('Ya existe una recomendación con este email.'));
        }
        if (!filter_var($request->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new LocalizedException(__('Email no valido.'));
        }
        if (!filter_var($request->getCustomerId(), FILTER_VALIDATE_INT)) {
            throw new LocalizedException(__('Customer id no valido.'));
        }
        if(strlen($request->getFirstName()) > 30) {
            throw new LocalizedException(__('Nombre demasiado largo.'));
        }
        if(strlen($request->getLastName()) > 30) {
            throw new LocalizedException(__('Apellido demasiado largo.'));
        }
        if(strlen($request->getTelephone()) > 16) {
            throw new LocalizedException(__('El número de telefono es demasiado largo.'));
        }
    }

    protected function exist(string $email) : bool
    {
        $this->searchCriteriaBuilder
            ->addFilter('email', $email)
            ->setCurrentPage(1)
            ->setPageSize(1);
        return !!count($this->referralRepository->getList($this->searchCriteriaBuilder->create())->getItems());
    }
}
