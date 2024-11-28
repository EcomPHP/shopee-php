<?php
/*
 * This file is part of shopee-php.
 *
 * Copyright (c) 2024 Jin <j@sax.vn> All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jekka\Shopee\Resources;

use Jekka\Shopee\Resource;
use GuzzleHttp\RequestOptions;

class ShopFlashSale extends Resource
{
    public function getTimeSlotId($start_time, $end_time)
    {
        return $this->call('GET', 'shop_flash_sale/get_time_slot_id', [
            RequestOptions::QUERY => [
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]
        ]);
    }

    public function createShopFlashSale($timeslot_id)
    {
        return $this->call('POST', 'shop_flash_sale/create_shop_flash_sale', [
            RequestOptions::JSON => [
                'timeslot_id' => intval($timeslot_id),
            ]
        ]);
    }

    public function getItemCriteria()
    {
        return $this->call('GET', 'shop_flash_sale/get_item_criteria');
    }

    public function addShopFlashSaleItems($flash_sale_id, $items)
    {
        return $this->call('POST', 'shop_flash_sale/add_shop_flash_sale_items', [
            RequestOptions::JSON => [
                'flash_sale_id' => intval($flash_sale_id),
                'items' => $items,
            ]
        ]);
    }

    public function getShopFlashSaleList($params = [])
    {
        $params = array_merge([
            'type' => 0, // all state
            'offset' => 0,
            'limit' => 10,
        ], $params);

        return $this->call('GET', 'shop_flash_sale/get_shop_flash_sale_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    public function getShopFlashSale($flash_sale_id)
    {
        return $this->call('GET', 'shop_flash_sale/get_shop_flash_sale', [
            RequestOptions::QUERY => [
                'flash_sale_id' => intval($flash_sale_id),
            ]
        ]);
    }

    public function getShopFlashSaleItems($flash_sale_id, $offset = 0, $limit = 10)
    {
        return $this->call('GET', 'shop_flash_sale/get_shop_flash_sale_items', [
            RequestOptions::QUERY => [
                'offset' => $offset,
                'limit' => $limit,
                'flash_sale_id' => intval($flash_sale_id),
            ]
        ]);
    }

    public function updateShopFlashSale($flash_sale_id, $status)
    {
        return $this->call('POST', 'shop_flash_sale/update_shop_flash_sale', [
            RequestOptions::JSON => [
                'status' => $status,
                'flash_sale_id' => intval($flash_sale_id),
            ]
        ]);
    }

    public function updateShopFlashSaleItems($flash_sale_id, $items)
    {
        return $this->call('POST', 'shop_flash_sale/update_shop_flash_sale_items', [
            RequestOptions::JSON => [
                'flash_sale_id' => intval($flash_sale_id),
                'items' => $items,
            ]
        ]);
    }

    public function deleteShopFlashSale($flash_sale_id)
    {
        return $this->call('POST', 'shop_flash_sale/delete_shop_flash_sale', [
            RequestOptions::JSON => [
                'flash_sale_id' => intval($flash_sale_id),
            ]
        ]);
    }

    public function deleteShopFlashSaleItems($flash_sale_id, $item_ids)
    {
        return $this->call('POST', 'shop_flash_sale/delete_shop_flash_sale_items', [
            RequestOptions::JSON => [
                'flash_sale_id' => intval($flash_sale_id),
                'item_ids' => $item_ids,
            ]
        ]);
    }
}
