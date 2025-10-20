<?php

namespace WolfSellers\ReferralManagement\Controller\Management;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Action\HttpDeleteActionInterface;
use WolfSellers\ReferralManagement\Api\CrudManagementInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Delete implements ActionInterface, HttpDeleteActionInterface
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

    public function __construct(
        CrudManagementInterface $crudManagement,
        RequestInterface $request,
        JsonFactory $resultJsonFactory
    ) {
        $this->crudManagement = $crudManagement;
        $this->request = $request;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $itemId = (int) $this->request->getParam('id');

        try {
            $output = $this->crudManagement->delete($itemId);
        } catch (\Throwable $e) {
            $output = ['error' => $e->getMessage()];
        }
        return $this->resultJsonFactory->create()->setData($output);
    }
}
