<?php
/*
 * This file is part of shopee-php.
 *
 * Copyright (c) 2024 Jin <j@sax.vn> All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EcomPHP\Shopee\Resources;

use EcomPHP\Shopee\Resource;
use GuzzleHttp\RequestOptions;

class FirstMile extends Resource
{
    /**
     * API: v2.first_mile.get_unbind_order_list
     * Use this api to get unbind order list. It will only return orders unbound to first-mile that were created within the past 6 months. 
     */
    public function getUnbindOrderList($params = [])
    {
        return $this->call('GET', 'first_mile/get_unbind_order_list', [
            RequestOptions::QUERY => array_merge([
                'page_size' => 50,
                'response_optional_fields' => 'logistics_status,package_number'
            ], $params)
        ]);
    }

    /**
     * API: v2.first_mile.get_detail
     * Use this api to get first mile detail.
     */
    public function getDetail($first_mile_tracking_number, $cursor = null)
    {
        $params = [
            'first_mile_tracking_number' => $first_mile_tracking_number,
        ];

        if ($cursor) {
            $params['cursor'] = $cursor;
        }

        return $this->call('GET', 'first_mile/get_detail', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.first_mile.generate_first_mile_tracking_number
     * Use this api to generate first mile tracking number.
     */
    public function generateFirstMileTrackingNumber($declare_date, $quantity = 1)
    {
        return $this->call('POST', 'first_mile/generate_first_mile_tracking_number', [
            RequestOptions::JSON => [
                'declare_date' => $declare_date,
                'quantity' => $quantity,
            ]
        ]);
    }

    /**
     * API: v2.first_mile.bind_first_mile_tracking_number
     * Use this api to bind first mile tracking number.
     */
    public function bindFirstMileTrackingNumber($data)
    {
        return $this->call('POST', 'first_mile/bind_first_mile_tracking_number', [
            RequestOptions::JSON => $data
        ]);
    }

    /**
     * API: v2.first_mile.unbind_first_mile_tracking_number
     * Use this api to unbind first mile.
     */
    public function unbindFirstMileTrackingNumber($first_mile_tracking_number, $order_list)
    {
        return $this->call('POST', 'first_mile/unbind_first_mile_tracking_number', [
            RequestOptions::JSON => [
                'first_mile_tracking_number' => $first_mile_tracking_number,
                'order_list' => $order_list,
            ]
        ]);
    }

    /**
     * API: v2.first_mile.get_tracking_number_list
     * Use this api to get first mile tracking number list.
     */
    public function getTrackingNumberList($params = [])
    {
        return $this->call('GET', 'first_mile/get_tracking_number_list', [
            RequestOptions::QUERY => array_merge([
                'from_date' => date('Y-m-d', strtotime('-7 days')),
                'to_date' => date('Y-m-d'),
                'page_size' => 50,
            ], $params)
        ]);
    }

    /**
     * API: v2.first_mile.get_waybill
     * Use this api to get first mile waybill file.
     */
    public function getWaybill($first_mile_tracking_number_list)
    {
        return $this->call('POST', 'first_mile/get_waybill', [
            RequestOptions::JSON => [
                'first_mile_tracking_number_list' => $first_mile_tracking_number_list,
            ]
        ]);
    }

    /**
     * API: v2.first_mile.get_channel_list
     * Use this api to get first mile channel list.
     */
    public function getChannelList($region = null)
    {
        return $this->call('GET', 'first_mile/get_channel_list', [
            RequestOptions::QUERY => [
                'region' => $region,
            ]
        ]);
    }
}
