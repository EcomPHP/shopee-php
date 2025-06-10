<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\BundleDeal;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class BundleDealTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var BundleDeal
     */
    private $bundleDeal;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->bundleDeal = new BundleDeal();
        $this->bundleDeal->useApiClient($this->client);
    }
    
    public function testAddBundleDeal()
    {
        $data = [
            'name' => 'Test Bundle Deal',
            'start_time' => 1609459200,
            'end_time' => 1612137600,
            'rule_type' => 1,
            'promotion_type' => 1
        ];
        $expectedResponse = ['bundle_deal_id' => 12345];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'bundle_deal/add_bundle_deal', 
                [
                    RequestOptions::JSON => $data
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->addBundleDeal($data);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testAddBundleDealItem()
    {
        $bundleDealId = 12345;
        $itemList = [
            ['item_id' => 1, 'model_id' => 0],
            ['item_id' => 2, 'model_id' => 0]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'bundle_deal/add_bundle_deal_item', 
                [
                    RequestOptions::JSON => [
                        'bundle_deal_id' => $bundleDealId,
                        'item_list' => $itemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->addBundleDealItem($bundleDealId, $itemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetBundleDealList()
    {
        $params = ['page_no' => 2, 'page_size' => 50, 'time_status' => 3];
        $expectedParams = ['page_no' => 2, 'page_size' => 50, 'time_status' => 3];
        $expectedResponse = ['bundle_deal_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'bundle_deal/get_bundle_deal_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->getBundleDealList($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetBundleDealListWithDefaultParams()
    {
        $expectedParams = ['page_no' => 1, 'page_size' => 100, 'time_status' => 1];
        $expectedResponse = ['bundle_deal_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'bundle_deal/get_bundle_deal_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->getBundleDealList();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetBundleDeal()
    {
        $bundleDealId = 12345;
        $expectedResponse = ['bundle_deal' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'bundle_deal/get_bundle_deal', 
                [
                    RequestOptions::QUERY => [
                        'bundle_deal_id' => $bundleDealId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->getBundleDeal($bundleDealId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetBundleDealItem()
    {
        $bundleDealId = 12345;
        $expectedResponse = ['item_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'bundle_deal/get_bundle_deal_item', 
                [
                    RequestOptions::QUERY => [
                        'bundle_deal_id' => $bundleDealId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->getBundleDealItem($bundleDealId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateBundleDeal()
    {
        $bundleDealId = 12345;
        $data = [
            'name' => 'Updated Bundle Deal',
            'end_time' => 1614556800
        ];
        $expectedData = [
            'name' => 'Updated Bundle Deal',
            'end_time' => 1614556800,
            'bundle_deal_id' => $bundleDealId
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'bundle_deal/update_bundle_deal', 
                [
                    RequestOptions::JSON => $expectedData
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->updateBundleDeal($bundleDealId, $data);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateBundleDealItem()
    {
        $bundleDealId = 12345;
        $itemList = [
            ['item_id' => 1, 'model_id' => 0, 'status' => 'NORMAL'],
            ['item_id' => 2, 'model_id' => 0, 'status' => 'NORMAL']
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'bundle_deal/update_bundle_deal_item', 
                [
                    RequestOptions::JSON => [
                        'bundle_deal_id' => $bundleDealId,
                        'item_list' => $itemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->updateBundleDealItem($bundleDealId, $itemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testEndBundleDeal()
    {
        $bundleDealId = 12345;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'bundle_deal/end_bundle_deal', 
                [
                    RequestOptions::JSON => [
                        'bundle_deal_id' => $bundleDealId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->endBundleDeal($bundleDealId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeleteBundleDeal()
    {
        $bundleDealId = 12345;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'bundle_deal/delete_bundle_deal', 
                [
                    RequestOptions::JSON => [
                        'bundle_deal_id' => $bundleDealId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->deleteBundleDeal($bundleDealId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeleteBundleDealItem()
    {
        $bundleDealId = 12345;
        $itemList = [
            ['item_id' => 1, 'model_id' => 0],
            ['item_id' => 2, 'model_id' => 0]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'bundle_deal/delete_bundle_deal_item', 
                [
                    RequestOptions::JSON => [
                        'bundle_deal_id' => $bundleDealId,
                        'item_list' => $itemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->bundleDeal->deleteBundleDealItem($bundleDealId, $itemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
}
