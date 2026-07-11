<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Principal;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class PrincipalTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;

    /**
     * @var Principal
     */
    private $principal;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->principal = new Principal();
        $this->principal->useApiClient($this->client);
    }

    public function testGetShopSalesPerformanceDetail()
    {
        $params = ['time_granularity' => 'DAY'];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_shop_sales_performance_detail', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getShopSalesPerformanceDetail($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetPrincipalSalesPerformanceDetail()
    {
        $params = ['region' => 'SG'];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_principal_sales_performance_detail', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getPrincipalSalesPerformanceDetail($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopAffiliatePerformance()
    {
        $params = ['time_granularity' => 'DAY'];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_shop_affiliate_performance', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getShopAffiliatePerformance($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetPrincipalAffiliatePerformance()
    {
        $params = ['region' => 'MY'];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_principal_affiliate_performance', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getPrincipalAffiliatePerformance($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetContentAffiliatePerformance()
    {
        $params = ['content_type' => 'VIDEO'];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_content_affiliate_performance', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getContentAffiliatePerformance($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopLivestreamPerformance()
    {
        $params = ['time_granularity' => 'DAY'];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_shop_livestream_performance', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getShopLivestreamPerformance($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetPrincipalLivestreamPerformance()
    {
        $params = ['region' => 'PH'];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_principal_livestream_performance', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getPrincipalLivestreamPerformance($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetSessionLivestreamPerformance()
    {
        $params = ['session_id' => 1001];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_session_livestream_performance', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getSessionLivestreamPerformance($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopVideoPerformance()
    {
        $params = ['time_granularity' => 'DAY'];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_shop_video_performance', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getShopVideoPerformance($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetPrincipalVideoPerformance()
    {
        $params = ['region' => 'TW'];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_principal_video_performance', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getPrincipalVideoPerformance($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetClipVideoPerformance()
    {
        $params = ['clip_id' => 2002];
        $expectedResponse = ['list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'principal/get_clip_video_performance', [
                RequestOptions::QUERY => $params,
            ])
            ->willReturn($expectedResponse);

        $result = $this->principal->getClipVideoPerformance($params);

        $this->assertEquals($expectedResponse, $result);
    }
}