<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Model\Config\Source;

use HelloMage\ErpConnector\Model\Record;
use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function getOptionArray()
    {
        return [
            Record::STATUS_PROCESSING => 'Processing',
            Record::STATUS_FAILED => 'Failed',
            Record::STATUS_PENDING => 'Pending',
            Record::STATUS_COMPLETED => 'Completed'
        ];
    }

    /**
     * Get product type labels array with empty value for option element
     *
     * @return array
     */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    /**
     * Get product type labels array for option element
     *
     * @return array
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }

    /**
     * Get product type label
     *
     * @param string $optionId
     * @return null|string
     */
    public function getOptionText($optionId)
    {
        $options = $this->getOptionArray();
        return $options[$optionId] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
