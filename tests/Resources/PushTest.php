<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Push;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class PushTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var Push
     */
    private $push;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->push = new Push();
        $this->push->useApiClient($this->client);
    }
    
    public function testSetAppPushConfig()
    {
        $callbackUrl = 'https://example.com/callback';
        $setOn = ['order', 'product'];
        $setOff = ['payment'];
        $blockedShopIdList = [12345, 67890];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'push/set_app_push_config', 
                [
                    RequestOptions::JSON => [
                        'callback_url' => $callbackUrl,
                        'set_push_config_on' => $setOn,
                        'set_push_config_off' => $setOff,
                        'blocked_shop_id_list' => $blockedShopIdList
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->push->setAppPushConfig($callbackUrl, $setOn, $setOff, $blockedShopIdList);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testSetAppPushConfigWithDefaultParams()
    {
        $callbackUrl = 'https://example.com/callback';
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'push/set_app_push_config', 
                [
                    RequestOptions::JSON => [
                        'callback_url' => $callbackUrl,
                        'set_push_config_on' => [],
                        'set_push_config_off' => [],
                        'blocked_shop_id_list' => []
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->push->setAppPushConfig($callbackUrl);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAppPushConfig()
    {
        $expectedResponse = [
            'callback_url' => 'https://example.com/callback',
            'push_config' => ['order' => true, 'product' => true, 'payment' => false],
            'blocked_shop_id_list' => [12345, 67890]
        ];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'push/get_app_push_config')
            ->willReturn($expectedResponse);
        
        $result = $this->push->getAppPushConfig();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetLostPushMessage()
    {
        $expectedResponse = ['message_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'push/get_lost_push_message')
            ->willReturn($expectedResponse);
        
        $result = $this->push->getLostPushMessage();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testConfirmConsumedLostPushMessage()
    {
        $lastMessageId = 12345;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'push/confirm_consumed_lost_push_message', 
                [
                    RequestOptions::JSON => [
                        'last_message_id' => $lastMessageId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->push->confirmConsumedLostPushMessage($lastMessageId);
        
        $this->assertEquals($expectedResponse, $result);
    }
}
