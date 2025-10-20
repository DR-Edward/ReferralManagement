<?php

namespace WolfSellers\ReferralManagement\ViewModel;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\RequestInterface;
use WolfSellers\ReferralManagement\Api\ReferralDetailsRepositoryInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Customer\Model\Session;

class ReferralDataView implements ArgumentInterface
{
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var referralDetailsRepositoryInterface
     */
    private $referralDetailsRepository;
    /**
     * @var UrlInterface
     */
    private $url;
    /**
     * @var PageConfig
     */
    private $pageConfig;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;
    /**
     * @var Session
     */
    private $customerSession;

    public function __construct(
        RequestInterface $request,
        ReferralDetailsRepositoryInterface $referralDetailsRepository,
        UrlInterface $url,
        PageConfig $pageConfig,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        Session $customerSession
    ) {
        $this->request = $request;
        $this->referralDetailsRepository = $referralDetailsRepository;
        $this->url = $url;
        $this->pageConfig = $pageConfig;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->customerSession = $customerSession;
    }

    public function setBlock($block) {
        $this->block = $block;
    }

    public function getReferralData() {
        $customerId = $this->customerSession->getCustomerId();
        $sortOrder = $this->sortOrderBuilder
            ->setField('entity_id')
            ->setDirection(SortOrder::SORT_ASC)
            ->create();
        $this->searchCriteriaBuilder
            ->addSortOrder($sortOrder)
            ->addFilter('customer_id', $customerId)
            ->setCurrentPage(1)
            ->setPageSize(30);
        $requestItems = $this->referralDetailsRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        return $requestItems;
    }

    public function getFirstNameFromBlock()
    {
        return $this->block ? $this->block->getFirstName() : null;
    }

    public function getLastNameFromBlock()
    {
        return $this->block ? $this->block->getLastName() : null;
    }

    public function getEmailFromBlock()
    {
        return $this->block ? $this->block->getEmail() : null;
    }

    public function getTelephoneFromBlock()
    {
        return $this->block ? $this->block->getTelephone() : null;
    }

    public function getIdFromBlock()
    {
        return $this->block ? $this->block->getId() : null;
    }
}
