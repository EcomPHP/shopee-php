<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\ShopCategory;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class ShopCategoryTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;

    /**
     * @var ShopCategory
     */
    private $shopCategory;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->shopCategory = new ShopCategory();
        $this->shopCategory->useApiClient($this->client);
    }

    public function testAddShopCategory()
    {
        $name = 'Test Category';
        $sortWeight = 100;
        $expectedResponse = ['shop_category_id' => 123];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_category/add_shop_category', 
                [
                    RequestOptions::JSON => [
                        'name' => $name,
                        'sort_weight' => $sortWeight,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopCategory->addShopCategory($name, $sortWeight);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopCategoryList()
    {
        $params = ['page_no' => 2];
        $expectedParams = [
            'page_no' => 2,
            'page_size' => 100,
        ];
        $expectedResponse = ['shop_categorys' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_category/get_shop_category_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopCategory->getShopCategoryList($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopCategoryListWithDefaultParams()
    {
        $expectedParams = [
            'page_no' => 1,
            'page_size' => 100,
        ];
        $expectedResponse = ['shop_categorys' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_category/get_shop_category_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopCategory->getShopCategoryList();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDeleteShopCategory()
    {
        $shopCategoryId = 123;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_category/delete_shop_category', 
                [
                    RequestOptions::JSON => [
                        'shop_category_id' => $shopCategoryId,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopCategory->deleteShopCategory($shopCategoryId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUpdateShopCategory()
    {
        $shopCategoryId = 123;
        $name = 'Updated Category';
        $sortWeight = 200;
        $status = 'NORMAL';
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_category/update_shop_category', 
                [
                    RequestOptions::JSON => [
                        'shop_category_id' => $shopCategoryId,
                        'name' => $name,
                        'sort_weight' => $sortWeight,
                        'status' => $status,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopCategory->updateShopCategory($shopCategoryId, $name, $sortWeight, $status);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testAddItemList()
    {
        $shopCategoryId = 123;
        $itemIdList = [1, 2, 3];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_category/add_item_list', 
                [
                    RequestOptions::JSON => [
                        'shop_category_id' => $shopCategoryId,
                        'item_list' => $itemIdList,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopCategory->addItemList($shopCategoryId, $itemIdList);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetItemList()
    {
        $shopCategoryId = 123;
        $params = ['page_no' => 2];
        $expectedParams = [
            'shop_category_id' => $shopCategoryId,
            'page_no' => 2,
            'page_size' => 100,
        ];
        $expectedResponse = ['items' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_category/get_item_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopCategory->getItemList($shopCategoryId, $params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetItemListWithDefaultParams()
    {
        $shopCategoryId = 123;
        $expectedParams = [
            'shop_category_id' => $shopCategoryId,
            'page_no' => 1,
            'page_size' => 100,
        ];
        $expectedResponse = ['items' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_category/get_item_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopCategory->getItemList($shopCategoryId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDeleteItemList()
    {
        $shopCategoryId = 123;
        $itemIdList = [1, 2, 3];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_category/delete_item_list', 
                [
                    RequestOptions::JSON => [
                        'shop_category_id' => $shopCategoryId,
                        'item_list' => $itemIdList,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopCategory->deleteItemList($shopCategoryId, $itemIdList);

        $this->assertEquals($expectedResponse, $result);
    }
}
