<?php
/*
 * This file is part of shopee-php.
 *
 * (c) Jin <j@sax.vn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NVuln\Shopee\Resources;

use GuzzleHttp\RequestOptions;
use NVuln\Shopee\Resource;

class Order extends Resource
{
    protected $prefix = 'order';

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

        return $this->call('GET', 'get_order_list', [
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
        return $this->call('GET', 'get_shipment_list', [
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

        return $this->call('GET', 'get_order_detail', [
            RequestOptions::QUERY => $params,
        ]);
    }
}
