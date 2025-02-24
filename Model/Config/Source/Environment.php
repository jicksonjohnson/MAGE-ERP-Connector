<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Model\Config\Source;

class Environment
{
    const TEST_MODE = 'staging';
    const LIVE_MODE = 'production';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                "value" => self::TEST_MODE,
                "label" => "Stage account"
            ],
            [
                "value" => self::LIVE_MODE,
                "label" => "Production account"
            ],
        ];
    }
}
