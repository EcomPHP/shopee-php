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

class Ads extends Resource
{
    /**
     * API: v2.ads.get_total_balance
     * Use this API to return the seller's Real-time total balance of their ads credit including the paid credits and free credits.
     */
    public function getTotalBalance()
    {
        return $this->call('GET', 'ads/get_total_balance');
    }

    /**
     * API: v2.ads.get_shop_toggle_info
     * Use this API to get Shop level info - i.e. seller's toggle status is on/off
     */
    public function getShopToggleInfo()
    {
        return $this->call('GET', 'ads/get_shop_toggle_info');
    }

    /**
     * API: v2.ads.get_recommended_keyword_list
     * Use this API to get the list of Recommended keywords by item and optionally a search keyword
     */
    public function getRecommendedKeywordList($item_id, $input_keyword = null)
    {
        return $this->call('GET', 'ads/get_recommended_keyword_list', [
            RequestOptions::QUERY => [
                'item_id' => $item_id,
                'input_keyword' => $input_keyword
            ]
        ]);
    }

    /**
     * API: v2.ads.get_recommended_item_list
     * Use this API to get the list of recommended SKU (Shop level) with the corresponding tag, i.e top search/best selling/best ROI tag.
     */
    public function getRecommendedItemList()
    {
        return $this->call('GET', 'ads/get_recommended_item_list');
    }

    /**
     * API: v2.ads.get_all_cpc_ads_hourly_performance
     * Use this API to get Shop level CPC ads single-date hourly performance.
     */
    public function getAllCpcAdsHourlyPerformance($performance_date)
    {
        return $this->call('GET', 'ads/get_all_cpc_ads_hourly_performance', [
            RequestOptions::QUERY => [
                'performance_date' => $performance_date
            ]
        ]);
    }

    /**
     * API: v2.ads.get_all_cpc_ads_daily_performance
     * Use this API to get Shop level CPC ads multiple-days daily performance.
     */
    public function getAllCpcAdsDailyPerformance($start_date, $end_date)
    {
        return $this->call('GET', 'ads/get_all_cpc_ads_daily_performance', [
            RequestOptions::QUERY => [
                'start_date' => $start_date,
                'end_date' => $end_date
            ]
        ]);
    }
}
