<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Observer\Adminhtml\Customer;

use HelloMage\ErpConnector\Helper\Authentication;
use HelloMage\ErpConnector\Model\RecordFactory;
use Magento\Framework\Event\ObserverInterface;

/**
 * @SuppressWarnings(PHPMD)
 */
class InlineEdit implements ObserverInterface
{
    protected \Magento\Framework\App\RequestInterface $request;

    protected Authentication $_erpAuthenticator;

    protected RecordFactory $_recordFactory;

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param Authentication $_erpAuthenticator
     * @param RecordFactory $_recordFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        Authentication $_erpAuthenticator,
        RecordFactory $_recordFactory
    ) {
        $this->request = $request;
        $this->_erpAuthenticator = $_erpAuthenticator;
        $this->_recordFactory = $_recordFactory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this|void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $post = $this->request->getPostValue();
        if (isset($post) && isset($post['items'])) {
            foreach ($post['items'] as $customer_id => $value) {

                // instant call to ERP system is replaced by internal record create
                // $this->_erpAuthenticator->callErpCreateCustomer($customer_id);

                if (isset($customer_id) && $customer_id > 0) {
                    try {
                        $record = $this->_recordFactory->create();
                        $record->addData([
                            "entity_id" => $customer_id,
                            "type" => 'customer',
                            "event" => 'CustomerInlineEdit',
                            "creation_time" => date('Y-m-d H:i:s'),
                            "update_time" => date('Y-m-d H:i:s')
                        ]);
                        $record->save();
                    } catch (\Exception $e) {
                    }
                }
            }
        }

        return $this;
    }
}
