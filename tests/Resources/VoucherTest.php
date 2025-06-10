<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Voucher;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class VoucherTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;

    /**
     * @var Voucher
     */
    private $voucher;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->voucher = new Voucher();
        $this->voucher->useApiClient($this->client);
    }

    public function testAddVoucher()
    {
        $data = [
            'voucher_name' => 'Test Voucher',
            'start_time' => 1609459200,
            'end_time' => 1612137600,
            'discount_type' => 'PERCENTAGE',
            'discount_value' => 10,
            'min_spend' => 100,
        ];
        $expectedResponse = ['voucher_id' => 123];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'voucher/add_voucher', 
                [
                    RequestOptions::JSON => $data
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->voucher->addVoucher($data);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDeleteVoucher()
    {
        $voucherId = 123;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'voucher/delete_voucher', 
                [
                    RequestOptions::JSON => [
                        'voucher_id' => $voucherId,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->voucher->deleteVoucher($voucherId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testEndVoucher()
    {
        $voucherId = 123;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'voucher/end_voucher', 
                [
                    RequestOptions::JSON => [
                        'voucher_id' => $voucherId,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->voucher->endVoucher($voucherId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetVoucher()
    {
        $voucherId = 123;
        $expectedResponse = ['voucher' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'voucher/get_voucher', 
                [
                    RequestOptions::JSON => [
                        'voucher_id' => $voucherId,
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->voucher->getVoucher($voucherId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetVoucherList()
    {
        $params = ['status' => 'upcoming', 'page_no' => 2];
        $expectedParams = [
            'status' => 'upcoming',
            'page_no' => 2,
            'page_size' => 100,
        ];
        $expectedResponse = ['vouchers' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'voucher/get_voucher_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->voucher->getVoucherList($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUpdateVoucher()
    {
        $voucherId = 123;
        $data = [
            'voucher_name' => 'Updated Voucher',
            'start_time' => 1609459200,
            'end_time' => 1612137600,
        ];
        $expectedData = array_merge($data, ['voucher_id' => $voucherId]);
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'voucher/update_voucher', 
                [
                    RequestOptions::JSON => $expectedData
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->voucher->updateVoucher($voucherId, $data);

        $this->assertEquals($expectedResponse, $result);
    }
}
