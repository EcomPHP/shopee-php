<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Shop;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class ShopTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var Shop
     */
    private $shop;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->shop = new Shop();
        $this->shop->useApiClient($this->client);
    }
    
    public function testGetShopInfo()
    {
        $expectedResponse = ['shop_info' => ['shop_id' => 123]];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'shop/get_shop_info')
            ->willReturn($expectedResponse);
        
        $result = $this->shop->getShopInfo();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetProfile()
    {
        $expectedResponse = ['profile' => ['shop_name' => 'Test Shop']];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'shop/get_profile')
            ->willReturn($expectedResponse);
        
        $result = $this->shop->getProfile();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateProfile()
    {
        $shopName = 'New Shop Name';
        $shopLogo = 'https://example.com/logo.png';
        $description = 'New shop description';
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'shop/update_profile', 
                [
                    RequestOptions::JSON => [
                        'shop_name' => $shopName,
                        'shop_logo' => $shopLogo,
                        'description' => $description,
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->shop->updateProfile($shopName, $shopLogo, $description);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetWarehouseDetail()
    {
        $expectedResponse = ['warehouse_list' => [['warehouse_id' => 1]]];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'shop/get_warehouse_detail')
            ->willReturn($expectedResponse);
        
        $result = $this->shop->getWarehouseDetail();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetShopNotification()
    {
        $params = ['page_size' => 10, 'page_no' => 1];
        $expectedResponse = ['notifications' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop/get_shop_notification', 
                [
                    RequestOptions::QUERY => $params
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->shop->getShopNotification($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAuthorizedResellerBrand()
    {
        $params = ['page_size' => 20, 'page_no' => 2];
        $expectedParams = ['page_size' => 20, 'page_no' => 2];
        $expectedResponse = ['brand_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop/get_authorised_reseller_brand', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->shop->getAuthorizedResellerBrand($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAuthorizedResellerBrandWithDefaultParams()
    {
        $expectedParams = ['page_no' => 1, 'page_size' => 10];
        $expectedResponse = ['brand_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'shop/get_authorised_reseller_brand', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->shop->getAuthorizedResellerBrand();
        
        $this->assertEquals($expectedResponse, $result);
    }
}
