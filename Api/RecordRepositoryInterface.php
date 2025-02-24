<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use HelloMage\ErpConnector\Api\Data\RecordInterface;

/**
 * Interface for HelloMage ERP Connector RecordRepositoryInterface.
 * @api
 * @package HelloMage\ErpConnector\Api
 */
interface RecordRepositoryInterface
{
    /**
     * Save Record.
     *
     * @param \HelloMage\ErpConnector\Api\Data\RecordInterface $record
     * @return \HelloMage\ErpConnector\Api\Data\RecordInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\RecordInterface $record);

    /**
     * Retrieve Record.
     *
     * @param string $recordId
     * @return \HelloMage\ErpConnector\Api\Data\RecordInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($recordId);

    /**
     * Retrieve Record matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \HelloMage\ErpConnector\Api\Data\RecordSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Record.
     *
     * @param \HelloMage\ErpConnector\Api\Data\RecordInterface $record
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\RecordInterface $record);

    /**
     * Update item by id.
     *
     * @api
     * @param string $id
     * @return \HelloMage\ErpConnector\Api\Data\RecordSearchResultsInterface
     */
    public function markAsCompleted($id);
}
