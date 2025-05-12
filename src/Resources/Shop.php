<?php
/*
 * This file is part of shopee-php.
 *
 * Copyright (c) 2023 Jin <j@sax.vn> All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EcomPHP\Shopee\Resources;

use GuzzleHttp\RequestOptions;
use EcomPHP\Shopee\Resource;

class Shop extends Resource
{
    /**
     * API: v2.shop.get_shop_info
     * Use this call to get information of shop
     */
    public function getShopInfo()
    {
        return $this->call('GET', 'shop/get_shop_info');
    }

    /**
     * API: v2.shop.get_profile
     * This API support to get information of shop.
     */
    public function getProfile()
    {
        return $this->call('GET', 'shop/get_profile');
    }

    /**
     * API: v2.shop.update_profile
     * This API support to let sellers to update the shop name, shop logo, and shop description.
     */
    public function updateProfile($shop_name, $shop_logo, $description)
    {
        return $this->call('POST', 'shop/update_profile', [
            RequestOptions::JSON => [
                'shop_name' => $shop_name,
                'shop_logo' => $shop_logo,
                'description' => $description,
            ]
        ]);
    }

    /**
     * API: v2.shop.get_warehouse_detail
     * For given shop id and region, return warehouse info including warehouse id, address id and location id
     */
    public function getWarehouseDetail()
    {
        return $this->call('GET', 'shop/get_warehouse_detail');
    }

    /**
     * API: v2.shop.get_shop_notification
     * get Seller Center notification, the permission is controlled by App type
     */
    public function getShopNotification($params = [])
    {
        return $this->call('GET', 'shop/get_shop_notification', [
            RequestOptions::QUERY => $params
        ]);
    }

    public function getAuthorizedResellerBrand($params = [])
    {
        $params = array_merge([
            'page_no' => 1,
            'page_size' => 10,
        ], $params);

        return $this->call('GET', 'shop/get_authorised_reseller_brand', [
            RequestOptions::QUERY => $params
        ]);
    }
}
