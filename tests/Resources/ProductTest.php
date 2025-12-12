<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Product;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var Product
     */
    private $product;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->product = new Product();
        $this->product->useApiClient($this->client);
    }
    
    public function testGetCategory()
    {
        $params = ['language' => 'en'];
        $expectedResponse = ['categories' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_category', 
                [
                    RequestOptions::QUERY => $params
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getCategory($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAttributes()
    {
        $categoryId = 123;
        $language = 'en';
        $expectedResponse = ['attributes' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_attributes', 
                [
                    RequestOptions::QUERY => [
                        'category_id' => $categoryId,
                        'language' => $language
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getAttributes($categoryId, $language);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAttributesWithoutLanguage()
    {
        $categoryId = 123;
        $expectedResponse = ['attributes' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_attributes', 
                [
                    RequestOptions::QUERY => [
                        'category_id' => $categoryId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getAttributes($categoryId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAttributeTree()
    {
        $categoryIdList = [123, 456];
        $language = 'en';
        $expectedResponse = ['attribute_tree' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_attribute_tree', 
                [
                    RequestOptions::QUERY => [
                        'category_id_list' => '123,456',
                        'language' => $language
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getAttributeTree($categoryIdList, $language);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAttributeTreeWithSingleId()
    {
        $categoryId = 123;
        $language = 'en';
        $expectedResponse = ['attribute_tree' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_attribute_tree', 
                [
                    RequestOptions::QUERY => [
                        'category_id_list' => '123',
                        'language' => $language
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getAttributeTree($categoryId, $language);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetBrandList()
    {
        $categoryId = 123;
        $params = ['offset' => 10, 'page_size' => 20];
        $expectedParams = [
            'offset' => 10,
            'page_size' => 20,
            'status' => 1,
            'category_id' => $categoryId
        ];
        $expectedResponse = ['brand_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_brand_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getBrandList($categoryId, $params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetModelList()
    {
        $itemId = 12345;
        $expectedResponse = ['model_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_model_list', 
                [
                    RequestOptions::QUERY => [
                        'item_id' => $itemId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getModelList($itemId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetItemList()
    {
        $params = ['offset' => 10, 'page_size' => 50, 'item_status' => 'NORMAL'];
        $expectedResponse = ['item_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_item_list', 
                [
                    RequestOptions::QUERY => $params
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getItemList($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetItemListWithDefaultParams()
    {
        $expectedParams = [
            'offset' => 0,
            'page_size' => 20,
            'item_status' => 'NORMAL'
        ];
        $expectedResponse = ['item_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_item_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getItemList();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetItemBaseInfo()
    {
        $itemIdList = [12345, 67890];
        $needTaxInfo = true;
        $needComplaintPolicy = true;
        $expectedResponse = ['item_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_item_base_info', 
                [
                    RequestOptions::QUERY => [
                        'item_id_list' => '12345,67890',
                        'need_tax_info' => true,
                        'need_complaint_policy' => true
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getItemBaseInfo($itemIdList, $needTaxInfo, $needComplaintPolicy);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testBoostItem()
    {
        $itemIdList = [12345, 67890];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'product/boost_item', 
                [
                    RequestOptions::JSON => [
                        'item_id_list' => $itemIdList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->boostItem($itemIdList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetBoostedList()
    {
        $expectedResponse = ['boosted_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'product/get_boosted_list')
            ->willReturn($expectedResponse);
        
        $result = $this->product->getBoostedList();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetComment()
    {
        $params = ['item_id' => 12345, 'cursor' => 'abc', 'page_size' => 50];
        $expectedParams = [
            'cursor' => 'abc',
            'page_size' => 50,
            'item_id' => 12345
        ];
        $expectedResponse = ['comments' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'product/get_comment', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->getComment($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testReplyComment()
    {
        $commentId = 12345;
        $comment = 'Thank you for your feedback!';
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'product/reply_comment', 
                [
                    RequestOptions::JSON => [
                        'comment_list' => [
                            [
                                'comment_id' => $commentId,
                                'comment' => $comment
                            ]
                        ]
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->replyComment($commentId, $comment);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testAddItem()
    {
        $params = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.99
        ];
        $expectedResponse = ['item_id' => 12345];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'product/add_item', 
                [
                    RequestOptions::JSON => $params
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->addItem($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateItem()
    {
        $itemId = 12345;
        $params = [
            'name' => 'Updated Product',
            'description' => 'Updated Description'
        ];
        $expectedParams = [
            'name' => 'Updated Product',
            'description' => 'Updated Description',
            'item_id' => $itemId
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'product/update_item', 
                [
                    RequestOptions::JSON => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->updateItem($itemId, $params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeleteItem()
    {
        $itemId = 12345;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'product/delete_item', 
                [
                    RequestOptions::JSON => [
                        'item_id' => $itemId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->deleteItem($itemId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testInitTierVariation()
    {
        $itemId = 12345;
        $tierVariation = [
            ['name' => 'Color', 'options' => ['Red', 'Blue']]
        ];
        $model = [
            ['tier_index' => [0], 'price' => 10.99]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'product/init_tier_variation',
                [
                    RequestOptions::JSON => [
                        'item_id' => $itemId,
                        'tier_variation' => $tierVariation,
                        'model' => $model
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->initTierVariation($itemId, $tierVariation, $model);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateTierVariation()
    {
        $itemId = 12345;
        $tierVariation = [
            ['name' => 'Color', 'options' => ['Red', 'Blue', 'Green']]
        ];
        $modelList = [
            ['tier_index' => [0], 'price' => 10.99],
            ['tier_index' => [1], 'price' => 11.99],
            ['tier_index' => [2], 'price' => 12.99]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'product/update_tier_variation',
                [
                    RequestOptions::JSON => [
                        'item_id' => $itemId,
                        'tier_variation' => $tierVariation,
                        'model_list' => $modelList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->updateTierVariation($itemId, $tierVariation, $modelList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testAddModel()
    {
        $itemId = 12345;
        $modelList = [
            ['tier_index' => [2], 'price' => 12.99]
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'product/add_model', 
                [
                    RequestOptions::JSON => [
                        'item_id' => $itemId,
                        'model_list' => $modelList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->product->addModel($itemId, $modelList);
        
        $this->assertEquals($expectedResponse, $result);
    }
}
