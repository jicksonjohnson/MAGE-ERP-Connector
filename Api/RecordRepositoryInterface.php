<?php
/**
 * HelloMage
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in the future.
 * If you wish to customise this module for your needs.
 * Please contact us jicksonkoottala@gmail.com
 *
 * @category   HelloMage
 * @package    HelloMage_ErpConnector
 * @copyright  Copyright (C) 2020 HELLOMAGE PVT LTD (https://www.hellomage.com/)
 * @license    https://www.hellomage.com/magento2-osl-3-0-license/
 */

declare(strict_types=1);

namespace HelloMage\ErpConnector\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use HelloMage\ErpConnector\Api\Data\RecordInterface;
use HelloMage\ErpConnector\Api\Data\RecordSearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Interface for HelloMage ERP Connector Record Repository.
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
    public function save(RecordInterface $record): RecordInterface;

    /**
     * Retrieve Record by ID.
     *
     * @param string $recordId
     * @return \HelloMage\ErpConnector\Api\Data\RecordInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(string $recordId): RecordInterface;

    /**
     * Retrieve Records matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \HelloMage\ErpConnector\Api\Data\RecordSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): RecordSearchResultsInterface;

    /**
     * Delete Record.
     *
     * @param \HelloMage\ErpConnector\Api\Data\RecordInterface $record
     * @return bool True on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(RecordInterface $record): bool;

    /**
     * Mark Record as completed by ID.
     *
     * @param string $id
     * @return \HelloMage\ErpConnector\Api\Data\RecordSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function markAsCompleted(string $id): RecordSearchResultsInterface;
}