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

    public function __construct(
        RequestInterface $request,
        ReferralDetailsRepositoryInterface $referralDetailsRepository,
        UrlInterface $url,
        PageConfig $pageConfig,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->request = $request;
        $this->referralDetailsRepository = $referralDetailsRepository;
        $this->url = $url;
        $this->pageConfig = $pageConfig;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    public function getReferralData() {
        // todo improve this
        $sortOrder = $this->sortOrderBuilder
            ->setField('entity_id')
            ->setDirection(SortOrder::SORT_ASC)
            ->create();
        $this->searchCriteriaBuilder
            ->addSortOrder($sortOrder)
            ->setCurrentPage(1)
            ->setPageSize(30);
        $requestItems = $this->referralDetailsRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        return $requestItems;
    }
}
