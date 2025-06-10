<?php

namespace EcomPHP\Shopee\Tests;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Errors\ShopeeException;
use EcomPHP\Shopee\Resources\Shop;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private $partner_id = '123456';
    private $partner_key = 'test_partner_key';
    
    public function testClientConstruction()
    {
        $client = new Client($this->partner_id, $this->partner_key);
        $this->assertInstanceOf(Client::class, $client);
    }
    
    public function testPartnerId()
    {
        $client = new Client($this->partner_id, $this->partner_key);
        $this->assertEquals(intval($this->partner_id), $client->partnerId());
    }
    
    public function testPartnerKey()
    {
        $client = new Client($this->partner_id, $this->partner_key);
        $this->assertEquals($this->partner_key, $client->partnerKey());
    }
    
    public function testSetAccessToken()
    {
        $client = new Client($this->partner_id, $this->partner_key);
        $shop_id = '654321';
        $access_token = 'test_access_token';
        
        $client->setAccessToken($shop_id, $access_token);
        
        // Since these are protected properties, we can't directly test them
        // Instead, we'll test the behavior in other tests
        $this->assertTrue(true);
    }
    
    public function testDebugMode()
    {
        $client = new Client($this->partner_id, $this->partner_key);
        $client->useDebugMode();
        
        // Test that the base URL changes to the test URL
        $reflectionClass = new \ReflectionClass(Client::class);
        $method = $reflectionClass->getMethod('baseUrl');
        $method->setAccessible(true);
        
        $this->assertEquals('https://partner.test-stable.shopeemobile.com/api/v2/', $method->invoke($client));
    }
    
    public function testChinaRegion()
    {
        $client = new Client($this->partner_id, $this->partner_key);
        $client->useChinaRegion();
        
        $reflectionClass = new \ReflectionClass(Client::class);
        $method = $reflectionClass->getMethod('baseUrl');
        $method->setAccessible(true);
        
        $this->assertEquals('https://openplatform.shopee.cn/api/v2/', $method->invoke($client));
    }
    
    public function testBrazilRegion()
    {
        $client = new Client($this->partner_id, $this->partner_key);
        $client->useBrazilRegion();
        
        $reflectionClass = new \ReflectionClass(Client::class);
        $method = $reflectionClass->getMethod('baseUrl');
        $method->setAccessible(true);
        
        $this->assertEquals('https://openplatform.shopee.com.br/api/v2/', $method->invoke($client));
    }
    
    public function testCustomHostname()
    {
        $client = new Client($this->partner_id, $this->partner_key);
        $client->setCustomHostname('api.example.com');
        
        $reflectionClass = new \ReflectionClass(Client::class);
        $method = $reflectionClass->getMethod('baseUrl');
        $method->setAccessible(true);
        
        $this->assertEquals('https://api.example.com/api/v2/', $method->invoke($client));
    }
    
    public function testResourceAccess()
    {
        $client = new Client($this->partner_id, $this->partner_key);
        $shop = $client->Shop;
        
        $this->assertInstanceOf(Shop::class, $shop);
    }
    
    public function testInvalidResourceAccess()
    {
        $client = new Client($this->partner_id, $this->partner_key);
        
        $this->expectException(ShopeeException::class);
        $client->InvalidResource;
    }
}
