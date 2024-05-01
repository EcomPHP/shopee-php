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

class Merchant extends Resource
{
    /**
     * API: v2.merchant.get_merchant_info
     * Use this call to get information of merchant
     */
    public function getMerchantInfo()
    {
        return $this->call('GET', 'merchant/get_merchant_info');
    }

    /**
     * API: v2.merchant.get_shop_list_by_merchant
     * Use this call to get shop_list bound to merchant_id.
     */
    public function getShopListByMerchant($params = [])
    {
        return $this->call('GET', 'merchant/get_shop_list_by_merchant', [
            RequestOptions::QUERY => array_merge([
                'page_no' => 1,
                'page_size' => 100,
            ], $params),
        ]);
    }

    /**
     * API: v2.merchant.get_merchant_warehouse_location_list
     * get merchant warehouse location list
     */
    public function getMerchantWarehouseLocationList()
    {
        return $this->call('GET', 'merchant/get_merchant_warehouse_location_list');
    }

    /**
     * API: v2.merchant.get_merchant_warehouse_list
     * Get merchant warehouse with page
     */
    public function getMerchantWarehouseList($warehouse_type, $cursor)
    {
        return $this->call('POST', 'merchant/get_merchant_warehouse_list', [
            RequestOptions::JSON => [
                'cursor' => array_merge([
                    'page_size' => 10,
                ], $cursor),
                'warehouse_type' => $warehouse_type,
            ],
        ]);
    }

    /**
     * API: v2.merchant.get_warehouse_eligible_shop_list
     * Get eligible shop list by warehouse id
     */
    public function getWarehouseEligibleShopList($warehouse_id, $warehouse_type, $cursor)
    {
        return $this->call('POST', 'merchant/get_warehouse_eligible_shop_list', [
            RequestOptions::JSON => [
                'cursor' => array_merge([
                    'page_size' => 10,
                ], $cursor),
                'warehouse_id' => $warehouse_id,
                'warehouse_type' => $warehouse_type,
            ],
        ]);
    }
}
