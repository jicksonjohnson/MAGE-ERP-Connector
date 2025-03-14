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

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Logger
 * @package HelloMage\ErpConnector\Model\Config\Source\Environment
 */
class Environment implements ArrayInterface
{
    const TEST_MODE = 'staging';
    const LIVE_MODE = 'production';

    /**
     * Retrieve the list of available environment options.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                "value" => self::TEST_MODE,
                "label" => __("Stage account")
            ],
            [
                "value" => self::LIVE_MODE,
                "label" => __("Production account")
            ],
        ];
    }
}