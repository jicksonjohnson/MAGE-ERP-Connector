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

namespace HelloMage\ErpConnector\Model\ResourceModel\Record;

use HelloMage\ErpConnector\Model\ResourceModel\AbstractCollection;

/**
 * Class Collection
 * @package HelloMage\ErpConnector\Model\ResourceModel\Record
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'record_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'hellomage_erp_api_connector_grid_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'hellomage_erp_api_connector_collection';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(\HelloMage\ErpConnector\Model\Record::class, \HelloMage\ErpConnector\Model\ResourceModel\Record::class);
    }
}
