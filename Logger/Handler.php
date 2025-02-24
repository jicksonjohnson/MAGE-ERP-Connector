<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Logger;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * File name
     * @var string
     */
    protected $fileName = '/var/log/hellomage_erp_connection.log';
}
