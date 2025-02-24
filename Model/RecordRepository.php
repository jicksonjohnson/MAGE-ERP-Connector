<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Model;

use HelloMage\ErpConnector\Api\Data\RecordInterface;
use HelloMage\ErpConnector\Api\RecordRepositoryInterface;
use HelloMage\ErpConnector\Api\Data;
use HelloMage\ErpConnector\Model\ResourceModel\Record as ResourceRecord;
use HelloMage\ErpConnector\Model\ResourceModel\Record\CollectionFactory as RecordCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\EntityManager\HydratorInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
/**
 * Default Record repo impl.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RecordRepository implements RecordRepositoryInterface
{
    protected ResourceRecord $resource;

    protected RecordFactory $recordFactory;

    protected RecordCollectionFactory $recordCollectionFactory;

    protected Data\RecordSearchResultsInterfaceFactory $searchResultsFactory;

    protected DataObjectHelper $dataObjectHelper;

    protected DataObjectProcessor $dataObjectProcessor;

    protected Data\RecordInterfaceFactory $dataRecordFactory;

    private StoreManagerInterface $storeManager;

    private CollectionProcessorInterface $collectionProcessor;

    private JoinProcessorInterface $joinProcessor;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @param ResourceRecord $resource
     * @param RecordFactory $recordFactory
     * @param Data\RecordInterfaceFactory $dataRecordFactory
     * @param RecordCollectionFactory $recordCollectionFactory
     * @param Data\RecordSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param JoinProcessorInterface $joinProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param HydratorInterface|null $hydrator
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        ResourceRecord $resource,
        RecordFactory $recordFactory,
        \HelloMage\ErpConnector\Api\Data\RecordInterfaceFactory $dataRecordFactory,
        RecordCollectionFactory $recordCollectionFactory,
        Data\RecordSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        JoinProcessorInterface $joinProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        ?HydratorInterface $hydrator = null
    ) {
        $this->resource = $resource;
        $this->recordFactory = $recordFactory;
        $this->recordCollectionFactory = $recordCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataRecordFactory = $dataRecordFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->joinProcessor = $joinProcessor;
        $this->collectionProcessor = $collectionProcessor;
        $this->hydrator = $hydrator ?? ObjectManager::getInstance()->get(HydratorInterface::class);
    }

    /**
     * Save Record data
     *
     * @param \HelloMage\ErpConnector\Api\Data\RecordInterface $record
     * @return Record
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(Data\RecordInterface $record)
    {
        if ($record->getId() && $record instanceof Record && !$record->getOrigData()) {
            $record = $this->hydrator->hydrate($this->getById($record->getId()), $this->hydrator->extract($record));
        }
        try {
            $this->resource->save($record);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $record;
    }

    /**
     * Load Record data by given Record Identity
     *
     * @param string $recordId
     * @return Record
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($recordId)
    {
        $record = $this->recordFactory->create();
        $this->resource->load($record, $recordId);
        if (!$record->getId()) {
            throw new NoSuchEntityException(__('The Record with the "%1" ID doesn\'t exist.', $recordId));
        }
        return $record;
    }

    /**
     * Load Record data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \HelloMage\ErpConnector\Api\Data\RecordSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \HelloMage\ErpConnector\Model\ResourceModel\Record\Collection $collection */
        $collection = $this->recordCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var Data\RecordSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete Record
     *
     * @param \HelloMage\ErpConnector\Api\Data\RecordInterface $record
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\RecordInterface $record)
    {
        try {
            $this->resource->delete($record);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function markAsCompleted($id)
    {
        try {
            $item = $this->recordFactory->create();
            $item->load($id);
            if (!$item->getId()) {
                return false;
            }
            $item->addData([
                'status' => 2
            ])->save();
            return $item;
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__('some issue found wih updating data "%1"', $e->getMessage()));
        }
    }
}
