<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Order;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;

    /**
     * @var Order
     */
    private $order;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->order = new Order();
        $this->order->useApiClient($this->client);
    }

    public function testGetOrderList()
    {
        $params = [
            'time_range_field' => 'update_time',
            'time_from' => 1609459200,
            'time_to' => 1612137600,
            'page_size' => 50
        ];
        $expectedResponse = ['order_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'order/get_order_list', 
                [
                    RequestOptions::QUERY => $params
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->getOrderList($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetOrderListWithDefaultParams()
    {
        $expectedResponse = ['order_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'order/get_order_list', 
                $this->callback(function($options) {
                    $params = $options[RequestOptions::QUERY];
                    return $params['time_range_field'] === 'create_time' 
                        && isset($params['time_from']) 
                        && isset($params['time_to']) 
                        && $params['page_size'] === 20;
                })
            )
            ->willReturn($expectedResponse);

        $result = $this->order->getOrderList();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShipmentList()
    {
        $params = ['cursor' => 'abc123', 'page_size' => 50];
        $expectedParams = ['cursor' => 'abc123', 'page_size' => 20]; // page_size is overridden in the method
        $expectedResponse = ['order_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'order/get_shipment_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->getShipmentList($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetOrderDetail()
    {
        $orderIds = ['123456789', '987654321'];
        $params = ['response_optional_fields' => 'buyer_user_id,buyer_username'];
        $expectedParams = [
            'order_sn_list' => '123456789,987654321',
            'response_optional_fields' => 'buyer_user_id,buyer_username'
        ];
        $expectedResponse = ['order_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'order/get_order_detail', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->getOrderDetail($orderIds, $params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetOrderDetailWithSingleId()
    {
        $orderId = '123456789';
        $expectedParams = ['order_sn_list' => '123456789'];
        $expectedResponse = ['order_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'order/get_order_detail', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->getOrderDetail($orderId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetBookingList()
    {
        $params = [
            'time_range_field' => 'update_time',
            'time_from' => 1609459200,
            'time_to' => 1612137600,
            'page_size' => 50
        ];
        $expectedResponse = ['order_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'order/get_booking_list', 
                [
                    RequestOptions::QUERY => $params
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->getBookingList($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetBookingDetail()
    {
        $orderIds = ['123456789', '987654321'];
        $params = ['response_optional_fields' => 'buyer_user_id,buyer_username'];
        $expectedParams = [
            'booking_sn_list' => '123456789,987654321',
            'response_optional_fields' => 'buyer_user_id,buyer_username'
        ];
        $expectedResponse = ['order_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'order/get_booking_detail', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->getBookingDetail($orderIds, $params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testSplitOrder()
    {
        $orderSn = '123456789';
        $packageList = [
            [
                'item_list' => [
                    ['item_id' => 1, 'model_id' => 1, 'quantity' => 1]
                ]
            ],
            [
                'item_list' => [
                    ['item_id' => 2, 'model_id' => 2, 'quantity' => 2]
                ]
            ]
        ];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'order/split_order', 
                [
                    RequestOptions::JSON => [
                        'order_sn' => $orderSn,
                        'package_list' => $packageList
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->splitOrder($orderSn, $packageList);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUnsplitOrder()
    {
        $orderSn = '123456789';
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'order/unsplit_order', 
                [
                    RequestOptions::JSON => [
                        'order_sn' => $orderSn
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->unsplitOrder($orderSn);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testCancelOrder()
    {
        $orderSn = '123456789';
        $cancelReason = 'OUT_OF_STOCK';
        $itemList = [
            ['item_id' => 1, 'model_id' => 1]
        ];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'order/cancel_order', 
                [
                    RequestOptions::JSON => [
                        'order_sn' => $orderSn,
                        'cancel_reason' => $cancelReason,
                        'item_list' => $itemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->cancelOrder($orderSn, $cancelReason, $itemList);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testSetNoteOrder()
    {
        $orderSn = '123456789';
        $note = 'Test note for order';
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'order/set_note', 
                [
                    RequestOptions::JSON => [
                        'order_sn' => $orderSn,
                        'note' => $note
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->setNoteOrder($orderSn, $note);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetPendingBuyerInvoiceOrderList()
    {
        $params = ['cursor' => 'abc123'];
        $expectedParams = ['cursor' => 'abc123', 'page_size' => 20];
        $expectedResponse = ['order_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'order/get_pending_buyer_invoice_order_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->getPendingBuyerInvoiceOrderList($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUploadInvoiceDoc()
    {
        $orderSn = '123456789';
        $fileType = 'PDF';
        $file = __DIR__ . '/../../phpunit.xml'; // Using an existing file for the test
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'order/upload_invoice_doc', 
                $this->callback(function($options) use ($orderSn, $fileType) {
                    if (!isset($options[RequestOptions::MULTIPART])) {
                        return false;
                    }

                    $multipart = $options[RequestOptions::MULTIPART];

                    return count($multipart) === 3
                        && $multipart[0]['name'] === 'order_sn'
                        && $multipart[0]['contents'] === $orderSn
                        && $multipart[1]['name'] === 'file_type'
                        && $multipart[1]['contents'] === $fileType
                        && $multipart[2]['name'] === 'file'
                        && is_resource($multipart[2]['contents']);
                })
            )
            ->willReturn($expectedResponse);

        $result = $this->order->uploadInvoiceDoc($orderSn, $fileType, $file);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDownloadInvoiceDoc()
    {
        $orderSn = '123456789';
        $expectedResponse = 'binary_file_content';

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'order/download_invoice_doc', 
                [
                    RequestOptions::QUERY => [
                        'order_sn' => $orderSn
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->downloadInvoiceDoc($orderSn);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetBuyerInvoiceInfo()
    {
        $orderSnList = ['123456789', '987654321'];
        $expectedParams = [
            'queries' => [
                ['order_sn' => '123456789'],
                ['order_sn' => '987654321']
            ]
        ];
        $expectedResponse = ['invoice_info_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'order/get_buyer_invoice_info', 
                [
                    RequestOptions::JSON => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->getBuyerInvoiceInfo($orderSnList);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetBuyerInvoiceInfoWithSingleId()
    {
        $orderSn = '123456789';
        $expectedParams = [
            'queries' => [
                ['order_sn' => '123456789']
            ]
        ];
        $expectedResponse = ['invoice_info_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'order/get_buyer_invoice_info', 
                [
                    RequestOptions::JSON => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->getBuyerInvoiceInfo($orderSn);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testHandleBuyerCancellation()
    {
        $orderSn = '123456789';
        $operation = 'ACCEPT';
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'order/handle_buyer_cancellation', 
                [
                    RequestOptions::JSON => [
                        'order_sn' => $orderSn,
                        'operation' => $operation
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->order->handleBuyerCancellation($orderSn, $operation);

        $this->assertEquals($expectedResponse, $result);
    }
}
