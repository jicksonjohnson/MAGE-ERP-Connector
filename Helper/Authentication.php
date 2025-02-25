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

namespace HelloMage\ErpConnector\Helper;

use HelloMage\ErpConnector\Logger\Logger;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Authentication
 * @package HelloMage\ErpConnector\Helper\Authentication
 */
class Authentication extends AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var Logger
     */
    protected Logger $erpConnectionLogger;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param Logger $erpConnectionLogger
     * @param Config $config
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        Logger $erpConnectionLogger,
        Config $config
    ) {
        $this->storeManager = $storeManager;
        $this->erpConnectionLogger = $erpConnectionLogger;
        $this->config = $config;
        parent::__construct($context);
    }

    /**
     * Authenticates the ERP system and returns the access token.
     *
     * @return string|null
     */
    public function authenticate()
    {
        $apiBaseUrl = $this->getErpSystemBaseUrl();
        $apiURL= $apiBaseUrl."api/v1/login";

        $this->erpConnectionLogger->info('apiBaseUrl : '.$apiBaseUrl);

        $credentials = $this->getAuthUserCredentials();
        $user = [];
        $user['email'] = $credentials['email'];
        $user['password'] = $credentials['password'];
        $user['secrete_code'] = $credentials['secrete_code'];

        $data_string = json_encode($user);

        $this->erpConnectionLogger->info('data_string : '.$data_string);

        $header_data = [
            "Content-Type: application/json",
            "Accept: */*",
            "Content-Length: ".strlen($data_string)
        ];

        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);

        try {
            $token = curl_exec($ch);
            if (curl_error($ch)) {
                $this->erpConnectionLogger->info('Curl Error'.curl_error($ch));
            } else {
                $token_details = json_decode($token,true);
            }
            $this->erpConnectionLogger->info('token details : '.$token);
            if (isset($token_details)) {
                if($token_details['status']=='success') {
                    $this->erpConnectionLogger->info('Auth Token : '.$token_details['access_token']);
                    $this->setAccessTokenData($token_details['access_token']);
                    return $token_details['access_token'];
                }
            }
        } catch (\Exception $e) {
            $this->erpConnectionLogger->info('SYSTEM ERROR : '. $e->getMessage());
        }

        return NULL;
    }

    /**
     * @param $customer_id
     * @return void
     */
    public function callErpCreateCustomer($customer_id)
    {
        $access_token = $this->getAccessTokenData();

        if (isset($access_token)) {
            $apiBaseUrl = $this->getErpSystemBaseUrl();
            $apiURL= $apiBaseUrl."api/v1/customer/create";
            $authorization = "Bearer ".$access_token;

            $data = [
                'customer_id' =>$customer_id
            ];

            $data_string = json_encode($data);

            $this->erpConnectionLogger->info('Customer Data : '.$data_string);

            $header_data = [
                "Content-Type: application/json",
                "Accept: */*",
                "Content-Length: ".strlen($data_string),
                "Connection: keep-alive",
                "Accept-Encoding: gzip, deflate, br",
                "Authorization: ".$authorization
            ];

            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);

            try {
                $result = curl_exec($ch);

                $this->erpConnectionLogger->info('Result : '.json_encode($result));

                if (curl_error($ch)) {
                    $this->erpConnectionLogger->info('Curl Error'.curl_error($ch));
                } else {
                    if (isset($result['status'])) {
                        $this->erpConnectionLogger->info('Customer Create Result : '.$result['status']);
                    }
                }
            } catch (\Exception $e) {
                $this->erpConnectionLogger->info('SYSTEM ERROR : '. $e->getMessage());
            }

        } else {
            $this->erpConnectionLogger->info('ERP Authentication error, NO ACCESS TOKEN FOUND');
        }
    }

    /**
     * @param $orderId
     * @param $event
     * @param $invoiceId
     * @param $shipmentId
     * @param $creditMemoId
     * @return void
     */
    public function callErpOrderCreate($orderId, $event, $invoiceId = NULL, $shipmentId = NULL, $creditMemoId = NULL)
    {
        $access_token = $this->getAccessTokenData();
        if (isset($access_token)) {
            $apiBaseUrl = $this->getErpSystemBaseUrl();
            $apiURL= $apiBaseUrl."api/v1/order/create";
            $authorization = "Bearer ".$access_token;
            $data = [];
            $data['order_id'] = $orderId;

            if (isset($invoiceId)) {
                $data['invoice_id'] = $invoiceId;
            }

            if (isset($shipmentId)) {
                $data['shipment_id'] = $shipmentId;
            }

            if (isset($creditMemoId)) {
                $data['creditmemo_id'] = $creditMemoId;
            }

            $data_string = json_encode($data);

            $this->erpConnectionLogger->info($event);
            $this->erpConnectionLogger->info('Order Entity ID : '.$data_string);

            $header_data = [
                "Content-Type: application/json",
                "Accept: */*",
                "Content-Length: ".strlen($data_string),
                "Connection: keep-alive",
                "Accept-Encoding: gzip, deflate, br",
                "Authorization: ".$authorization
            ];

            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);

            try {
                $result = curl_exec($ch);

                $this->erpConnectionLogger->info($result);

                $this->erpConnectionLogger->info('Result : '.json_encode($result));

                if (curl_error($ch)) {
                    $this->erpConnectionLogger->info('Curl Error'.curl_error($ch));
                } else {
                    if (isset($result['status'])) {
                        $this->erpConnectionLogger->info('Order Create Result : '.$result['status']);
                    }
                }
            } catch (\Exception $e) {
                $this->erpConnectionLogger->info('SYSTEM ERROR : '. $e->getMessage());
            }

        } else {
            $this->erpConnectionLogger->info('ERP Authentication error, NO ACCESS TOKEN FOUND');
        }
    }

    /**
     * @param $order_id
     * @param $event
     * @return void
     */
    public function callErpOrderDelete($order_id, $event)
    {
        $access_token = $this->getAccessTokenData();
        if (isset($access_token)) {
            $apiBaseUrl = $this->getErpSystemBaseUrl();
            $apiURL= $apiBaseUrl."api/v1/order/delete";
            $authorization = "Bearer ".$access_token;

            $data = [
                'order_id' => $order_id
            ];

            $data_string = json_encode($data);

            $this->erpConnectionLogger->info($event);
            $this->erpConnectionLogger->info('Delete Order ID : '.$data_string);

            $header_data = [
                "Content-Type: application/json",
                "Accept: */*",
                "Content-Length: ".strlen($data_string),
                "Connection: keep-alive",
                "Accept-Encoding: gzip, deflate, br",
                "Authorization: ".$authorization
            ];

            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);

            try {
                $result = curl_exec($ch);

                $this->erpConnectionLogger->info('Result : '.json_encode($result));

                if (curl_error($ch)) {
                    $this->erpConnectionLogger->info('Curl Error'.curl_error($ch));
                } else {
                    if (isset($result['status'])) {
                        $this->erpConnectionLogger->info('Order delete result : '.$result['status']);
                    }
                }
            } catch (\Exception $e) {
                $this->erpConnectionLogger->info('SYSTEM ERROR : '. $e->getMessage());
            }

        } else {
            $this->erpConnectionLogger->info('ERP Authentication error, NO ACCESS TOKEN FOUND');
        }
    }

    /**
     * @param $customer_id
     * @param $event
     * @return void
     */
    public function callErpCustomerDelete($customer_id, $event)
    {
        $access_token = $this->getAccessTokenData();
        if (isset($access_token)) {
            $apiBaseUrl = $this->getErpSystemBaseUrl();
            $apiURL= $apiBaseUrl."api/v1/customer/delete";
            $authorization = "Bearer ".$access_token;

            $data = [
                'customer_id' => $customer_id
            ];

            $data_string = json_encode($data);

            $this->erpConnectionLogger->info($event);
            $this->erpConnectionLogger->info('Customer ID : '.$data_string);

            $header_data = [
                "Content-Type: application/json",
                "Accept: */*",
                "Content-Length: ".strlen($data_string),
                "Connection: keep-alive",
                "Accept-Encoding: gzip, deflate, br",
                "Authorization: ".$authorization
            ];

            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);

            try {
                $result = curl_exec($ch);

                $this->erpConnectionLogger->info('Result : '.json_encode($result));

                if (curl_error($ch)) {
                    $this->erpConnectionLogger->info('Curl Error'.curl_error($ch));
                } else {
                    if (isset($result['status'])) {
                        $this->erpConnectionLogger->info('Customer delete result : '.$result['status']);
                    }
                }
            } catch (\Exception $e) {
                $this->erpConnectionLogger->info('SYSTEM ERROR : '. $e->getMessage());
            }

        } else {
            $this->erpConnectionLogger->info('ERP Authentication error, NO ACCESS TOKEN FOUND');
        }
    }

    /**
     * @return array
     */
    public function getAuthUserCredentials()
    {
        $email =  $this->scopeConfig->getValue('erp_connector/settings/auth_email');
        $password =  $this->scopeConfig->getValue('erp_connector/settings/auth_password');
        $secrete_code =  $this->scopeConfig->getValue('erp_connector/settings/secrete_code');

        return [
            'email' => isset($email) ? $email : NULL,
            'password' => isset($password) ? $password : NULL,
            'secrete_code' => isset($secrete_code) ? $secrete_code : NULL
        ];
    }

    /**
     * @return mixed
     */
    public function getErpSystemBaseUrl()
    {
        $env = $this->scopeConfig->getValue('erp_connector/settings/env');
        if ($env == 'production') {
            $path = 'erp_connector/settings/live_url';
        } else {
            $path = 'erp_connector/settings/stage_url';
        }
        return $this->scopeConfig->getValue($path);
    }

    /**
     * @param $value
     * @return void
     */
    public function setAccessTokenData($value)
    {
        $env = $this->scopeConfig->getValue('erp_connector/settings/env');
        if ($env == 'production') {
            $path = 'erp_connector/settings/live_access_token';
        } else {
            $path = 'erp_connector/settings/stage_access_token';
        }
        if (isset($value)) {
            $time_path = $path.'_updated_at';
            $this->config->saveConfig($time_path, date("Y-m-d h:i:s"), 'default', 0);
            $this->config->saveConfig($path, $value, 'default', 0);
        }
    }

    /**
     * @return mixed|null
     */
    public function getAccessTokenData()
    {
        $env = $this->scopeConfig->getValue('erp_connector/settings/env');
        if ($env == 'production') {
            $path = 'erp_connector/settings/live_access_token';
        } else {
            $path = 'erp_connector/settings/stage_access_token';
        }

        $existing_token = $this->scopeConfig->getValue($path);
        $this->erpConnectionLogger->info('Existing token before check : '. $existing_token);

        if (isset($existing_token) && $existing_token != 'NULL') {
            $this->erpConnectionLogger->info('Existing token : '. $existing_token);
            return $existing_token;
        } else {
            $this->erpConnectionLogger->info('Authenticating new token. calling login API');
            $new_token = $this->authenticate();
            if (isset($new_token)) {
                $this->erpConnectionLogger->info('New token received : '. $new_token);
                return $new_token;
            }
        }
        return NULL;
    }
}