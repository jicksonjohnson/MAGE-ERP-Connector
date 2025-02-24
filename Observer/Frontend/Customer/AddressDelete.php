<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Observer\Frontend\Customer;

use HelloMage\ErpConnector\Helper\Authentication;
use HelloMage\ErpConnector\Model\RecordFactory;
use Magento\Framework\Event\ObserverInterface;

/**
 * @SuppressWarnings(PHPMD)
 */
class AddressDelete implements ObserverInterface
{
    protected \Magento\Framework\App\RequestInterface $request;

    protected Authentication $_erpAuthenticator;

    protected RecordFactory $_recordFactory;

    protected \Magento\Customer\Api\AddressRepositoryInterface $_addressRepository;

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param Authentication $_erpAuthenticator
     * @param RecordFactory $_recordFactory
     * @param \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        Authentication $_erpAuthenticator,
        RecordFactory $_recordFactory,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
    ) {
        $this->request = $request;
        $this->_erpAuthenticator = $_erpAuthenticator;
        $this->_recordFactory = $_recordFactory;
        $this->_addressRepository = $addressRepository;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $addressId = $this->request->getParam('id');

        if (isset($addressId)) {
            $address = $this->_addressRepository->getById($addressId);
            if ($address->getCustomerId()) {
                $customer_id = $address->getCustomerId();
                try {
                    $record = $this->_recordFactory->create();
                    $record->addData([
                        "entity_id" => $customer_id,
                        "type" => 'customer',
                        "event" => 'CustomerFrontendAddressDelete',
                        "creation_time" => date('Y-m-d H:i:s'),
                        "update_time" => date('Y-m-d H:i:s')
                    ]);
                    $record->save();
                } catch (\Exception $e) {
                }
            }
        }
        return $this;
    }
}
