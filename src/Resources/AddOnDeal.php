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

class AddOnDeal extends Resource
{
    /**
     * API: v2.add_on_deal.add_add_on_deal
     * Add Add-on Deal
     */
    public function addAddOnDeal($data)
    {
        return $this->call('POST', 'add_on_deal/add_add_on_deal', [
            RequestOptions::JSON => $data,
        ]);
    }

    /**
     * API: v2.add_on_deal.add_add_on_deal_main_item
     * Add Add-on Deal Main Item
     */
    public function addAddOnDealMainItem($add_on_deal_id, $main_item_list)
    {
        return $this->call('POST', 'add_on_deal/add_add_on_deal_main_item', [
            RequestOptions::JSON => [
                'add_on_deal_id' => $add_on_deal_id,
                'main_item_list' => $main_item_list,
            ],
        ]);
    }

    /**
     * API: v2.add_on_deal.add_add_on_deal_sub_item
     * Add Add-on Deal Sub Item
     */
    public function addAddOnDealSubItem($add_on_deal_id, $sub_item_list)
    {
        return $this->call('POST', 'add_on_deal/add_add_on_deal_sub_item', [
            RequestOptions::JSON => [
                'add_on_deal_id' => $add_on_deal_id,
                'sub_item_list' => $sub_item_list,
            ],
        ]);
    }

    /**
     * API: v2.add_on_deal.delete_add_on_deal
     * Delete Add-on Deal
     */
    public function deleteAddOnDeal($add_on_deal_id)
    {
        return $this->call('POST', 'add_on_deal/delete_add_on_deal', [
            RequestOptions::JSON => [
                'add_on_deal_id' => $add_on_deal_id,
            ]
        ]);
    }

    /**
     * API: v2.add_on_deal.delete_add_on_deal_main_item
     * Delete Add-on Deal Main Item
     */
    public function deleteAddOnDealMainItem($add_on_deal_id, $main_item_list)
    {
        return $this->call('POST', 'add_on_deal/delete_add_on_deal_main_item', [
            RequestOptions::JSON => [
                'add_on_deal_id' => $add_on_deal_id,
                'main_item_list' => $main_item_list,
            ],
        ]);
    }

    /**
     * API: v2.add_on_deal.delete_add_on_deal_sub_item
     * Delete Add-on Deal Sub Item
     */
    public function deleteAddOnDealSubItem($add_on_deal_id, $sub_item_list)
    {
        return $this->call('POST', 'add_on_deal/delete_add_on_deal_sub_item', [
            RequestOptions::JSON => [
                'add_on_deal_id' => $add_on_deal_id,
                'sub_item_list' => $sub_item_list,
            ],
        ]);
    }

    /**
     * API: v2.add_on_deal.get_add_on_deal_list
     * Get Add-on Deal List
     */
    public function getAddOnDealList($params = [])
    {
        return $this->call('GET', 'add_on_deal/get_add_on_deal_list', [
            RequestOptions::QUERY => array_merge([
                'page_no' => 1,
                'page_size' => 100,
                'promotion_status' => 'all',
            ], $params),
        ]);
    }

    /**
     * API: v2.add_on_deal.get_add_on_deal
     * Get Add-on Deal
     */
    public function getAddOnDeal($add_on_deal_id)
    {
        return $this->call('GET', 'add_on_deal/get_add_on_deal', [
            RequestOptions::QUERY => [
                'add_on_deal_id' => $add_on_deal_id,
            ]
        ]);
    }

    /**
     * API: v2.add_on_deal.get_add_on_deal_main_item
     * Get Add-on Deal Main Item
     */
    public function getAddOnDealMainItem($add_on_deal_id)
    {
        return $this->call('GET', 'add_on_deal/get_add_on_deal_main_item', [
            RequestOptions::QUERY => [
                'add_on_deal_id' => $add_on_deal_id,
            ]
        ]);
    }

    /**
     * API: v2.add_on_deal.get_add_on_deal_sub_item
     * Get Add-on Deal Sub Item
     */
    public function getAddOnDealSubItem($add_on_deal_id)
    {
        return $this->call('GET', 'add_on_deal/get_add_on_deal_sub_item', [
            RequestOptions::QUERY => [
                'add_on_deal_id' => $add_on_deal_id,
            ]
        ]);
    }

    /**
     * API: v2.add_on_deal.update_add_on_deal
     * Update Add-on Deal
     */
    public function updateAddOnDeal($add_on_deal_id, $data)
    {
        $data['add_on_deal_id'] = $add_on_deal_id;

        return $this->call('POST', 'add_on_deal/update_add_on_deal', [
            RequestOptions::JSON => $data
        ]);
    }

    /**
     * API: v2.add_on_deal.update_add_on_deal_main_item
     * Update Add-on Deal Main Item
     */
    public function updateAddOnDealMainItem($add_on_deal_id, $main_item_list)
    {
        return $this->call('POST', 'add_on_deal/update_add_on_deal_main_item', [
            RequestOptions::JSON => [
                'add_on_deal_id' => $add_on_deal_id,
                'main_item_list' => $main_item_list,
            ],
        ]);
    }

    /**
     * API: v2.add_on_deal.update_add_on_deal_sub_item
     * Update Add-on Deal Sub Item
     */
    public function updateAddOnDealSubItem($add_on_deal_id, $sub_item_list)
    {
        return $this->call('POST', 'add_on_deal/update_add_on_deal_sub_item', [
            RequestOptions::JSON => [
                'add_on_deal_id' => $add_on_deal_id,
                'sub_item_list' => $sub_item_list,
            ],
        ]);
    }

    /**
     * API: v2.add_on_deal.end_add_on_deal
     * End Add-on Deal
     */
    public function endAddOnDeal($add_on_deal_id)
    {
        return $this->call('POST', 'add_on_deal/end_add_on_deal', [
            RequestOptions::JSON => [
                'add_on_deal_id' => $add_on_deal_id,
            ]
        ]);
    }
}
