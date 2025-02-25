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

namespace HelloMage\ErpConnector\Observer\Adminhtml\Customer;

use HelloMage\ErpConnector\Helper\Authentication;
use HelloMage\ErpConnector\Model\RecordFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AddressDelete
 * @package HelloMage\ErpConnector\Observer\Adminhtml\Customer\AddressDelete
 */
class AddressDelete implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var Authentication
     */
    protected Authentication $_erpAuthenticator;

    /**
     * @var RecordFactory
     */
    protected RecordFactory $_recordFactory;

    /**
     * @var AddressRepositoryInterface
     */
    protected AddressRepositoryInterface $_addressRepository;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $_logger;

    /**
     * @param RequestInterface $request
     * @param Authentication $_erpAuthenticator
     * @param RecordFactory $_recordFactory
     * @param AddressRepositoryInterface $addressRepository
     * @param LoggerInterface $_logger
     */
    public function __construct(
        RequestInterface $request,
        Authentication $_erpAuthenticator,
        RecordFactory $_recordFactory,
        AddressRepositoryInterface $addressRepository,
        LoggerInterface $_logger
    ) {
        $this->request = $request;
        $this->_erpAuthenticator = $_erpAuthenticator;
        $this->_recordFactory = $_recordFactory;
        $this->_addressRepository = $addressRepository;
        $this->_logger = $_logger;
    }

    /**
     * Observer for customer address delete event in adminhtml.
     *
     * @param Observer $observer
     * @return $this|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(Observer $observer)
    {
        $addressId = $this->request->getParam('id');

        if (isset($addressId)) {
            try {
                $address = $this->_addressRepository->getById($addressId);
                if ($address->getCustomerId()) {
                    $customer_id = $address->getCustomerId();
                    $record = $this->_recordFactory->create();
                    $record->addData([
                        "entity_id" => $customer_id,
                        "type" => 'customer',
                        "event" => 'CustomerAdminhtmlAddressDelete',
                        "creation_time" => date('Y-m-d H:i:s'),
                        "update_time" => date('Y-m-d H:i:s')
                    ]);
                    $record->save();
                }
            } catch (\Exception $e) {
                // Log the error or handle it
                $this->_logger->error($e->getMessage());
            }
        }

        return $this;
    }
}
