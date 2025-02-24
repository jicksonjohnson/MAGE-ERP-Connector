<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Model\Config\Source;

class Versions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
			['value' => 'value1', 'label' => __('Value 01')],
			['value' => 'value2', 'label' => __('Value 02')]
		];
    }
}
