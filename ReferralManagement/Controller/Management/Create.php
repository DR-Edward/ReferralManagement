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

class Create implements ActionInterface, HttpGetActionInterface
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

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        RequestInterface $request,
        ForwardFactory $forwardFactory,
        Config $config,
        Session $clientSession
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->forwardFactory = $forwardFactory;
        $this->config = $config;
        $this->clientSession = $clientSession;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var Forward $forward */
        $forward = $this->forwardFactory->create();

        if (!$this->config->isEnabled()) {
            return $forward->forward('noroute');
        }

        if (!$this->clientSession->isLoggedIn()) {
            return $forward->forward('noroute');
        }


        /** @var Page $pageResult */
        $pageResult = $this->pageFactory->create();
        return $pageResult;
    }
}
