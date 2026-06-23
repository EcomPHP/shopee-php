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

class ShopCategory extends Resource
{
    /**
     * API: v2.shop_category.add_shop_category
     * Use this call to add a new shop collecion
     */
    public function addShopCategory($name, $sort_weight = null)
    {
        return $this->call('POST', 'shop_category/add_shop_category', [
            RequestOptions::JSON => [
                'name' => $name,
                'sort_weight' => $sort_weight,
            ]
        ]);
    }

    /**
     * API: v2.shop_category.get_shop_category_list
     * Use this call to get list of shop categories
     */
    public function getShopCategoryList($params = [])
    {
        return $this->call('GET', 'shop_category/get_shop_category_list', [
            RequestOptions::QUERY => array_merge([
                'page_no' => 1,
                'page_size' => 100,
            ], $params)
        ]);
    }

    /**
     * API: v2.shop_category.delete_shop_category
     * Use this call to delete a existing shop collecion
     */
    public function deleteShopCategory($shop_category_id)
    {
        return $this->call('POST', 'shop_category/delete_shop_category', [
            RequestOptions::JSON => [
                'shop_category_id' => $shop_category_id,
            ]
        ]);
    }

    /**
     * API: v2.shop_category.update_shop_category
     * Use this call to update a existing collecion
     */
    public function updateShopCategory($shop_category_id, $name = null, $sort_weight = null, $status = 'NORMAL')
    {
        return $this->call('POST', 'shop_category/update_shop_category', [
            RequestOptions::JSON => [
                'shop_category_id' => $shop_category_id,
                'name' => $name,
                'sort_weight' => $sort_weight,
                'status' => $status,
            ]
        ]);
    }

    /**
     * API: v2.shop_category.add_item_list
     * Use this call to add items list to certain shop_category
     */
    public function addItemList($shop_category_id, $item_id_list)
    {
        return $this->call('POST', 'shop_category/add_item_list', [
            RequestOptions::JSON => [
                'shop_category_id' => $shop_category_id,
                'item_list' => $item_id_list,
            ]
        ]);
    }

    /**
     * API: v2.shop_category.get_item_list
     * Use this call to get items list of certain shop_category
     */
    public function getItemList($shop_category_id, $params = [])
    {
        return $this->call('GET', 'shop_category/get_item_list', [
            RequestOptions::QUERY => array_merge([
                'shop_category_id' => $shop_category_id,
                'page_no' => 1,
                'page_size' => 100,
            ], $params)
        ]);
    }

    /**
     * API: v2.shop_category.delete_item_list
     * Use this api to delete items from shop category
     */
    public function deleteItemList($shop_category_id, $item_id_list)
    {
        return $this->call('POST', 'shop_category/delete_item_list', [
            RequestOptions::JSON => [
                'shop_category_id' => $shop_category_id,
                'item_list' => $item_id_list,
            ]
        ]);
    }
}
