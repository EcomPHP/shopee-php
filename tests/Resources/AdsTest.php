<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Ads;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class AdsTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var Ads
     */
    private $ads;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->ads = new Ads();
        $this->ads->useApiClient($this->client);
    }
    
    public function testGetTotalBalance()
    {
        $expectedResponse = ['total_balance' => 1000.50];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'ads/get_total_balance')
            ->willReturn($expectedResponse);
        
        $result = $this->ads->getTotalBalance();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetShopToggleInfo()
    {
        $expectedResponse = ['toggle_status' => true];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'ads/get_shop_toggle_info')
            ->willReturn($expectedResponse);
        
        $result = $this->ads->getShopToggleInfo();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetRecommendedKeywordList()
    {
        $itemId = 12345;
        $inputKeyword = 'test';
        $expectedResponse = ['keyword_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'ads/get_recommended_keyword_list', 
                [
                    RequestOptions::QUERY => [
                        'item_id' => $itemId,
                        'input_keyword' => $inputKeyword
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->ads->getRecommendedKeywordList($itemId, $inputKeyword);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetRecommendedKeywordListWithoutInputKeyword()
    {
        $itemId = 12345;
        $expectedResponse = ['keyword_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'ads/get_recommended_keyword_list', 
                [
                    RequestOptions::QUERY => [
                        'item_id' => $itemId,
                        'input_keyword' => null
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->ads->getRecommendedKeywordList($itemId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetRecommendedItemList()
    {
        $expectedResponse = ['item_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'ads/get_recommended_item_list')
            ->willReturn($expectedResponse);
        
        $result = $this->ads->getRecommendedItemList();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAllCpcAdsHourlyPerformance()
    {
        $performanceDate = '2023-01-01';
        $expectedResponse = ['hourly_performance_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'ads/get_all_cpc_ads_hourly_performance', 
                [
                    RequestOptions::QUERY => [
                        'performance_date' => $performanceDate
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->ads->getAllCpcAdsHourlyPerformance($performanceDate);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetAllCpcAdsDailyPerformance()
    {
        $startDate = '2023-01-01';
        $endDate = '2023-01-07';
        $expectedResponse = ['daily_performance_list' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'ads/get_all_cpc_ads_daily_performance', 
                [
                    RequestOptions::QUERY => [
                        'start_date' => $startDate,
                        'end_date' => $endDate
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->ads->getAllCpcAdsDailyPerformance($startDate, $endDate);
        
        $this->assertEquals($expectedResponse, $result);
    }
}
