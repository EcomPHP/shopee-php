<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Discount;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class DiscountTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var Discount
     */
    private $discount;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->discount = new Discount();
        $this->discount->useApiClient($this->client);
    }
    
    public function testAddDiscount()
    {
        $data = [
            'discount_name' => 'Test Discount',
            'start_time' => 1609459200,
            'end_time' => 1612137600,
            'items' => [
                ['item_id' => 1, 'model_id' => 0, 'promotion_price' => 9.99]
            ]
        ];
        $expectedResponse = ['discount_id' => 12345];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'discount/add_discount', 
                [
                    RequestOptions::JSON => $data
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->addDiscount($data);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testAddDiscountItem()
    {
        $discountId = 12345;
        $itemList = [
            ['item_id' => 1, 'model_id' => 0, 'promotion_price' => 9.99],
            ['item_id' => 2, 'model_id' => 0, 'promotion_price' => 19.99]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'discount/add_discount_item', 
                [
                    RequestOptions::JSON => [
                        'discount_id' => $discountId,
                        'item_list' => $itemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->addDiscountItem($discountId, $itemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeleteDiscount()
    {
        $discountId = 12345;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'discount/delete_discount', 
                [
                    RequestOptions::JSON => [
                        'discount_id' => $discountId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->deleteDiscount($discountId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeleteDiscountItem()
    {
        $discountId = 12345;
        $itemId = 1;
        $modelId = 0;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'discount/delete_discount_item', 
                [
                    RequestOptions::JSON => [
                        'discount_id' => $discountId,
                        'item_id' => $itemId,
                        'model_id' => $modelId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->deleteDiscountItem($discountId, $itemId, $modelId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeleteDiscountItemWithoutModelId()
    {
        $discountId = 12345;
        $itemId = 1;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'discount/delete_discount_item', 
                [
                    RequestOptions::JSON => [
                        'discount_id' => $discountId,
                        'item_id' => $itemId,
                        'model_id' => null
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->deleteDiscountItem($discountId, $itemId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetDiscount()
    {
        $discountId = 12345;
        $params = ['page_no' => 2, 'page_size' => 100];
        $expectedParams = [
            'page_no' => 2,
            'page_size' => 100,
            'discount_id' => $discountId
        ];
        $expectedResponse = ['discount' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'discount/get_discount', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->getDiscount($discountId, $params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetDiscountWithDefaultParams()
    {
        $discountId = 12345;
        $expectedParams = [
            'page_no' => 1,
            'page_size' => 50,
            'discount_id' => $discountId
        ];
        $expectedResponse = ['discount' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'discount/get_discount', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->getDiscount($discountId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetDiscountList()
    {
        $params = ['discount_status' => 'ongoing', 'page_no' => 2, 'page_size' => 100];
        $expectedParams = ['discount_status' => 'ongoing', 'page_no' => 2, 'page_size' => 100];
        $expectedResponse = ['discount_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'discount/get_discount_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->getDiscountList($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetDiscountListWithDefaultParams()
    {
        $expectedParams = ['discount_status' => 'all', 'page_no' => 1, 'page_size' => 50];
        $expectedResponse = ['discount_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'discount/get_discount_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->getDiscountList();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateDiscount()
    {
        $discountId = 12345;
        $data = [
            'discount_name' => 'Updated Discount',
            'end_time' => 1614556800
        ];
        $expectedData = [
            'discount_name' => 'Updated Discount',
            'end_time' => 1614556800,
            'discount_id' => $discountId
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'discount/update_discount', 
                [
                    RequestOptions::JSON => $expectedData
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->updateDiscount($discountId, $data);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateDiscountItem()
    {
        $discountId = 12345;
        $itemList = [
            ['item_id' => 1, 'model_id' => 0, 'promotion_price' => 8.99],
            ['item_id' => 2, 'model_id' => 0, 'promotion_price' => 18.99]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'discount/update_discount_item', 
                [
                    RequestOptions::JSON => [
                        'discount_id' => $discountId,
                        'item_list' => $itemList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->updateDiscountItem($discountId, $itemList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testEndDiscount()
    {
        $discountId = 12345;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'discount/end_discount', 
                [
                    RequestOptions::JSON => [
                        'discount_id' => $discountId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->discount->endDiscount($discountId);
        
        $this->assertEquals($expectedResponse, $result);
    }
}
