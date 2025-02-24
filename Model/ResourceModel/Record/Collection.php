<?php

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
