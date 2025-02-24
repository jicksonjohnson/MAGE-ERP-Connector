<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface for RecordInterface.
 * @api
 * @package HelloMage\ErpConnector\Api\Data
 */
interface RecordInterface extends ExtensibleDataInterface
{
    const RECORD_ID = 'record_id';
    const ENTITY_ID = 'entity_id';
    const TYPE = 'type';
    const EVENT = 'event';
    const NOTE = 'note';
    const STATUS = 'status';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @return string|null
     */
    public function getType();

    /**
     * @return string|null
     */
    public function getEvent();

    /**
     * @return string|null
     */
    public function getNote();

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getCreationTime();

    /**
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * @param $id
     * @return RecordInterface
     */
    public function setId($id);

    /**
     * @param $entity_id
     * @return RecordInterface
     */
    public function setEntityId($entity_id);

    /**
     * @param $type
     * @return RecordInterface
     */
    public function setType($type);

    /**
     * @param $event
     * @return RecordInterface
     */
    public function setEvent($event);

    /**
     * @param $note
     * @return RecordInterface
     */
    public function setNote($note);

    /**
     * @param $value
     * @return RecordInterface
     */
    public function setStatus($value);

    /**
     * Set create time
     *
     * @param $value
     * @return RecordInterface
     */
    public function setCreationTime($value);

    /**
     * Set update time
     *
     * @param $value
     * @return RecordInterface
     */
    public function setUpdateTime($value);
}
