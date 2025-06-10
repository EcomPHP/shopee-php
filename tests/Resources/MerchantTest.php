<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Merchant;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class MerchantTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var Merchant
     */
    private $merchant;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->merchant = new Merchant();
        $this->merchant->useApiClient($this->client);
    }
    
    public function testGetMerchantInfo()
    {
        $expectedResponse = ['merchant_info' => ['merchant_id' => 12345]];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'merchant/get_merchant_info')
            ->willReturn($expectedResponse);
        
        $result = $this->merchant->getMerchantInfo();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetShopListByMerchant()
    {
        $params = ['page_no' => 2, 'page_size' => 50];
        $expectedParams = ['page_no' => 2, 'page_size' => 50];
        $expectedResponse = ['shop_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'merchant/get_shop_list_by_merchant', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->merchant->getShopListByMerchant($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetShopListByMerchantWithDefaultParams()
    {
        $expectedParams = ['page_no' => 1, 'page_size' => 100];
        $expectedResponse = ['shop_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'merchant/get_shop_list_by_merchant', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->merchant->getShopListByMerchant();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetMerchantWarehouseLocationList()
    {
        $expectedResponse = ['location_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'merchant/get_merchant_warehouse_location_list')
            ->willReturn($expectedResponse);
        
        $result = $this->merchant->getMerchantWarehouseLocationList();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetMerchantWarehouseList()
    {
        $warehouseType = 'SELLER_WAREHOUSE';
        $cursor = ['page_number' => 1, 'page_size' => 20];
        $expectedCursor = ['page_size' => 10, 'page_number' => 1];
        $expectedResponse = ['warehouse_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'merchant/get_merchant_warehouse_list', 
                [
                    RequestOptions::JSON => [
                        'cursor' => $expectedCursor,
                        'warehouse_type' => $warehouseType
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->merchant->getMerchantWarehouseList($warehouseType, $cursor);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetWarehouseEligibleShopList()
    {
        $warehouseId = 12345;
        $warehouseType = 'SELLER_WAREHOUSE';
        $cursor = ['page_number' => 1, 'page_size' => 20];
        $expectedCursor = ['page_size' => 10, 'page_number' => 1];
        $expectedResponse = ['shop_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'merchant/get_warehouse_eligible_shop_list', 
                [
                    RequestOptions::JSON => [
                        'cursor' => $expectedCursor,
                        'warehouse_id' => $warehouseId,
                        'warehouse_type' => $warehouseType
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->merchant->getWarehouseEligibleShopList($warehouseId, $warehouseType, $cursor);
        
        $this->assertEquals($expectedResponse, $result);
    }
}
