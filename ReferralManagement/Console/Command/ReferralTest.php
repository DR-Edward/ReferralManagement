<?php

namespace WolfSellers\ReferralManagement\Console\Command;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WolfSellers\ReferralManagement\Model\ReferralDetails;
use WolfSellers\ReferralManagement\Model\ReferralDetailsFactory;
use WolfSellers\ReferralManagement\Model\ReferralDetailsRepository;

class ReferralTest extends Command
{

    /**
     * @var ReferralDetailsFactory
     */
    private $referralDetailsFactory;
    /**
     * @var ReferralDetailsRepository
     */
    private $referralDetailsRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    public function __construct(
        ReferralDetailsFactory $referralDetailsFactory,
        ReferralDetailsRepository $referralDetailsRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        string $name = null
    ) {
        $this->referralDetailsFactory = $referralDetailsFactory;
        $this->referralDetailsRepository = $referralDetailsRepository;
        parent::__construct($name);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    protected function configure()
    {
        $this->setName('referral:test')
            ->setDescription('Command to test referral CRUD');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getList($output);
        return 0;
    }

    protected function createNewRecord($output) {
        $output->writeln('start: '.__FUNCTION__);
        /** @var ReferralDetails $referralDetails */
        $referralDetails = $this->referralDetailsFactory->create();
        $referralDetails
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setEmail('john.doe@example.com')
            ->setTelephone('6182222222')
            ->setCustomerId(1);
        $this->referralDetailsRepository->save($referralDetails);
        $output->writeln('end: '.__FUNCTION__);
    }

    protected function getElementById($output, $id) {
        $output->writeln('start: '.__FUNCTION__);
        $referralDetails = $this->referralDetailsRepository->getById($id);
        $output->writeln(print_r($referralDetails->getData(), true));
        $output->writeln('finish: '.__FUNCTION__);
    }

    protected function deleteById($output, $id) {
        $output->writeln('start: '.__FUNCTION__);
        $deleteStatus = $this->referralDetailsRepository->deleteById($id);
        $output->writeln($deleteStatus);
        $output->writeln('finish: '.__FUNCTION__);
    }

    protected function getList($output, $includeDeleted = false) {
        $output->writeln('start: '.__FUNCTION__);
        $sortOrder = $this->sortOrderBuilder
            ->setField('entity_id')
            ->setDirection(SortOrder::SORT_ASC)
            ->create();
        $this->searchCriteriaBuilder
            ->addFilter('customer_id', 2, 'eq')
            ->addSortOrder($sortOrder)
            ->setCurrentPage(1)
            ->setPageSize(1);
        if ($includeDeleted) {
            $requestItems = $this->referralDetailsRepository->getListWithDeleted($this->searchCriteriaBuilder->create())->getItems();
        } else {
            $requestItems = $this->referralDetailsRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        }
        foreach ($requestItems as $requestItem) {
            $output->writeln(print_r($requestItem->getData(), true));
        }
        $output->writeln('finish: '.__FUNCTION__);
    }

    protected function softDeleteById($output, $id) {
        $output->writeln('start: '.__FUNCTION__);
        $deleteStatus = $this->referralDetailsRepository->softDeleteById($id);
        $output->writeln($deleteStatus);
        $output->writeln('finish: '.__FUNCTION__);
    }

    protected function restoreById($output, $id) {
        $output->writeln('start: '.__FUNCTION__);
        $restoreStatus = $this->referralDetailsRepository->restoreById($id);
        $output->writeln($restoreStatus);
        $output->writeln('finish: '.__FUNCTION__);
    }

    protected function getListWithSoftDeleted($output) {
        $output->writeln('start: '.__FUNCTION__);
        $this->getList($output, true);
        $output->writeln('finish: '.__FUNCTION__);

    }
}
