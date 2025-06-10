<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Payment;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;

    /**
     * @var Payment
     */
    private $payment;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->payment = new Payment();
        $this->payment->useApiClient($this->client);
    }

    public function testGetEscrowDetail()
    {
        $orderSn = '123456789';
        $expectedResponse = ['escrow_detail' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'payment/get_escrow_detail', 
                [
                    RequestOptions::QUERY => [
                        'order_sn' => $orderSn
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->payment->getEscrowDetail($orderSn);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testSetShopInstallmentStatus()
    {
        $installmentStatus = 1;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'payment/set_shop_installment_status', 
                [
                    RequestOptions::JSON => [
                        'installment_status' => $installmentStatus
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->payment->setShopInstallmentStatus($installmentStatus);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetShopInstallmentStatus()
    {
        $expectedResponse = ['installment_status' => 1];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'payment/get_shop_installment_status')
            ->willReturn($expectedResponse);

        $result = $this->payment->getShopInstallmentStatus();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetPayoutDetail()
    {
        $pageSize = 20;
        $pageNo = 1;
        $timeFrom = 1609459200; // 2021-01-01 00:00:00
        $timeTo = 1612137600; // 2021-02-01 00:00:00
        $expectedResponse = ['payout_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'payment/get_payout_detail', 
                [
                    RequestOptions::QUERY => [
                        'page_size' => $pageSize,
                        'page_no' => $pageNo,
                        'payout_time_from' => $timeFrom,
                        'payout_time_to' => $timeTo
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->payment->getPayoutDetail($pageSize, $pageNo, $timeFrom, $timeTo);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testSetItemInstallmentStatus()
    {
        $itemIdList = [12345, 67890];
        $tenureList = [3, 6, 12];
        $participatePlanAhora = true;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'payment/set_item_installment_status', 
                [
                    RequestOptions::JSON => [
                        'item_id_list' => $itemIdList,
                        'tenure_list' => $tenureList,
                        'participate_plan_ahora' => $participatePlanAhora
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->payment->setItemInstallmentStatus($itemIdList, $tenureList, $participatePlanAhora);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testSetItemInstallmentStatusWithDefaultParticipate()
    {
        $itemIdList = [12345, 67890];
        $tenureList = [3, 6, 12];
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'payment/set_item_installment_status', 
                [
                    RequestOptions::JSON => [
                        'item_id_list' => $itemIdList,
                        'tenure_list' => $tenureList,
                        'participate_plan_ahora' => false
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->payment->setItemInstallmentStatus($itemIdList, $tenureList);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetItemInstallmentStatus()
    {
        $itemIdList = [12345, 67890];
        $expectedResponse = ['item_installment_status_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'payment/get_item_installment_status', 
                [
                    RequestOptions::JSON => [
                        'item_id_list' => $itemIdList
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->payment->getItemInstallmentStatus($itemIdList);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetPaymentMethodList()
    {
        $expectedResponse = ['payment_method_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'payment/get_payment_method_list')
            ->willReturn($expectedResponse);

        $result = $this->payment->getPaymentMethodList();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetWalletTransactionList()
    {
        $pageSize = 20;
        $pageNo = 1;
        $createTimeFrom = 1609459200; // 2021-01-01 00:00:00
        $createTimeTo = 1612137600; // 2021-02-01 00:00:00
        $walletType = 'MAIN';
        $transactionType = 'ESCROW';
        $moneyFlow = 'IN';
        $transactionTabType = 'ALL';
        $expectedResponse = ['transaction_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'payment/get_wallet_transaction_list', 
                [
                    RequestOptions::QUERY => [
                        'page_size' => $pageSize,
                        'page_no' => $pageNo,
                        'create_time_from' => $createTimeFrom,
                        'create_time_to' => $createTimeTo,
                        'wallet_type' => $walletType,
                        'transaction_type' => $transactionType,
                        'money_flow' => $moneyFlow,
                        'transaction_tab_type' => $transactionTabType
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->payment->getWalletTransactionList(
            $pageSize, 
            $pageNo, 
            $createTimeFrom, 
            $createTimeTo, 
            $walletType, 
            $transactionType, 
            $moneyFlow, 
            $transactionTabType
        );

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetEscrowList()
    {
        $releaseTimeFrom = 1609459200; // 2021-01-01 00:00:00
        $releaseTimeTo = 1612137600; // 2021-02-01 00:00:00
        $pageSize = 20;
        $pageNo = 1;
        $expectedResponse = ['escrow_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'payment/get_escrow_list', 
                [
                    RequestOptions::QUERY => [
                        'release_time_from' => $releaseTimeFrom,
                        'release_time_to' => $releaseTimeTo,
                        'page_size' => $pageSize,
                        'page_no' => $pageNo
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->payment->getEscrowList($releaseTimeFrom, $releaseTimeTo, $pageSize, $pageNo);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetPayoutInfo()
    {
        $params = ['payout_id' => 12345];
        $expectedResponse = ['payout_info' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'payment/get_payout_info', 
                [
                    RequestOptions::QUERY => $params
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->payment->getPayoutInfo($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetBillingTransactionInfo()
    {
        $params = ['transaction_id' => 12345];
        $expectedResponse = ['transaction_info' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'payment/get_billing_transaction_info', 
                [
                    RequestOptions::JSON => $params
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->payment->getBillingTransactionInfo($params);

        $this->assertEquals($expectedResponse, $result);
    }
}
