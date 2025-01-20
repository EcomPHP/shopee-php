<?php
/*
 * This file is part of shopee-php.
 *
 * (c) Jin <j@sax.vn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EcomPHP\Shopee\Resources;

use GuzzleHttp\RequestOptions;
use EcomPHP\Shopee\Resource;

class Payment extends Resource
{
    /**
     * API: v2.payment.get_escrow_detail
     * Use this API to fetch the accounting detail of order.
     *
     * @param $order_sn
     * @return array|mixed
     */
    public function getEscrowDetail($order_sn)
    {
        return $this->call('GET', 'payment/get_escrow_detail', [
            RequestOptions::QUERY => [
                'order_sn' => $order_sn,
            ],
        ]);
    }

    /**
     * API: v2.payment.set_shop_installment_status
     * Sets the staging capability of shop level.
     *
     * @param int $installment_status
     * @return array|mixed
     */
    public function setShopInstallmentStatus($installment_status)
    {
        return $this->call('POST', 'payment/set_shop_installment_status', [
            RequestOptions::JSON => [
                'installment_status' => $installment_status,
            ],
        ]);
    }

    /**
     * API: v2.payment.get_shop_installment_status
     * Get the installment state of shop.
     *
     * @return array|mixed
     */
    public function getShopInstallmentStatus()
    {
        return $this->call('GET', 'payment/get_shop_installment_status');
    }

    /**
     * API: v2.payment.get_payout_detail
     * This API is applicable for Cross Border (CB) sellers only to get the shop's payout data, such as the payout amount, currency, FX rate, the payout's associated order income and adjustment records etc.
     *
     * @param int $page_size
     * @param int $page_no
     * @param int $time_from
     * @param int $time_to
     * @return array|mixed
     */
    public function getPayoutDetail($page_size, $page_no, $time_from, $time_to)
    {
        return $this->call('GET', 'payment/get_payout_detail', [
            RequestOptions::QUERY => [
                'page_size' => $page_size,
                'page_no' => $page_no,
                'payout_time_from' => $time_from,
                'payout_time_to' => $time_to,
            ],
        ]);
    }

    /**
     * API: v2.payment.set_item_installment_status
     * Set item installment.Only for TH、TW.
     *
     * @param int[] $item_id_list
     * @param int[] $tenure_list
     * @param bool $participate_plan_ahora
     * @return array|mixed
     */
    public function setItemInstallmentStatus($item_id_list, $tenure_list, $participate_plan_ahora = false)
    {
        return $this->call('POST', 'payment/set_item_installment_status', [
            RequestOptions::JSON => [
                'item_id_list' => $item_id_list,
                'tenure_list' => $tenure_list,
                'participate_plan_ahora' => $participate_plan_ahora,
            ],
        ]);
    }

    /**
     * API: v2.payment.get_item_installment_status
     * Get item installment tenures.Only for TH、TW.*
     * @param int[] $item_id_list
     * @return array|mixed
     */
    public function getItemInstallmentStatus($item_id_list)
    {
        return $this->call('POST', 'payment/get_item_installment_status', [
            RequestOptions::JSON => [
                'item_id_list' => $item_id_list,
            ],
        ]);
    }

    /**
     * API: v2.payment.get_payment_method_list
     * Obtain payment method (no authentication required)
     *
     * @return array|mixed
     */
    public function getPaymentMethodList()
    {
        return $this->call('GET', 'payment/get_payment_method_list');
    }

    /**
     * API: v2.payment.get_wallet_transaction_list
     * Get transaction list
     *
     * @param int $page_size
     * @param int $page_no
     * @param int $create_time_from
     * @param int $create_time_to
     * @param string $wallet_type
     * @param string $transaction_type
     * @param string $money_flow
     * @param string $transaction_tab_type
     * @return array|mixed
     */
    public function getWalletTransactionList($page_size, $page_no, $create_time_from, $create_time_to, $wallet_type = null, $transaction_type = null, $money_flow = null, $transaction_tab_type = null) 
    {
        $params = [
            'page_size' => $page_size,
            'page_no' => $page_no,
            'create_time_from' => $create_time_from,
            'create_time_to' => $create_time_to,
        ];

        if ($wallet_type) {
            $params['wallet_type'] = $wallet_type;
        }

        if ($transaction_type) {
            $params['transaction_type'] = $transaction_type;
        }

        if ($money_flow) {
            $params['money_flow'] = $money_flow;
        }

        if ($transaction_tab_type) {
            $params['transaction_tab_type'] = $transaction_tab_type;
        }

        return $this->call('GET', 'payment/get_wallet_transaction_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.payment.get_escrow_list
     * Get transaction details
     *
     * @param int $release_time_from
     * @param int $release_time_to
     * @param int $page_size
     * @param int $page_no
     * @return array|mixed
     */
    public function getEscrowList($release_time_from, $release_time_to, $page_size = null, $page_no = null)
    {
        $params = [
            'release_time_from' => $release_time_from,
            'release_time_to' => $release_time_to,
        ];

        if ($page_size) {
            $params['page_size'] = $page_size;
        }

        if ($page_no) {
            $params['page_no'] = $page_no;
        }

        return $this->call('GET', 'payment/get_escrow_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.payment.get_payout_info
     */
    public function getPayoutInfo($params = [])
    {
        return $this->call('GET', 'payment/get_payout_info', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.payment.get_billing_transaction_info
     */
    public function getBillingTransactionInfo($params = [])
    {
        return $this->call('POST', 'payment/get_billing_transaction_info', [
            RequestOptions::JSON => $params,
        ]);
    }
}
