<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Model\ResourceModel;

use HelloMage\ErpConnector\Api\Data\RecordInterface;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Class Record
 * @package HelloMage\ErpConnector\Model\ResourceModel
 */
class Record extends AbstractDb
{
    protected StoreManagerInterface $_storeManager;

    protected EntityManager $entityManager;

    protected MetadataPool $metadataPool;

    protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    protected \Magento\Framework\Stdlib\DateTime\DateTime $date;

    /**
     * @param Context $context
     * @param DateTime $date
     * @param StoreManagerInterface $storeManager
     * @param EntityManager $entityManager
     * @param MetadataPool $metadataPool
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param null $connectionName
     */
    public function __construct(
        Context $context,
        DateTime $date,
        StoreManagerInterface $storeManager,
        EntityManager $entityManager,
        MetadataPool $metadataPool,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        $connectionName = null
    ) {
        $this->date = $date;
        $this->_storeManager = $storeManager;
        $this->entityManager = $entityManager;
        $this->metadataPool = $metadataPool;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('hellomage_erp_api_connector_records', RecordInterface::RECORD_ID);
    }

    /**
     * @inheritDoc
     */
    public function getConnection()
    {
        return $this->metadataPool->getMetadata(RecordInterface::class)->getEntityConnection();
    }

    /**
     * Perform operations before object save
     *
     * @param AbstractModel $object
     * @return $this
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $object->setUpdateTime($this->date->gmtDate());
        if ($object->isObjectNew()) {
            $object->setCreationTime($this->date->gmtDate());
        }
        return parent::_beforeSave($object);
    }

    /**
     * Load an object
     *
     * @param \HelloMage\ErpConnector\Model\Record|AbstractModel $object
     * @param mixed $value
     * @param string $field field to load by (defaults to model id)
     * @return $this
     */
    public function load(AbstractModel $object, $value, $field = null)
    {
        $this->entityManager->load($object, $value);
        return $this;
    }

    /**
     * Save an object.
     *
     * @param AbstractModel $object
     * @return $this
     * @throws \Exception
     */
    public function save(AbstractModel $object)
    {
        $this->entityManager->save($object);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function delete(AbstractModel $object)
    {
        $this->entityManager->delete($object);
        return $this;
    }
}
