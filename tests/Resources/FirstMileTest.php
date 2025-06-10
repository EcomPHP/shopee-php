<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\FirstMile;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class FirstMileTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var FirstMile
     */
    private $firstMile;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->firstMile = new FirstMile();
        $this->firstMile->useApiClient($this->client);
    }
    
    public function testGetUnbindOrderList()
    {
        $params = ['page_size' => 100, 'cursor' => 'abc123'];
        $expectedParams = [
            'page_size' => 100, 
            'response_optional_fields' => 'logistics_status,package_number',
            'cursor' => 'abc123'
        ];
        $expectedResponse = ['order_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'first_mile/get_unbind_order_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->getUnbindOrderList($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetUnbindOrderListWithDefaultParams()
    {
        $expectedParams = [
            'page_size' => 50, 
            'response_optional_fields' => 'logistics_status,package_number'
        ];
        $expectedResponse = ['order_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'first_mile/get_unbind_order_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->getUnbindOrderList();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetDetail()
    {
        $trackingNumber = 'FM123456789';
        $cursor = 'abc123';
        $expectedParams = [
            'first_mile_tracking_number' => $trackingNumber,
            'cursor' => $cursor
        ];
        $expectedResponse = ['first_mile_detail' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'first_mile/get_detail', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->getDetail($trackingNumber, $cursor);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetDetailWithoutCursor()
    {
        $trackingNumber = 'FM123456789';
        $expectedParams = [
            'first_mile_tracking_number' => $trackingNumber
        ];
        $expectedResponse = ['first_mile_detail' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'first_mile/get_detail', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->getDetail($trackingNumber);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGenerateFirstMileTrackingNumber()
    {
        $declareDate = '2023-01-01';
        $quantity = 5;
        $expectedResponse = ['tracking_number_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'first_mile/generate_first_mile_tracking_number', 
                [
                    RequestOptions::JSON => [
                        'declare_date' => $declareDate,
                        'quantity' => $quantity
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->generateFirstMileTrackingNumber($declareDate, $quantity);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGenerateFirstMileTrackingNumberWithDefaultQuantity()
    {
        $declareDate = '2023-01-01';
        $expectedResponse = ['tracking_number_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'first_mile/generate_first_mile_tracking_number', 
                [
                    RequestOptions::JSON => [
                        'declare_date' => $declareDate,
                        'quantity' => 1
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->generateFirstMileTrackingNumber($declareDate);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testBindFirstMileTrackingNumber()
    {
        $data = [
            'first_mile_tracking_number' => 'FM123456789',
            'order_list' => [
                ['order_sn' => '123456789', 'package_number' => 'PKG123']
            ]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'first_mile/bind_first_mile_tracking_number', 
                [
                    RequestOptions::JSON => $data
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->bindFirstMileTrackingNumber($data);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUnbindFirstMileTrackingNumber()
    {
        $trackingNumber = 'FM123456789';
        $orderList = [
            ['order_sn' => '123456789', 'package_number' => 'PKG123']
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'first_mile/unbind_first_mile_tracking_number', 
                [
                    RequestOptions::JSON => [
                        'first_mile_tracking_number' => $trackingNumber,
                        'order_list' => $orderList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->unbindFirstMileTrackingNumber($trackingNumber, $orderList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetTrackingNumberList()
    {
        $params = [
            'from_date' => '2023-01-01',
            'to_date' => '2023-01-31',
            'page_size' => 100
        ];
        $expectedParams = [
            'from_date' => '2023-01-01',
            'to_date' => '2023-01-31',
            'page_size' => 100
        ];
        $expectedResponse = ['tracking_number_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'first_mile/get_tracking_number_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->getTrackingNumberList($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetTrackingNumberListWithDefaultParams()
    {
        $expectedParams = [
            'from_date' => date('Y-m-d', strtotime('-7 days')),
            'to_date' => date('Y-m-d'),
            'page_size' => 50
        ];
        $expectedResponse = ['tracking_number_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'first_mile/get_tracking_number_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->getTrackingNumberList();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetWaybill()
    {
        $trackingNumberList = ['FM123456789', 'FM987654321'];
        $expectedResponse = ['result_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'first_mile/get_waybill', 
                [
                    RequestOptions::JSON => [
                        'first_mile_tracking_number_list' => $trackingNumberList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->getWaybill($trackingNumberList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetChannelList()
    {
        $region = 'TW';
        $expectedResponse = ['channel_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'first_mile/get_channel_list', 
                [
                    RequestOptions::QUERY => [
                        'region' => $region
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->getChannelList($region);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetChannelListWithoutRegion()
    {
        $expectedResponse = ['channel_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'first_mile/get_channel_list', 
                [
                    RequestOptions::QUERY => [
                        'region' => null
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->firstMile->getChannelList();
        
        $this->assertEquals($expectedResponse, $result);
    }
}
