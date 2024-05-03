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

class FollowPrize extends Resource
{
    /**
     * API: v2.follow_prize.add_follow_prize
     */
    public function addFollowPrize($data)
    {
        return $this->call('POST', 'follow_prize/add_follow_prize', [
            RequestOptions::JSON => $data
        ]);
    }

    /**
     * API: v2.follow_prize.delete_follow_prize
     */
    public function deleteFollowPrize($campaign_id)
    {
        return $this->call('POST', 'follow_prize/delete_follow_prize', [
            RequestOptions::JSON => [
                'campaign_id' => $campaign_id,
            ]
        ]);
    }

    /**
     * API: v2.follow_prize.end_follow_prize
     */
    public function endFollowPrize($campaign_id)
    {
        return $this->call('POST', 'follow_prize/end_follow_prize', [
            RequestOptions::JSON => [
                'campaign_id' => $campaign_id,
            ]
        ]);
    }

    /**
     * API: v2.follow_prize.update_follow_prize
     */
    public function updateFollowPrize($data)
    {
        return $this->call('POST', 'follow_prize/update_follow_prize', [
            RequestOptions::JSON => $data
        ]);
    }

    /**
     * API: v2.follow_prize.get_follow_prize_detail
     */
    public function getFollowPrizeDetail($campaign_id)
    {
        return $this->call('GET', 'follow_prize/get_follow_prize_detail', [
            RequestOptions::QUERY => [
                'campaign_id' => $campaign_id,
            ]
        ]);
    }

    /**
     * API: v2.follow_prize.get_follow_prize_list
     */
    public function getFollowPrizeList($params = [])
    {
        return $this->call('GET', 'follow_prize/get_follow_prize_list', [
            RequestOptions::QUERY => array_merge([
                'page_no' => 1,
                'page_size' => 100,
                'status' => 'all'
            ], $params)
        ]);
    }
}
