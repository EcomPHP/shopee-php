<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Authorization;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class AuthorizationTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var Authorization
     */
    private $authorization;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->authorization = new Authorization();
        $this->authorization->useApiClient($this->client);
    }
    
    public function testGetShopsByPartner()
    {
        $params = ['page_no' => 2, 'page_size' => 50];
        $expectedParams = ['page_no' => 2, 'page_size' => 50];
        $expectedResponse = ['shop_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'public/get_shops_by_partner', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->authorization->getShopsByPartner($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetShopsByPartnerWithDefaultParams()
    {
        $expectedParams = ['page_no' => 1, 'page_size' => 100];
        $expectedResponse = ['shop_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'public/get_shops_by_partner', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->authorization->getShopsByPartner();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetMerchantsByPartner()
    {
        $params = ['page_no' => 2, 'page_size' => 50];
        $expectedParams = ['page_no' => 2, 'page_size' => 50];
        $expectedResponse = ['merchant_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'public/get_merchants_by_partner', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->authorization->getMerchantsByPartner($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetMerchantsByPartnerWithDefaultParams()
    {
        $expectedParams = ['page_no' => 1, 'page_size' => 100];
        $expectedResponse = ['merchant_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'public/get_merchants_by_partner', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->authorization->getMerchantsByPartner();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetToken()
    {
        $code = 'auth_code';
        $shopId = 123456;
        $partnerId = 654321;
        $expectedResponse = ['access_token' => 'token123', 'refresh_token' => 'refresh123'];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'auth/token/get', 
                [
                    RequestOptions::JSON => [
                        'code' => $code,
                        'shop_id' => $shopId,
                        'partner_id' => $partnerId,
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->authorization->getToken($code, $shopId, $partnerId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testRefreshNewToken()
    {
        $refreshToken = 'refresh_token_123';
        $shopId = 123456;
        $partnerId = 654321;
        $expectedResponse = ['access_token' => 'new_token123', 'refresh_token' => 'new_refresh123'];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'auth/access_token/get', 
                [
                    RequestOptions::JSON => [
                        'refresh_token' => $refreshToken,
                        'shop_id' => $shopId,
                        'partner_id' => $partnerId,
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->authorization->refreshNewToken($refreshToken, $shopId, $partnerId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetTokenByResendCode()
    {
        $resendCode = 'resend_code_123';
        $expectedResponse = ['access_token' => 'token123', 'refresh_token' => 'refresh123'];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'public/get_token_by_resend_code', 
                [
                    RequestOptions::JSON => [
                        'resend_code' => $resendCode,
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->authorization->getTokenByResendCode($resendCode);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetRefreshTokenByUpgradeCode()
    {
        $upgradeCode = 'upgrade_code_123';
        $shopIdList = [123, 456, 789];
        $expectedResponse = ['refresh_token_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'public/get_refresh_token_by_upgrade_code', 
                [
                    RequestOptions::JSON => [
                        'upgrade_code' => $upgradeCode,
                        'shop_id_list' => $shopIdList,
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->authorization->getRefreshTokenByUpgradeCode($upgradeCode, $shopIdList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetShopeeIpRanges()
    {
        $expectedResponse = ['ip_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'public/get_shopee_ip_ranges')
            ->willReturn($expectedResponse);
        
        $result = $this->authorization->getShopeeIpRanges();
        
        $this->assertEquals($expectedResponse, $result);
    }
}
