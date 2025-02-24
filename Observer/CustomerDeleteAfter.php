<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Observer;

use HelloMage\ErpConnector\Helper\Authentication;
use HelloMage\ErpConnector\Model\RecordFactory;

class CustomerDeleteAfter implements \Magento\Framework\Event\ObserverInterface
{
    protected Authentication $_erpAuthenticator;

    protected RecordFactory $_recordFactory;

    /**
     * RemoveContact constructor.
     *
     * @param Authentication $_erpAuthenticator
     * @param RecordFactory $_recordFactory
     */
    public function __construct(
        Authentication $_erpAuthenticator,
        RecordFactory $_recordFactory
    ) {
        $this->_erpAuthenticator = $_erpAuthenticator;
        $this->_recordFactory = $_recordFactory;
    }

    /**
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

        // instant call to ERP system is replaced by internal record create
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
            }
        }
        return $this;
    }
}
