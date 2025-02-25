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

namespace HelloMage\ErpConnector\Ui\Component\Listing\Column;

use HelloMage\ErpConnector\Model\Record;

/**
 * Class Status
 * @package HelloMage\ErpConnector\Ui\Component\Listing\Column\Status
 */
class Status extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Data Source
     *
     * @param array<string, mixed> $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
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
                $dataSource['data']['items'][$key][$fieldName] =
                    '<span style="font-weight: bold;">' . $label . '</span>';
            }
        }

        return $dataSource;
    }
}
