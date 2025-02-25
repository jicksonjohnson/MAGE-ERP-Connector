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

namespace HelloMage\ErpConnector\Model;

use HelloMage\ErpConnector\Api\Data\RecordInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Record
 * @package HelloMage\ErpConnector\Model\Record
 */
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
    public function getId():?int
    {
        return $this->getData(self::RECORD_ID);
    }

    /**
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @return string|null
     */
    public function getEvent(): ?string
    {
        return $this->getData(self::EVENT);
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->getData(self::NOTE);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @return string
     */
    public function getCreationTime(): string
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * @return string|null
     */
    public function getUpdateTime(): ?string
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * @param $id
     * @return RecordInterface
     */
    public function setId($id): RecordInterface
    {
        return $this->setData(self::RECORD_ID, $id);
    }

    /**
     * @param $entityId
     * @return RecordInterface
     */
    public function setEntityId($entityId): RecordInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @param $type
     * @return RecordInterface
     */
    public function setType($type): RecordInterface
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * @param $event
     * @return RecordInterface
     */
    public function setEvent($event): RecordInterface
    {
        return $this->setData(self::EVENT, $event);
    }

    /**
     * @param string $note
     * @return RecordInterface
     */
    public function setNote(string $note): RecordInterface
    {
        return $this->setData(self::NOTE, $note);
    }

    /**
     * @param int $status
     * @return RecordInterface
     */
    public function setStatus(int $status): RecordInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set create time
     *
     * @param string $creationTime
     * @return RecordInterface
     */
    public function setCreationTime(string $creationTime): RecordInterface
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updationTime
     * @return RecordInterface
     */
    public function setUpdateTime(string $updationTime): RecordInterface
    {
        return $this->setData(self::UPDATE_TIME, $updationTime);
    }
}
