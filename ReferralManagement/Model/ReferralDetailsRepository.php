<?php

namespace WolfSellers\ReferralManagement\Model;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\DB\Select;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsInterface;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsSearchResultsInterface;
use WolfSellers\ReferralManagement\Api\Data\ReferralDetailsSearchResultsInterfaceFactory;
use WolfSellers\ReferralManagement\Api\ReferralDetailsRepositoryInterface;
use WolfSellers\ReferralManagement\Model\ResourceModel\ReferralDetails as ResourceReferralDetails;
use WolfSellers\ReferralManagement\Model\ReferralDetails;
use WolfSellers\ReferralManagement\Model\ReferralDetailsFactory;
use WolfSellers\ReferralManagement\Model\ResourceModel\ReferralDetails\Collection as ReferralDetailsCollection;
use WolfSellers\ReferralManagement\Model\ResourceModel\ReferralDetails\CollectionFactory as ReferralDetailsCollectionFactory;

class ReferralDetailsRepository implements ReferralDetailsRepositoryInterface
{
    /**
     * @var ResourceReferralDetails
     */
    private $referralDetailsResourceModel;
    /**
     * @var \WolfSellers\ReferralManagement\Model\ReferralDetailsFactory
     */
    private $referralDetailsFactory;
    /**
     * @var ReferralDetailsCollectionFactory
     */
    private $referralDetailsCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ReferralDetailsSearchResultsInterfaceFactory
     */
    private $referralDetailsSearchResultsInterfaceFactory;

    public function __construct(
        ResourceReferralDetails $referralDetailsResourceModel,
        ReferralDetailsFactory $referralDetailsFactory,
        ReferralDetailsCollectionFactory $referralDetailsCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        ReferralDetailsSearchResultsInterfaceFactory $referralDetailsSearchResultsInterfaceFactory
    ) {
        $this->referralDetailsResourceModel = $referralDetailsResourceModel;
        $this->referralDetailsFactory = $referralDetailsFactory;
        $this->referralDetailsCollectionFactory = $referralDetailsCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->referralDetailsSearchResultsInterfaceFactory = $referralDetailsSearchResultsInterfaceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ReferralDetailsInterface $referralDetails): ReferralDetailsInterface
    {
        if (!($referralDetails instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('The implementation of ReferralDetails has changed'));
        }
        try {
            $this->referralDetailsResourceModel->save($referralDetails);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $referralDetails;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $detailsId, $includeDeleted = false ): ReferralDetailsInterface
    {
        /** @var ReferralDetailsCollection $referralDetails */
        $collection = $this->referralDetailsCollectionFactory->create();
        $collection->addFieldToFilter('main_table.entity_id', $detailsId);
        $item = $collection->getFirstItem();
        if (!$item->getId()) {
            throw new NoSuchEntityException(__('Referral with ID "%1" does not exist.', $detailsId));
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ReferralDetailsInterface $referralDetails): bool
    {
        if (!($referralDetails instanceof AbstractModel)) {
            throw new CouldNotDeleteException(__('The implementation of ReferralDetails has changed'));
        }
        try {
            $this->referralDetailsResourceModel->delete($referralDetails);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById(int $detailsId): bool
    {
        return $this->delete($this->getById($detailsId));
    }

    /**
     * {@inheritdoc}
     */
    public function softDelete(ReferralDetailsInterface $referralDetails): bool
    {
        if (!($referralDetails instanceof  AbstractModel)) {
            throw new CouldNotDeleteException(__('The implementation of ReferralDetails has changed'));
        }
        try {
            $time = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'));
            $referralDetails->setDeletedAt($time);
            $this->referralDetailsResourceModel->save($referralDetails);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function softDeleteById(int $referralId): bool
    {
        return $this->softDelete($this->getById($referralId));
    }

    /**
     * {@inheritdoc}
     */
    public function restore(ReferralDetailsInterface $referralDetails): bool
    {
        if (!($referralDetails instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('The implementation of ReferralDetails has changed'));
        }
        try {
            $referralDetails->setDeletedAt(null);
            $this->referralDetailsResourceModel->save($referralDetails);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function restoreById(int $referralId): bool
    {
        return $this->restore($this->getById($referralId, true));
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria, ?bool $includeDeleted = false): ReferralDetailsSearchResultsInterface
    {
        /** @var ReferralDetailsCollection $collection */
        $collection = $this->referralDetailsCollectionFactory->create();
        if ($includeDeleted) {
            $collection->getSelect()->reset(Select::WHERE);
        }
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->referralDetailsSearchResultsInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function getListWithDeleted(SearchCriteriaInterface $searchCriteria): ReferralDetailsSearchResultsInterface
    {
        return $this->getList($searchCriteria, true);
    }
}
