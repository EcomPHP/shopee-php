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

class Order extends Resource
{
    /**
     * API: v2.order.get_order_list
     * Use this api to search orders.
     *
     * @param  array  $params
     * @return array|mixed
     */
    public function getOrderList($params = [])
    {
        $params = array_merge([
            'time_range_field' => 'create_time',
            'time_from' => strtotime('-7 days'),
            'time_to' => time(),
            'page_size' => 20,
        ], $params);

        return $this->call('GET', 'order/get_order_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.order.get_shipment_list
     * Use this api to get order list which order_status is READY_TO_SHIP.
     *
     * @param  array  $params
     * @return array|mixed
     */
    public function getShipmentList($params = [])
    {
        $params['page_size'] = 20;
        return $this->call('GET', 'order/get_shipment_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.order.get_order_detail
     * Use this api to get order detail.
     *
     * @param $ids
     * @param  array  $params
     * @return array|mixed
     */
    public function getOrderDetail($ids, $params = [])
    {
        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }

        $params['order_sn_list'] = $ids;

        return $this->call('GET', 'order/get_order_detail', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.order.get_buyer_invoice_info
     * Use this api to get buyer invoice info.
     *
     * @param $order_sn_list
     * @return array|mixed
     */
    public function getBuyerInvoiceInfo($order_sn_list)
    {
        if (is_string($order_sn_list)) {
            $order_sn_list = [$order_sn_list];
        }

        $params = [
            'queries' => array_map(function ($order_sn) {
                return [
                    'order_sn' => $order_sn,
                ];
            }, $order_sn_list)
        ];

        return $this->call('POST', 'order/get_buyer_invoice_info', [
            RequestOptions::JSON => $params,
        ]);
    }
}
