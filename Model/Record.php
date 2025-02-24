<?php

namespace HelloMage\ErpConnector\Model;

use HelloMage\ErpConnector\Api\Data\RecordInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Record extends AbstractModel implements RecordInterface, IdentityInterface
{
    /**
     * Erp Records cache tag
     */
    public const CACHE_TAG = 'erp_records';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'erp_records';

    /**
     * Status
     */
    const STATUS_PENDING   = 0;
    const STATUS_PROCESSING   = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_FAILED = 3;

    /**
     * Construct.
     */
    protected function _construct()
    {
        $this->_init(\HelloMage\ErpConnector\Model\ResourceModel\Record::class);
    }

    /**
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues()
    {
        return [];
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::RECORD_ID);
    }

    /**
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->getData(self::EVENT);
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->getData(self::NOTE);
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * @param $id
     * @return RecordInterface
     */
    public function setId($id)
    {
        return $this->setData(self::RECORD_ID, $id);
    }

    /**
     * @param $entityId
     * @return RecordInterface
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @param $type
     * @return RecordInterface
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * @param $event
     * @return RecordInterface
     */
    public function setEvent($event)
    {
        return $this->setData(self::EVENT, $event);
    }

    /**
     * @param $note
     * @return RecordInterface
     */
    public function setNote($note)
    {
        return $this->setData(self::NOTE, $note);
    }

    /**
     * @param $status
     * @return RecordInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set create time
     *
     * @param $creationTime
     * @return RecordInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param $updationTime
     * @return RecordInterface
     */
    public function setUpdateTime($updationTime)
    {
        return $this->setData(self::UPDATE_TIME, $updationTime);
    }
}
