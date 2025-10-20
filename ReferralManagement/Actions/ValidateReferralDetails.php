<?php

namespace WolfSellers\ReferralManagement\Actions;

use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface;
use Magento\Framework\Exception\LocalizedException;
use WolfSellers\ReferralManagement\Api\ReferralDetailsRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use WolfSellers\ReferralManagement\Model\Config;
use WolfSellers\ReferralManagement\Api\ValidateReferralDetailsInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Magento\Framework\App\RequestInterface;

class ValidateReferralDetails implements ValidateReferralDetailsInterface
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
    /**
     * @var Session
     */
    private $clientSession;
    /**
     * @var FormKeyValidator
     */
    private $formKeyValidator;

    public function __construct(
        ReferralDetailsRepositoryInterface $referralRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Config $config,
        Session $clientSession,
        FormKeyValidator $formKeyValidator
    ) {
        $this->referralRepository = $referralRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->config = $config;
        $this->clientSession = $clientSession;
        $this->formKeyValidator = $formKeyValidator;
    }

    public function enabled()
    {
        if (!$this->config->isEnabled()) {
            throw new LocalizedException(__('Referral Details is disabled.'));
        }
    }

    public function validate(ReferralDetailsInterface $request)
    {
//        if ($this->exist($request->getEmail())) {
//            throw new LocalizedException(__('Ya existe una recomendación con este email.'));
//        }
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

    public function exist(string $email) : bool
    {
        $this->searchCriteriaBuilder
            ->addFilter('email', $email)
            ->setCurrentPage(1)
            ->setPageSize(1);
        return !!count($this->referralRepository->getList($this->searchCriteriaBuilder->create())->getItems());
    }

    public function isCustomerAuthorized(int $customerId, int $referralId) : bool
    {
        $referral = $this->referralRepository->getById($referralId);
        $output = false;
        if ($referral->getCustomerId()) {
            $output = $referral->getCustomerId() == $customerId;
        }
        return $output;
    }

    public function isCustomerAuthorizedByEmail(string $email) : bool
    {
        $customerId = $this->clientSession->getCustomerId();
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('email', $email)->create();
        $referralData = $this->referralRepository->getList($searchCriteria)->getItems();

        $referral = $this->referralRepository->getById($referralId);
        $output = false;
        if ($referral->getEmail()) {
            $output = $referral->getEmail() == $email;
        }
    }

    public function isCustomerLoggedInBySession() : bool
    {
        return $this->clientSession->isLoggedIn();
    }

    public function isReferralIdValidByPath(string $path) : int
    {
        $parts = explode('/', trim($path, '/'));
        $output = 0;
        if (isset($parts[3]) && is_numeric($parts[3])) {
            $output = (int)$parts[3];
        }
        return $output;
    }

    public function validateFormKey(RequestInterface $request): bool
    {
        return $this->formKeyValidator->validate($request);
    }

    public function isEmailInRequest(RequestInterface $request) : bool
    {
        return !empty($request->getParam('email'));
    }
}
