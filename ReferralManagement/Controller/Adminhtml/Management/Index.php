<?php
namespace WolfSellers\ReferralManagement\Controller\Adminhtml\Management;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'WolfSellers_ReferralManagement::management';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute method
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('WolfSellers_ReferralManagement::management');
        $resultPage->getConfig()->getTitle()->prepend(__('Referral Grid'));
        return $resultPage;
    }
}
