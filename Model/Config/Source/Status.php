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

namespace HelloMage\ErpConnector\Model\Config\Source;

use HelloMage\ErpConnector\Model\Record;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Logger
 * @package HelloMage\ErpConnector\Model\Config\Source\Status
 */
class Status implements OptionSourceInterface
{
    /**
     * Get an array of status options.
     *
     * @return array
     */
    public function getOptionArray(): array
    {
        return [
            Record::STATUS_PROCESSING => __('Processing'),
            Record::STATUS_FAILED => __('Failed'),
            Record::STATUS_PENDING => __('Pending'),
            Record::STATUS_COMPLETED => __('Completed')
        ];
    }

    /**
     * Get status labels array with an empty value for select elements.
     *
     * @return array
     */
    public function getAllOptions(): array
    {
        $options = $this->getOptions();
        array_unshift($options, ['value' => '', 'label' => '']);
        return $options;
    }

    /**
     * Get status labels array for select elements.
     *
     * @return array
     */
    public function getOptions(): array
    {
        $result = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }
        return $result;
    }

    /**
     * Get the label for a specific status by its option ID.
     *
     * @param string $optionId
     * @return null|string
     */
    public function getOptionText(string $optionId): ?string
    {
        $options = $this->getOptionArray();
        return $options[$optionId] ?? null;
    }

    /**
     * Retrieve status options for select elements.
     *
     * @inheritdoc
     */
    public function toOptionArray(): array
    {
        return $this->getOptions();
    }
}