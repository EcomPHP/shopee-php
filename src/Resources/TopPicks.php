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

class TopPicks extends Resource
{
    /**
     * API: v2.top_picks.get_top_picks_list
     */
    public function getTopPicksList()
    {
        return $this->call('GET', 'top_picks/get_top_picks_list');
    }

    /**
     * API: v2.top_picks.add_top_picks
     */
    public function addTopPicks($name, $item_id_list, $is_activated = true)
    {
        return $this->call('POST', 'top_picks/add_top_picks', [
            RequestOptions::JSON => [
                'name' => $name,
                'item_id_list' => $item_id_list,
                'is_activated' => $is_activated,
            ]
        ]);
    }

    /**
     * API: v2.top_picks.update_top_picks
     */
    public function updateTopPicks($top_picks_id, $name = null, $item_id_list = null, $is_activated = null)
    {
        return $this->call('POST', 'top_picks/update_top_picks', [
            RequestOptions::JSON => [
                'top_picks_id' => $top_picks_id,
                'name' => $name,
                'item_id_list' => $item_id_list,
                'is_activated' => $is_activated,
            ]
        ]);
    }

    /**
     * API: v2.top_picks.delete_top_picks
     */
    public function deleteTopPicks($top_picks_id)
    {
        return $this->call('POST', 'top_picks/delete_top_picks', [
            RequestOptions::JSON => [
                'top_picks_id' => $top_picks_id,
            ]
        ]);
    }
}
