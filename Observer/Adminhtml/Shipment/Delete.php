<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Observer\Adminhtml\Shipment;

use HelloMage\ErpConnector\Helper\Authentication;
use HelloMage\ErpConnector\Model\RecordFactory;

class Delete implements \Magento\Framework\Event\ObserverInterface
{
    protected Authentication $_erpAuthenticator;

    protected RecordFactory $_recordFactory;

    /**
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
     * @return Delete
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $info = $observer->getData('info');
            $orderId = $info->getOrderId();
            $invoiceId = NULL;
            $shipmentId = $info->getShipmentId();
            $creditMemoId = NULL;
            $event = 'ShipmentDelete';

            // instant call to ERP system is replaced by internal record create
            // $this->_erpAuthenticator->callErpOrderCreate($orderId, $event, $invoiceId, $shipmentId, $creditMemoId);

            if (isset($orderId) && $orderId > 0) {
                try {
                    $record = $this->_recordFactory->create();
                    $record->addData([
                        "entity_id" => $orderId,
                        "type" => 'order',
                        "event" => $event,
                        "note" => 'Shipment ID '.$shipmentId,
                        "creation_time" => date('Y-m-d H:i:s'),
                        "update_time" => date('Y-m-d H:i:s')
                    ]);
                    $record->save();
                } catch (\Exception $e) {
                }
            }
        } catch (\Exception $e) {
        }

        return $this;
    }
}
