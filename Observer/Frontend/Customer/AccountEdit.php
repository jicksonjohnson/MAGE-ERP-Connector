<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Observer\Frontend\Customer;

use HelloMage\ErpConnector\Helper\Authentication;
use HelloMage\ErpConnector\Model\RecordFactory;

class AccountEdit implements \Magento\Framework\Event\ObserverInterface
{
    protected \Magento\Framework\App\Request\Http $request;

    protected \Magento\Customer\Api\CustomerRepositoryInterface $_customerRepositoryInterface;

    protected Authentication $_erpAuthenticator;

    protected RecordFactory $_recordFactory;

    /**
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     * @param \Magento\Framework\App\Request\Http $request
     * @param Authentication $_erpAuthenticator
     * @param RecordFactory $_recordFactory
     */
    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Framework\App\Request\Http $request,
        Authentication $_erpAuthenticator,
        RecordFactory $_recordFactory
    ) {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->request = $request;
        $this->_erpAuthenticator = $_erpAuthenticator;
        $this->_recordFactory = $_recordFactory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return AccountEdit
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$email = $observer->getEvent()->getEmail()) {
            return;
        }

        try {
            $customer = $this->_customerRepositoryInterface->get($email);
            $customerId = $customer->getId();
            // instant call to ERP system is replaced by internal record create
            // $this->_erpAuthenticator->callErpCreateCustomer($customerId);
            if (isset($customerId) && $customerId > 0) {
                try {
                    $record = $this->_recordFactory->create();
                    $record->addData([
                        "entity_id" => $customerId,
                        "type" => 'customer',
                        "event" => 'CustomerFrontendEdit',
                        "creation_time" => date('Y-m-d H:i:s'),
                        "update_time" => date('Y-m-d H:i:s')
                    ]);
                    $record->save();
                } catch (\Exception $e) {
                }
            }
        } catch(\Exception $exception) {
        }
        return $this;
    }
}
