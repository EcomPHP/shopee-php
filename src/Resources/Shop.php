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
    public function getShopInfo()
    {
        return $this->call('GET', 'shop/get_shop_info');
    }

    public function getProfile()
    {
        return $this->call('GET', 'shop/get_profile');
    }

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

    public function getWarehouseDetail()
    {
        return $this->call('GET', 'shop/get_warehouse_detail');
    }
}
