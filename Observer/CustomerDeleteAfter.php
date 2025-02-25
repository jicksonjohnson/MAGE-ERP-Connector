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

namespace HelloMage\ErpConnector\Observer;

use HelloMage\ErpConnector\Helper\Authentication;
use HelloMage\ErpConnector\Model\RecordFactory;
use Psr\Log\LoggerInterface;

/**
 * Class CustomerDeleteAfter
 * @package HelloMage\ErpConnector\Observer\CustomerDeleteAfter
 */
class CustomerDeleteAfter implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var Authentication
     */
    protected Authentication $_erpAuthenticator;

    /**
     * @var RecordFactory
     */
    protected RecordFactory $_recordFactory;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $_logger;

    /**
     * RemoveContact constructor.
     *
     * @param Authentication $_erpAuthenticator
     * @param RecordFactory $_recordFactory
     * @param LoggerInterface $_logger
     */
    public function __construct(
        Authentication $_erpAuthenticator,
        RecordFactory $_recordFactory,
        LoggerInterface $_logger
    ) {
        $this->_erpAuthenticator = $_erpAuthenticator;
        $this->_recordFactory = $_recordFactory;
        $this->_logger = $_logger;
    }

    /**
     * Observer for customer deletion event.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this|void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$customer = $observer->getEvent()->getCustomer()) {
            return;
        }

        $customer_id = $customer->getId();
        $event = 'CustomerDelete';

        // Instant call to ERP system is replaced by internal record creation
        // $this->_erpAuthenticator->callErpCustomerDelete($customer_id, $event);

        if (isset($customer_id) && $customer_id > 0) {
            try {
                $record = $this->_recordFactory->create();
                $record->addData([
                    "entity_id" => $customer_id,
                    "type" => 'customer',
                    "event" => $event,
                    "creation_time" => date('Y-m-d H:i:s'),
                    "update_time" => date('Y-m-d H:i:s')
                ]);
                $record->save();
            } catch (\Exception $e) {
                // Log the error or handle it
                $this->_logger->error($e->getMessage());
            }
        }
        return $this;
    }
}
