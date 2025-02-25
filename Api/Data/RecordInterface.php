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

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface for Record entity.
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
     * Get record ID.
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Get entity ID.
     *
     * @return int
     */
    public function getEntityId(): int;

    /**
     * Get record type.
     *
     * @return string|null
     */
    public function getType(): ?string;

    /**
     * Get event name.
     *
     * @return string|null
     */
    public function getEvent(): ?string;

    /**
     * Get note.
     *
     * @return string|null
     */
    public function getNote(): ?string;

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Get creation time.
     *
     * @return string
     */
    public function getCreationTime(): string;

    /**
     * Get update time.
     *
     * @return string|null
     */
    public function getUpdateTime(): ?string;

    /**
     * Set record ID.
     *
     * @param int $id
     * @return RecordInterface
     */
    public function setId(int $id): RecordInterface;

    /**
     * Set entity ID.
     *
     * @param int $entityId
     * @return RecordInterface
     */
    public function setEntityId(int $entityId): RecordInterface;

    /**
     * Set record type.
     *
     * @param string $type
     * @return RecordInterface
     */
    public function setType(string $type): RecordInterface;

    /**
     * Set event name.
     *
     * @param string $event
     * @return RecordInterface
     */
    public function setEvent(string $event): RecordInterface;

    /**
     * Set note.
     *
     * @param string $note
     * @return RecordInterface
     */
    public function setNote(string $note): RecordInterface;

    /**
     * Set status.
     *
     * @param int $value
     * @return RecordInterface
     */
    public function setStatus(int $value): RecordInterface;

    /**
     * Set creation time.
     *
     * @param string $value
     * @return RecordInterface
     */
    public function setCreationTime(string $value): RecordInterface;

    /**
     * Set update time.
     *
     * @param string $value
     * @return RecordInterface
     */
    public function setUpdateTime(string $value): RecordInterface;
}