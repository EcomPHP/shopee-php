<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\ShopFlashSale;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class ShopFlashSaleTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;

    /**
     * @var ShopFlashSale
     */
    private $shopFlashSale;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->shopFlashSale = new ShopFlashSale();
        $this->shopFlashSale->useApiClient($this->client);
    }

    public function testGetTimeSlotId()
    {
        $startTime = 1609459200;
        $endTime = 1612137600;
        $expectedResponse = ['timeslot_id' => 123];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_flash_sale/get_time_slot_id', 
                [
                    RequestOptions::QUERY => [
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->getTimeSlotId($startTime, $endTime);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testCreateShopFlashSale()
    {
        $timeslotId = '123';
        $expectedResponse = ['flash_sale_id' => 456];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_flash_sale/create_shop_flash_sale', 
                [
                    RequestOptions::JSON => [
                        'timeslot_id' => 123, // Should be converted to int
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->createShopFlashSale($timeslotId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetItemCriteria()
    {
        $expectedResponse = ['criteria' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_flash_sale/get_item_criteria'
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->getItemCriteria();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testAddShopFlashSaleItems()
    {
        $flashSaleId = 123;
        $items = [
            [
                'item_id' => 1,
                'model_id' => 1,
                'promotion_price' => 10.99,
            ]
        ];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_flash_sale/add_shop_flash_sale_items', 
                [
                    RequestOptions::JSON => [
                        'flash_sale_id' => 123,
                        'items' => $items,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->addShopFlashSaleItems($flashSaleId, $items);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopFlashSaleList()
    {
        $params = ['type' => 1, 'limit' => 20];
        $expectedParams = [
            'type' => 1,
            'offset' => 0,
            'limit' => 20,
        ];
        $expectedResponse = ['flash_sale_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_flash_sale/get_shop_flash_sale_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->getShopFlashSaleList($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopFlashSaleListWithDefaultParams()
    {
        $expectedParams = [
            'type' => 0,
            'offset' => 0,
            'limit' => 10,
        ];
        $expectedResponse = ['flash_sale_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_flash_sale/get_shop_flash_sale_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->getShopFlashSaleList();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopFlashSale()
    {
        $flashSaleId = 123;
        $expectedResponse = ['flash_sale' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_flash_sale/get_shop_flash_sale', 
                [
                    RequestOptions::QUERY => [
                        'flash_sale_id' => 123,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->getShopFlashSale($flashSaleId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopFlashSaleItems()
    {
        $flashSaleId = 123;
        $offset = 10;
        $limit = 20;
        $expectedResponse = ['items' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_flash_sale/get_shop_flash_sale_items', 
                [
                    RequestOptions::QUERY => [
                        'offset' => $offset,
                        'limit' => $limit,
                        'flash_sale_id' => 123,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->getShopFlashSaleItems($flashSaleId, $offset, $limit);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopFlashSaleItemsWithDefaultParams()
    {
        $flashSaleId = 123;
        $expectedResponse = ['items' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop_flash_sale/get_shop_flash_sale_items', 
                [
                    RequestOptions::QUERY => [
                        'offset' => 0,
                        'limit' => 10,
                        'flash_sale_id' => 123,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->getShopFlashSaleItems($flashSaleId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUpdateShopFlashSale()
    {
        $flashSaleId = 123;
        $status = 'ONGOING';
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_flash_sale/update_shop_flash_sale', 
                [
                    RequestOptions::JSON => [
                        'status' => $status,
                        'flash_sale_id' => 123,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->updateShopFlashSale($flashSaleId, $status);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUpdateShopFlashSaleItems()
    {
        $flashSaleId = 123;
        $items = [
            [
                'item_id' => 1,
                'model_id' => 1,
                'promotion_price' => 9.99,
            ]
        ];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_flash_sale/update_shop_flash_sale_items', 
                [
                    RequestOptions::JSON => [
                        'flash_sale_id' => 123,
                        'items' => $items,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->updateShopFlashSaleItems($flashSaleId, $items);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDeleteShopFlashSale()
    {
        $flashSaleId = 123;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_flash_sale/delete_shop_flash_sale', 
                [
                    RequestOptions::JSON => [
                        'flash_sale_id' => 123,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->deleteShopFlashSale($flashSaleId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDeleteShopFlashSaleItems()
    {
        $flashSaleId = 123;
        $itemIds = [1, 2, 3];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop_flash_sale/delete_shop_flash_sale_items', 
                [
                    RequestOptions::JSON => [
                        'flash_sale_id' => 123,
                        'item_ids' => $itemIds,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->shopFlashSale->deleteShopFlashSaleItems($flashSaleId, $itemIds);

        $this->assertEquals($expectedResponse, $result);
    }
}
