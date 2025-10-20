<?php

namespace WolfSellers\ReferralManagement\Controller\Management;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use WolfSellers\ReferralManagement\Model\Config;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use WolfSellers\ReferralManagement\Api\ValidateReferralDetailsInterface;
use WolfSellers\ReferralManagement\Api\CrudManagementInterface;

class Edit implements ActionInterface, HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var ForwardFactory
     */
    private $forwardFactory;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Session
     */
    private $clientSession;
    /**
     * @var ValidateReferralDetailsInterface
     */
    private $validator;
    /**
     * @var CrudManagementInterface
     */
    private $crudManagement;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        RequestInterface $request,
        ForwardFactory $forwardFactory,
        Config $config,
        Session $clientSession,
        ValidateReferralDetailsInterface $validator,
        CrudManagementInterface $crudManagement
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->forwardFactory = $forwardFactory;
        $this->config = $config;
        $this->clientSession = $clientSession;
        $this->validator = $validator;
        $this->crudManagement = $crudManagement;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var Forward $forward */
        $forward = $this->forwardFactory->create();
        $referralId = $this->validator->isReferralIdValidByPath($this->request->getPathInfo());
        $customerId = $this->clientSession->getCustomerId();
        if (
            $this->validator->enabled() === false
            || $this->validator->isCustomerLoggedInBySession() === false
            || !!$referralId === false
            || $this->validator->isCustomerAuthorized($customerId, $referralId) === false
        ) {
            return $forward->forward('noroute');
        }

        $referralItem = $this->crudManagement->get($referralId);
        /** @var Page $pageResult */
        $pageResult = $this->pageFactory->create();
        $pageResult->getLayout()
            ->getBlock('referral.form.block')
            ->setData('id', $referralItem->getEntityId())
            ->setData('first_name', $referralItem->getFirstName())
            ->setData('last_name', $referralItem->getLastName())
            ->setData('email', $referralItem->getEmail())
            ->setData('telephone', $referralItem->getTelephone());

        return $pageResult;
    }
}
