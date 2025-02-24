<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for RecordSearchResultsInterface.
 * @api
 * @package HelloMage\ErpConnector\Api\Data
 */
interface RecordSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \HelloMage\ErpConnector\Api\Data\RecordInterface[]
     */
    public function getItems();

    /**
     * @param \HelloMage\ErpConnector\Api\Data\RecordInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
