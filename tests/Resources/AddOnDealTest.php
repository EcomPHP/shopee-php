<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\AddOnDeal;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class AddOnDealTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var AddOnDeal
     */
    private $addOnDeal;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->addOnDeal = new AddOnDeal();
        $this->addOnDeal->useApiClient($this->client);
    }
    
    public function testAddAddOnDeal()
    {
        $data = [
            'promotion_name' => 'Test Add-on Deal',
            'start_time' => 1609459200,
            'end_time' => 1612137600,
            'purchase_min_n_item' => 2
        ];
        $expectedResponse = ['add_on_deal_id' => 12345];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'add_on_deal/add_add_on_deal', 
                [
                    RequestOptions::JSON => $data
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->addAddOnDeal($data);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testAddAddOnDealMainItem()
    {
        $addOnDealId = 12345;
        $mainItemList = [
            ['item_id' => 1, 'model_id' => 0],
            ['item_id' => 2, 'model_id' => 0]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'add_on_deal/add_add_on_deal_main_item', 
                [
                    RequestOptions::JSON => [
                        'add_on_deal_id' => $addOnDealId,
                        'main_item_list' => $mainItemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->addAddOnDealMainItem($addOnDealId, $mainItemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testAddAddOnDealSubItem()
    {
        $addOnDealId = 12345;
        $subItemList = [
            ['item_id' => 3, 'model_id' => 0],
            ['item_id' => 4, 'model_id' => 0]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'add_on_deal/add_add_on_deal_sub_item', 
                [
                    RequestOptions::JSON => [
                        'add_on_deal_id' => $addOnDealId,
                        'sub_item_list' => $subItemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->addAddOnDealSubItem($addOnDealId, $subItemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeleteAddOnDeal()
    {
        $addOnDealId = 12345;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'add_on_deal/delete_add_on_deal', 
                [
                    RequestOptions::JSON => [
                        'add_on_deal_id' => $addOnDealId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->deleteAddOnDeal($addOnDealId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeleteAddOnDealMainItem()
    {
        $addOnDealId = 12345;
        $mainItemList = [
            ['item_id' => 1, 'model_id' => 0],
            ['item_id' => 2, 'model_id' => 0]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'add_on_deal/delete_add_on_deal_main_item', 
                [
                    RequestOptions::JSON => [
                        'add_on_deal_id' => $addOnDealId,
                        'main_item_list' => $mainItemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->deleteAddOnDealMainItem($addOnDealId, $mainItemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeleteAddOnDealSubItem()
    {
        $addOnDealId = 12345;
        $subItemList = [
            ['item_id' => 3, 'model_id' => 0],
            ['item_id' => 4, 'model_id' => 0]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'add_on_deal/delete_add_on_deal_sub_item', 
                [
                    RequestOptions::JSON => [
                        'add_on_deal_id' => $addOnDealId,
                        'sub_item_list' => $subItemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->deleteAddOnDealSubItem($addOnDealId, $subItemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAddOnDealList()
    {
        $params = ['page_no' => 2, 'page_size' => 50, 'promotion_status' => 'ongoing'];
        $expectedParams = ['page_no' => 2, 'page_size' => 50, 'promotion_status' => 'ongoing'];
        $expectedResponse = ['add_on_deal_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'add_on_deal/get_add_on_deal_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->getAddOnDealList($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAddOnDealListWithDefaultParams()
    {
        $expectedParams = ['page_no' => 1, 'page_size' => 100, 'promotion_status' => 'all'];
        $expectedResponse = ['add_on_deal_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'add_on_deal/get_add_on_deal_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->getAddOnDealList();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAddOnDeal()
    {
        $addOnDealId = 12345;
        $expectedResponse = ['add_on_deal' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'add_on_deal/get_add_on_deal', 
                [
                    RequestOptions::QUERY => [
                        'add_on_deal_id' => $addOnDealId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->getAddOnDeal($addOnDealId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAddOnDealMainItem()
    {
        $addOnDealId = 12345;
        $expectedResponse = ['main_item_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'add_on_deal/get_add_on_deal_main_item', 
                [
                    RequestOptions::QUERY => [
                        'add_on_deal_id' => $addOnDealId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->getAddOnDealMainItem($addOnDealId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAddOnDealSubItem()
    {
        $addOnDealId = 12345;
        $expectedResponse = ['sub_item_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'add_on_deal/get_add_on_deal_sub_item', 
                [
                    RequestOptions::QUERY => [
                        'add_on_deal_id' => $addOnDealId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->getAddOnDealSubItem($addOnDealId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateAddOnDeal()
    {
        $addOnDealId = 12345;
        $data = [
            'promotion_name' => 'Updated Add-on Deal',
            'end_time' => 1614556800
        ];
        $expectedData = [
            'promotion_name' => 'Updated Add-on Deal',
            'end_time' => 1614556800,
            'add_on_deal_id' => $addOnDealId
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'add_on_deal/update_add_on_deal', 
                [
                    RequestOptions::JSON => $expectedData
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->updateAddOnDeal($addOnDealId, $data);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateAddOnDealMainItem()
    {
        $addOnDealId = 12345;
        $mainItemList = [
            ['item_id' => 1, 'model_id' => 0, 'status' => 'NORMAL'],
            ['item_id' => 2, 'model_id' => 0, 'status' => 'NORMAL']
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'add_on_deal/update_add_on_deal_main_item', 
                [
                    RequestOptions::JSON => [
                        'add_on_deal_id' => $addOnDealId,
                        'main_item_list' => $mainItemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->updateAddOnDealMainItem($addOnDealId, $mainItemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateAddOnDealSubItem()
    {
        $addOnDealId = 12345;
        $subItemList = [
            ['item_id' => 3, 'model_id' => 0, 'status' => 'NORMAL'],
            ['item_id' => 4, 'model_id' => 0, 'status' => 'NORMAL']
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'add_on_deal/update_add_on_deal_sub_item', 
                [
                    RequestOptions::JSON => [
                        'add_on_deal_id' => $addOnDealId,
                        'sub_item_list' => $subItemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->updateAddOnDealSubItem($addOnDealId, $subItemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testEndAddOnDeal()
    {
        $addOnDealId = 12345;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'add_on_deal/end_add_on_deal', 
                [
                    RequestOptions::JSON => [
                        'add_on_deal_id' => $addOnDealId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->addOnDeal->endAddOnDeal($addOnDealId);
        
        $this->assertEquals($expectedResponse, $result);
    }
}
