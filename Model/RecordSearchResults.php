<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Model;

use HelloMage\ErpConnector\Api\Data\RecordSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with record search results.
 */
class RecordSearchResults extends SearchResults implements RecordSearchResultsInterface
{
}
