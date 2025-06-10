<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\TopPicks;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class TopPicksTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;

    /**
     * @var TopPicks
     */
    private $topPicks;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->topPicks = new TopPicks();
        $this->topPicks->useApiClient($this->client);
    }

    public function testGetTopPicksList()
    {
        $expectedResponse = ['top_picks_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'top_picks/get_top_picks_list'
            )
            ->willReturn($expectedResponse);

        $result = $this->topPicks->getTopPicksList();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testAddTopPicks()
    {
        $name = 'Test Top Picks';
        $itemIdList = [1, 2, 3];
        $isActivated = true;
        $expectedResponse = ['top_picks_id' => 123];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'top_picks/add_top_picks', 
                [
                    RequestOptions::JSON => [
                        'name' => $name,
                        'item_id_list' => $itemIdList,
                        'is_activated' => $isActivated,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->topPicks->addTopPicks($name, $itemIdList, $isActivated);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testAddTopPicksWithDefaultActivation()
    {
        $name = 'Test Top Picks';
        $itemIdList = [1, 2, 3];
        $expectedResponse = ['top_picks_id' => 123];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'top_picks/add_top_picks', 
                [
                    RequestOptions::JSON => [
                        'name' => $name,
                        'item_id_list' => $itemIdList,
                        'is_activated' => true,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->topPicks->addTopPicks($name, $itemIdList);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUpdateTopPicks()
    {
        $topPicksId = 123;
        $name = 'Updated Top Picks';
        $itemIdList = [4, 5, 6];
        $isActivated = false;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'top_picks/update_top_picks', 
                [
                    RequestOptions::JSON => [
                        'top_picks_id' => $topPicksId,
                        'name' => $name,
                        'item_id_list' => $itemIdList,
                        'is_activated' => $isActivated,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->topPicks->updateTopPicks($topPicksId, $name, $itemIdList, $isActivated);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUpdateTopPicksWithPartialData()
    {
        $topPicksId = 123;
        $name = 'Updated Top Picks';
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'top_picks/update_top_picks', 
                [
                    RequestOptions::JSON => [
                        'top_picks_id' => $topPicksId,
                        'name' => $name,
                        'item_id_list' => null,
                        'is_activated' => null,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->topPicks->updateTopPicks($topPicksId, $name);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDeleteTopPicks()
    {
        $topPicksId = 123;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'top_picks/delete_top_picks', 
                [
                    RequestOptions::JSON => [
                        'top_picks_id' => $topPicksId,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->topPicks->deleteTopPicks($topPicksId);

        $this->assertEquals($expectedResponse, $result);
    }
}
