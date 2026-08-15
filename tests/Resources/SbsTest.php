<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Sbs;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class SbsTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;

    /**
     * @var Sbs
     */
    private $sbs;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->sbs = new Sbs();
        $this->sbs->useApiClient($this->client);
    }

    public function testGetFulfillmentMappingInventoryList()
    {
        $params = [
            'mtsku_ids' => ['BUNDLE_001', 'PARENT_001'],
            'page_size' => 50,
            'next_cursor' => 'cursor_1',
        ];
        $expectedResponse = ['list' => [], 'total' => 0];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                'sbs/get_fulfillment_mapping_inventory_list',
                [
                    RequestOptions::QUERY => [
                        'mtsku_ids' => 'BUNDLE_001,PARENT_001',
                        'page_size' => 50,
                        'next_cursor' => 'cursor_1',
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->sbs->getFulfillmentMappingInventoryList($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetFulfillmentMappingInventoryListWithDefaultParams()
    {
        $expectedResponse = ['list' => [], 'total' => 0];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET',
                'sbs/get_fulfillment_mapping_inventory_list',
                [
                    RequestOptions::QUERY => [
                        'page_size' => 100,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->sbs->getFulfillmentMappingInventoryList();

        $this->assertEquals($expectedResponse, $result);
    }
}