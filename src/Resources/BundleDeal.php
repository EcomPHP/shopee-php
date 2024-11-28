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

class BundleDeal extends Resource
{
    /**
     * API: v2.bundle_deal.add_bundle_deal
     */
    public function addBundleDeal($data)
    {
        return $this->call('POST', 'bundle_deal/add_bundle_deal', [
            RequestOptions::JSON => $data
        ]);
    }

    /**
     * API: v2.bundle_deal.add_bundle_deal_item
     */
    public function addBundleDealItem($bundle_deal_id, $item_list)
    {
        return $this->call('POST', 'bundle_deal/add_bundle_deal_item', [
            RequestOptions::JSON => [
                'bundle_deal_id' => $bundle_deal_id,
                'item_list' => $item_list,
            ]
        ]);
    }

    /**
     * API: v2.bundle_deal.get_bundle_deal_list
     */
    public function getBundleDealList($params = [])
    {
        return $this->call('GET', 'bundle_deal/get_bundle_deal_list', [
            RequestOptions::QUERY => array_merge([
                'page_no' => 1,
                'page_size' => 100,
                'time_status' => 1, // The Status of bundle deal，all=1；upcoming=2；ongoing=3，expired=4
            ], $params)
        ]);
    }

    /**
     * API: v2.bundle_deal.get_bundle_deal
     */
    public function getBundleDeal($bundle_deal_id)
    {
        return $this->call('GET', 'bundle_deal/get_bundle_deal', [
            RequestOptions::QUERY => [
                'bundle_deal_id' => $bundle_deal_id,
            ]
        ]);
    }

    /**
     * API: v2.bundle_deal.get_bundle_deal_item
     */
    public function getBundleDealItem($bundle_deal_id)
    {
        return $this->call('GET', 'bundle_deal/get_bundle_deal_item', [
            RequestOptions::QUERY => [
                'bundle_deal_id' => $bundle_deal_id,
            ]
        ]);
    }

    /**
     * API: v2.bundle_deal.update_bundle_deal
     */
    public function updateBundleDeal($bundle_deal_id, $data)
    {
        return $this->call('POST', 'bundle_deal/update_bundle_deal', [
            RequestOptions::JSON => array_merge($data, [
                'bundle_deal_id' => $bundle_deal_id,
            ])
        ]);
    }

    /**
     * API: v2.bundle_deal.update_bundle_deal_item
     */
    public function updateBundleDealItem($bundle_deal_id, $item_list)
    {
        return $this->call('POST', 'bundle_deal/update_bundle_deal_item', [
            RequestOptions::JSON => [
                'bundle_deal_id' => $bundle_deal_id,
                'item_list' => $item_list,
            ]
        ]);
    }

    /**
     * API: v2.bundle_deal.end_bundle_deal
     */
    public function endBundleDeal($bundle_deal_id)
    {
        return $this->call('POST', 'bundle_deal/end_bundle_deal', [
            RequestOptions::JSON => [
                'bundle_deal_id' => $bundle_deal_id,
            ]
        ]);
    }

    /**
     * API: v2.bundle_deal.delete_bundle_deal
     */
    public function deleteBundleDeal($bundle_deal_id)
    {
        return $this->call('POST', 'bundle_deal/delete_bundle_deal', [
            RequestOptions::JSON => [
                'bundle_deal_id' => $bundle_deal_id,
            ]
        ]);
    }

    /**
     * API: v2.bundle_deal.delete_bundle_deal_item
     */
    public function deleteBundleDealItem($bundle_deal_id, $item_list)
    {
        return $this->call('POST', 'bundle_deal/delete_bundle_deal_item', [
            RequestOptions::JSON => [
                'bundle_deal_id' => $bundle_deal_id,
                'item_list' => $item_list,
            ]
        ]);
    }
}
