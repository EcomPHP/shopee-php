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

class ShopFlashSale extends Resource
{
    /**
     * API: v2.shop_flash_sale.get_time_slot_id
     */
    public function getTimeSlotId($start_time, $end_time)
    {
        return $this->call('GET', 'shop_flash_sale/get_time_slot_id', [
            RequestOptions::QUERY => [
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]
        ]);
    }

    /**
     * API: v2.shop_flash_sale.create_shop_flash_sale
     */
    public function createShopFlashSale($timeslot_id)
    {
        return $this->call('POST', 'shop_flash_sale/create_shop_flash_sale', [
            RequestOptions::JSON => [
                'timeslot_id' => intval($timeslot_id),
            ]
        ]);
    }

    /**
     * API: v2.shop_flash_sale.get_item_criteria
     */
    public function getItemCriteria()
    {
        return $this->call('GET', 'shop_flash_sale/get_item_criteria');
    }

    /**
     * API: v2.shop_flash_sale.add_shop_flash_sale_items
     */
    public function addShopFlashSaleItems($flash_sale_id, $items)
    {
        return $this->call('POST', 'shop_flash_sale/add_shop_flash_sale_items', [
            RequestOptions::JSON => [
                'flash_sale_id' => intval($flash_sale_id),
                'items' => $items,
            ]
        ]);
    }

    /**
     * API: v2.shop_flash_sale.get_shop_flash_sale_list
     */
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

    /**
     * API: v2.shop_flash_sale.get_shop_flash_sale
     */
    public function getShopFlashSale($flash_sale_id)
    {
        return $this->call('GET', 'shop_flash_sale/get_shop_flash_sale', [
            RequestOptions::QUERY => [
                'flash_sale_id' => intval($flash_sale_id),
            ]
        ]);
    }

    /**
     * API: v2.shop_flash_sale.get_shop_flash_sale_items
     */
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

    /**
     * API: v2.shop_flash_sale.update_shop_flash_sale
     */
    public function updateShopFlashSale($flash_sale_id, $status)
    {
        return $this->call('POST', 'shop_flash_sale/update_shop_flash_sale', [
            RequestOptions::JSON => [
                'status' => $status,
                'flash_sale_id' => intval($flash_sale_id),
            ]
        ]);
    }

    /**
     * API: v2.shop_flash_sale.update_shop_flash_sale_items
     */
    public function updateShopFlashSaleItems($flash_sale_id, $items)
    {
        return $this->call('POST', 'shop_flash_sale/update_shop_flash_sale_items', [
            RequestOptions::JSON => [
                'flash_sale_id' => intval($flash_sale_id),
                'items' => $items,
            ]
        ]);
    }

    /**
     * API: v2.shop_flash_sale.delete_shop_flash_sale
     */
    public function deleteShopFlashSale($flash_sale_id)
    {
        return $this->call('POST', 'shop_flash_sale/delete_shop_flash_sale', [
            RequestOptions::JSON => [
                'flash_sale_id' => intval($flash_sale_id),
            ]
        ]);
    }

    /**
     * API: v2.shop_flash_sale.delete_shop_flash_sale_items
     */
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
