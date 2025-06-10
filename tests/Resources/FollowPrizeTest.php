<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\FollowPrize;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class FollowPrizeTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var FollowPrize
     */
    private $followPrize;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->followPrize = new FollowPrize();
        $this->followPrize->useApiClient($this->client);
    }
    
    public function testAddFollowPrize()
    {
        $data = [
            'name' => 'Test Follow Prize',
            'start_time' => 1609459200,
            'end_time' => 1612137600,
            'prize_count' => 10,
            'prize_amount' => 100
        ];
        $expectedResponse = ['campaign_id' => 12345];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'follow_prize/add_follow_prize', 
                [
                    RequestOptions::JSON => $data
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->followPrize->addFollowPrize($data);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeleteFollowPrize()
    {
        $campaignId = 12345;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'follow_prize/delete_follow_prize', 
                [
                    RequestOptions::JSON => [
                        'campaign_id' => $campaignId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->followPrize->deleteFollowPrize($campaignId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testEndFollowPrize()
    {
        $campaignId = 12345;
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'follow_prize/end_follow_prize', 
                [
                    RequestOptions::JSON => [
                        'campaign_id' => $campaignId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->followPrize->endFollowPrize($campaignId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateFollowPrize()
    {
        $data = [
            'campaign_id' => 12345,
            'name' => 'Updated Follow Prize',
            'end_time' => 1614556800
        ];
        $expectedResponse = ['success' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'follow_prize/update_follow_prize', 
                [
                    RequestOptions::JSON => $data
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->followPrize->updateFollowPrize($data);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetFollowPrizeDetail()
    {
        $campaignId = 12345;
        $expectedResponse = ['follow_prize' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'follow_prize/get_follow_prize_detail', 
                [
                    RequestOptions::QUERY => [
                        'campaign_id' => $campaignId
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->followPrize->getFollowPrizeDetail($campaignId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetFollowPrizeList()
    {
        $params = ['page_no' => 2, 'page_size' => 50, 'status' => 'ongoing'];
        $expectedParams = ['page_no' => 2, 'page_size' => 50, 'status' => 'ongoing'];
        $expectedResponse = ['follow_prize_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'follow_prize/get_follow_prize_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->followPrize->getFollowPrizeList($params);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetFollowPrizeListWithDefaultParams()
    {
        $expectedParams = ['page_no' => 1, 'page_size' => 100, 'status' => 'all'];
        $expectedResponse = ['follow_prize_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'follow_prize/get_follow_prize_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->followPrize->getFollowPrizeList();
        
        $this->assertEquals($expectedResponse, $result);
    }
}
