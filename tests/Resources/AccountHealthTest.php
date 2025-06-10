<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\AccountHealth;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class AccountHealthTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    /**
     * @var AccountHealth
     */
    private $accountHealth;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->accountHealth = new AccountHealth();
        $this->accountHealth->useApiClient($this->client);
    }
    
    public function testGetShopPerformance()
    {
        $expectedResponse = ['shop_performance' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'account_health/get_shop_performance')
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getShopPerformance();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testShopPenalty()
    {
        $expectedResponse = ['shop_penalty' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'account_health/shop_penalty')
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->shopPenalty();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetMetricSourceDetail()
    {
        $metricId = 12345;
        $pageNo = 2;
        $pageSize = 50;
        $expectedResponse = ['metric_source_detail' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_metric_source_detail', 
                [
                    RequestOptions::QUERY => [
                        'metric_id' => $metricId,
                        'page_no' => $pageNo,
                        'page_size' => $pageSize
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getMetricSourceDetail($metricId, $pageNo, $pageSize);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetMetricSourceDetailWithDefaultPagination()
    {
        $metricId = 12345;
        $expectedResponse = ['metric_source_detail' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_metric_source_detail', 
                [
                    RequestOptions::QUERY => [
                        'metric_id' => $metricId,
                        'page_no' => 1,
                        'page_size' => 100
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getMetricSourceDetail($metricId);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetPenaltyPointHistory()
    {
        $violationType = 'LATE_SHIPMENT';
        $pageNo = 2;
        $pageSize = 50;
        $expectedResponse = ['penalty_point_history' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_penalty_point_history', 
                [
                    RequestOptions::QUERY => [
                        'violation_type' => $violationType,
                        'page_no' => $pageNo,
                        'page_size' => $pageSize
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getPenaltyPointHistory($violationType, $pageNo, $pageSize);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetPenaltyPointHistoryWithoutViolationType()
    {
        $pageNo = 2;
        $pageSize = 50;
        $expectedResponse = ['penalty_point_history' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_penalty_point_history', 
                [
                    RequestOptions::QUERY => [
                        'page_no' => $pageNo,
                        'page_size' => $pageSize
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getPenaltyPointHistory(null, $pageNo, $pageSize);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetPenaltyPointHistoryWithDefaultPagination()
    {
        $violationType = 'LATE_SHIPMENT';
        $expectedResponse = ['penalty_point_history' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_penalty_point_history', 
                [
                    RequestOptions::QUERY => [
                        'violation_type' => $violationType,
                        'page_no' => 1,
                        'page_size' => 100
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getPenaltyPointHistory($violationType);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetPunishmentHistory()
    {
        $punishmentStatus = 'ACTIVE';
        $pageNo = 2;
        $pageSize = 50;
        $expectedResponse = ['punishment_history' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_punishment_history', 
                [
                    RequestOptions::QUERY => [
                        'punishment_status' => $punishmentStatus,
                        'page_no' => $pageNo,
                        'page_size' => $pageSize
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getPunishmentHistory($punishmentStatus, $pageNo, $pageSize);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetPunishmentHistoryWithDefaultPagination()
    {
        $punishmentStatus = 'ACTIVE';
        $expectedResponse = ['punishment_history' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_punishment_history', 
                [
                    RequestOptions::QUERY => [
                        'punishment_status' => $punishmentStatus,
                        'page_no' => 1,
                        'page_size' => 100
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getPunishmentHistory($punishmentStatus);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetListingsWithIssues()
    {
        $pageNo = 2;
        $pageSize = 50;
        $expectedResponse = ['listings_with_issues' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_listings_with_issues', 
                [
                    RequestOptions::QUERY => [
                        'page_no' => $pageNo,
                        'page_size' => $pageSize
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getListingsWithIssues($pageNo, $pageSize);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetListingsWithIssuesWithDefaultPagination()
    {
        $expectedResponse = ['listings_with_issues' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_listings_with_issues', 
                [
                    RequestOptions::QUERY => [
                        'page_no' => 1,
                        'page_size' => 100
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getListingsWithIssues();
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetLateOrders()
    {
        $pageNo = 2;
        $pageSize = 50;
        $expectedResponse = ['late_orders' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_late_orders', 
                [
                    RequestOptions::QUERY => [
                        'page_no' => $pageNo,
                        'page_size' => $pageSize
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getLateOrders($pageNo, $pageSize);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetLateOrdersWithDefaultPagination()
    {
        $expectedResponse = ['late_orders' => []];
        
        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'account_health/get_late_orders', 
                [
                    RequestOptions::QUERY => [
                        'page_no' => 1,
                        'page_size' => 100
                    ]
                ]
            )
            ->willReturn($expectedResponse);
        
        $result = $this->accountHealth->getLateOrders();
        
        $this->assertEquals($expectedResponse, $result);
    }
}
