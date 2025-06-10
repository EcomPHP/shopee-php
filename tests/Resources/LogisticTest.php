<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Logistic;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class LogisticTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;

    /**
     * @var Logistic
     */
    private $logistic;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->logistic = new Logistic();
        $this->logistic->useApiClient($this->client);
    }

    public function testGetShippingParameter()
    {
        $orderSn = '123456789';
        $packageNumber = 'PKG123';
        $expectedResponse = ['info_needed' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'logistics/get_shipping_parameter', 
                [
                    RequestOptions::QUERY => [
                        'order_sn' => $orderSn,
                        'package_number' => $packageNumber,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->getShippingParameter($orderSn, $packageNumber);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShippingParameterWithoutPackageNumber()
    {
        $orderSn = '123456789';
        $expectedResponse = ['info_needed' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'logistics/get_shipping_parameter', 
                [
                    RequestOptions::QUERY => [
                        'order_sn' => $orderSn,
                        'package_number' => '',
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->getShippingParameter($orderSn);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetTrackingNumber()
    {
        $orderId = '123456789';
        $params = ['package_number' => 'PKG123'];
        $expectedParams = [
            'order_sn' => $orderId,
            'package_number' => 'PKG123'
        ];
        $expectedResponse = ['tracking_number' => 'TRK123456789'];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'logistics/get_tracking_number', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->getTrackingNumber($orderId, $params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testShipOrder()
    {
        $orderSn = '123456789';
        $packageNumber = 'PKG123';
        $pickup = ['address_id' => 1, 'pickup_time_id' => 2];
        $dropoff = ['branch_id' => 3, 'sender_real_name' => 'John Doe'];
        $nonIntegrated = ['tracking_number' => 'TRK123456789'];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/ship_order', 
                [
                    RequestOptions::JSON => [
                        'order_sn' => $orderSn,
                        'package_number' => $packageNumber,
                        'pickup' => $pickup,
                        'dropoff' => $dropoff,
                        'non_integrated' => $nonIntegrated,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->shipOrder($orderSn, $packageNumber, $pickup, $dropoff, $nonIntegrated);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUpdateShippingOrder()
    {
        $orderSn = '123456789';
        $packageNumber = 'PKG123';
        $pickup = ['address_id' => 1, 'pickup_time_id' => 2];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/update_shipping_order', 
                [
                    RequestOptions::JSON => [
                        'order_sn' => $orderSn,
                        'package_number' => $packageNumber,
                        'pickup' => $pickup,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->updateShippingOrder($orderSn, $packageNumber, $pickup);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShippingDocumentParameter()
    {
        $orderList = [
            ['order_sn' => '123456789', 'package_number' => 'PKG123']
        ];
        $expectedResponse = ['result_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/get_shipping_document_parameter', 
                [
                    RequestOptions::JSON => [
                        'order_list' => $orderList
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->getShippingDocumentParameter($orderList);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testCreateShippingDocument()
    {
        $orderList = [
            [
                'order_sn' => '123456789', 
                'package_number' => 'PKG123',
                'tracking_number' => 'TRK123456789',
                'shipping_document_type' => 'NORMAL_AIR_WAYBILL'
            ]
        ];
        $expectedResponse = ['result_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/create_shipping_document', 
                [
                    RequestOptions::JSON => [
                        'order_list' => $orderList
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->createShippingDocument($orderList);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShippingDocumentResult()
    {
        $orderList = [
            ['order_sn' => '123456789', 'package_number' => 'PKG123']
        ];
        $expectedResponse = ['result_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/get_shipping_document_result', 
                [
                    RequestOptions::JSON => [
                        'order_list' => $orderList
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->getShippingDocumentResult($orderList);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDownloadShippingDocument()
    {
        $orderList = [
            ['order_sn' => '123456789', 'package_number' => 'PKG123']
        ];
        $shippingDocumentType = 'NORMAL_AIR_WAYBILL';
        $expectedResponse = ['result' => 'binary_data'];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/download_shipping_document', 
                [
                    RequestOptions::JSON => [
                        'order_list' => $orderList,
                        'shipping_document_type' => $shippingDocumentType
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->downloadShippingDocument($orderList, $shippingDocumentType);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetTrackingInfo()
    {
        $orderSn = '123456789';
        $packageNumber = 'PKG123';
        $expectedResponse = ['tracking_info' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'logistics/get_tracking_info', 
                [
                    RequestOptions::QUERY => [
                        'order_sn' => $orderSn,
                        'package_number' => $packageNumber
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->getTrackingInfo($orderSn, $packageNumber);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetAddressList()
    {
        $expectedResponse = ['address_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'logistics/get_address_list')
            ->willReturn($expectedResponse);

        $result = $this->logistic->getAddressList();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testSetAddressConfig()
    {
        $addressTypeConfig = [
            'pickup_address_id' => 1,
            'return_address_id' => 2
        ];
        $showPickupAddress = true;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/set_address_config', 
                [
                    RequestOptions::JSON => [
                        'address_type_config' => $addressTypeConfig,
                        'show_pickup_address' => $showPickupAddress
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->setAddressConfig($addressTypeConfig, $showPickupAddress);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDeleteAddress()
    {
        $addressId = 12345;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/delete_address', 
                [
                    RequestOptions::JSON => [
                        'address_id' => $addressId
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->deleteAddress($addressId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetChannelList()
    {
        $expectedResponse = ['logistics_channel_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'logistics/get_channel_list')
            ->willReturn($expectedResponse);

        $result = $this->logistic->getChannelList();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUpdateChannel()
    {
        $logisticsChannelId = 12345;
        $enabled = true;
        $codEnabled = false;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/update_channel', 
                [
                    RequestOptions::JSON => [
                        'logistics_channel_id' => $logisticsChannelId,
                        'enabled' => $enabled,
                        'cod_enabled' => $codEnabled
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->updateChannel($logisticsChannelId, $enabled, $codEnabled);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testBatchShipOrder()
    {
        $orderList = [
            [
                'order_sn' => '123456789',
                'package_number' => 'PKG123'
            ]
        ];
        $pickup = ['address_id' => 1, 'pickup_time_id' => 2];
        $dropoff = ['branch_id' => 3, 'sender_real_name' => 'John Doe'];
        $nonIntegrated = ['tracking_number' => 'TRK123456789'];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/batch_ship_order', 
                [
                    RequestOptions::JSON => [
                        'order_list' => $orderList,
                        'pickup' => $pickup,
                        'dropoff' => $dropoff,
                        'non_integrated' => $nonIntegrated
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->batchShipOrder($orderList, $pickup, $dropoff, $nonIntegrated);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShippingDocumentDataInfo()
    {
        $orderSn = '123456789';
        $packageNumber = 'PKG123';
        $recipientAddressInfo = [
            'name' => 'John Doe',
            'phone' => '1234567890',
            'address' => '123 Main St'
        ];
        $expectedResponse = ['data_info' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'logistics/get_shipping_document_data_info', 
                [
                    RequestOptions::JSON => [
                        'order_sn' => $orderSn,
                        'package_number' => $packageNumber,
                        'recipient_address_info' => $recipientAddressInfo
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->logistic->getShippingDocumentDataInfo($orderSn, $packageNumber, $recipientAddressInfo);

        $this->assertEquals($expectedResponse, $result);
    }
}
