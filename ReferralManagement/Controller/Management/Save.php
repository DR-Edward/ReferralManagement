<?php

namespace WolfSellers\ReferralManagement\Controller\Management;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use WolfSellers\ReferralManagement\Api\CrudManagementInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Customer\Model\Session;
use WolfSellers\ReferralManagement\Model\ReferralDetails;
use WolfSellers\ReferralManagement\Model\ReferralDetailsFactory;
use WolfSellers\ReferralManagement\Api\ValidateReferralDetailsInterface;
use WolfSellers\ReferralManagement\Api\ReferralDetailsRepositoryInterface;
class Save implements ActionInterface, HttpPostActionInterface
{
    /**
     * @var CrudManagementInterface
     */
    private $crudManagement;
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;
    /**
     * @var ReferralDetailsFactory
     */
    private $referralDetailsFactory;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var ValidateReferralDetailsInterface
     */
    private $validator;
    /**
     * @var ReferralDetailsRepositoryInterface
     */
    private $referralDetailsRepository;

    public function __construct(
        CrudManagementInterface $crudManagement,
        RequestInterface $request,
        JsonFactory $resultJsonFactory,
        ReferralDetailsFactory $referralDetailsFactory,
        Session $session,
        ValidateReferralDetailsInterface $validator,
        ReferralDetailsRepositoryInterface $referralDetailsRepository
    ) {
        $this->crudManagement = $crudManagement;
        $this->request = $request;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->referralDetailsFactory = $referralDetailsFactory;
        $this->session = $session;
        $this->validator = $validator;
        $this->referralDetailsRepository = $referralDetailsRepository;
    }

    public function execute()
    {
        $output = [];
        $result = $this->resultJsonFactory->create();
        if (
            $this->validator->enabled() === false
            || $this->validator->isCustomerLoggedInBySession() === false
        ) {
            $output = ['error' => true, 'message' => __('theres an error with data provided')];
            $result->setHttpResponseCode(400);
            return $result->setData($output);
        }


        $referralId = $this->request->getParam('id');
        if ($referralId) {
            if ($this->validator->isCustomerAuthorized($this->session->getCustomerId(), $referralId) === false) {
                $output = ['error' => true, 'message' => __('theres an error with data provided')];
                $result->setHttpResponseCode(400);
                return $result->setData($output);
            } else {
                $output = $this->save();
                $result->setHttpResponseCode(200);
            }
        } else {
            $output = $this->save();
            $result->setHttpResponseCode(200);
        }


        return $result->setData($output);
    }

    private function save(ReferralDetails $referralDetails = null)
    {
        if(!$referralDetails) {
            $referralDetails = $this->referralDetailsFactory->create();
        }
        $referralDetails
            ->setFirstName($this->request->getParam('first_name'))
            ->setLastName($this->request->getParam('last_name'))
            ->setEmail($this->request->getParam('email'))
            ->setTelephone($this->request->getParam('telephone'))
            ->setCustomerId($this->session->getCustomerId());
        if (!empty($this->request->getParam('id'))) {
            $referralDetails->setEntityId($this->request->getParam('id'));
        }

            $output = $this->crudManagement->create($referralDetails);
//        try {
//        } catch (\Throwable $e) {
//            $output = ['error' => $e->getMessage()];
//        }
        return $output;
    }

    private function update()
    {
        $referralDetails = $this->referralDetailsRepository->getById($this->request->getParam('id'));
        $this->save($referralDetails);
    }
}
