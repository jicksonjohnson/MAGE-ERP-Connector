<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Ui\Component\Listing\Column;

use HelloMage\ErpConnector\Model\Record;

class Status extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Data Source
     *
     * @param array<string, mixed> $dataSource
     * @return array
     */
    public function prepareDataSource($dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');

            foreach ($dataSource['data']['items'] as $key => $item) {
                $value = $item[$fieldName];

                if ($value == Record::STATUS_COMPLETED) {
                    $label = 'Completed';
                } elseif ($value == Record::STATUS_FAILED) {
                    $label = 'Failed';
                } elseif ($value == Record::STATUS_PENDING) {
                    $label = 'Pending';
                } elseif ($value == Record::STATUS_PROCESSING) {
                    $label = 'Processing';
                } else {
                    $label = '';
                }

                $dataSource['data']['items'][$key][$fieldName] = '<span style="font-weight: bold;">' . $label . '</span>';
            }
        }

        return $dataSource;
    }
}
