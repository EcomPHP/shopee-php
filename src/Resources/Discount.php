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

class Discount extends Resource
{
    /**
     * API: v2.discount.add_discount
     */
    public function addDiscount($data)
    {
        return $this->call('POST', 'discount/add_discount', [
            RequestOptions::JSON => $data
        ]);
    }

    /**
     * API: v2.discount.add_discount_item
     */
    public function addDiscountItem($discount_id, $item_list)
    {
        return $this->call('POST', 'discount/add_discount_item', [
            RequestOptions::JSON => [
                'discount_id' => $discount_id,
                'item_list' => $item_list,
            ]
        ]);
    }

    /**
     * API: v2.discount.delete_discount
     */
    public function deleteDiscount($discount_id)
    {
        return $this->call('POST', 'discount/delete_discount', [
            RequestOptions::JSON => [
                'discount_id' => $discount_id,
            ]
        ]);
    }

    /**
     * API: v2.discount.delete_discount_item
     */
    public function deleteDiscountItem($discount_id, $item_id, $model_id = null)
    {
        return $this->call('POST', 'discount/delete_discount_item', [
            RequestOptions::JSON => [
                'discount_id' => $discount_id,
                'item_id' => $item_id,
                'model_id' => $model_id,
            ]
        ]);
    }

    /**
     * API: v2.discount.get_discount
     */
    public function getDiscount($discount_id, $params = [])
    {
        return $this->call('GET', 'discount/get_discount', [
            RequestOptions::QUERY => array_merge([
                'page_no' => 1,
                'page_size' => 50,
            ], $params, [
                'discount_id' => $discount_id,
            ])
        ]);
    }

    /**
     * API: v2.discount.get_discount_list
     */
    public function getDiscountList($params = [])
    {
        return $this->call('GET', 'discount/get_discount_list', [
            RequestOptions::QUERY => array_merge([
                'discount_status' => 'all',
                'page_no' => 1,
                'page_size' => 50,
            ], $params)
        ]);
    }

    /**
     * API: v2.discount.update_discount
     */
    public function updateDiscount($discount_id, $data)
    {
        return $this->call('POST', 'discount/update_discount', [
            RequestOptions::JSON => array_merge($data, [
                'discount_id' => $discount_id,
            ])
        ]);
    }

    /**
     * API: v2.discount.update_discount_item
     */
    public function updateDiscountItem($discount_id, $item_list)
    {
        return $this->call('POST', 'discount/update_discount_item', [
            RequestOptions::JSON => [
                'discount_id' => $discount_id,
                'item_list' => $item_list,
            ]
        ]);
    }

    /**
     * API: v2.discount.end_discount
     */
    public function endDiscount($discount_id)
    {
        return $this->call('POST', 'discount/end_discount', [
            RequestOptions::JSON => [
                'discount_id' => $discount_id,
            ]
        ]);
    }
}
