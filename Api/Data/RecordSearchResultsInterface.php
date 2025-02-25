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

namespace HelloMage\ErpConnector\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for search results of Record entities.
 * @api
 * @package HelloMage\ErpConnector\Api\Data
 */
interface RecordSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
