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

class AccountHealth extends Resource
{
    /**
     * API: v2.account_health.shop_performance
     */
    public function shopPerformance()
    {
        return $this->call('GET', 'account_health/shop_performance');
    }

    /**
     * API: v2.account_health.shop_penalty
     */
    public function shopPenalty()
    {
        return $this->call('GET', 'account_health/shop_penalty');
    }

    /**
     * v2.account_health.get_metric_source_detail
     */
    public function getMetricSourceDetail($metric_id, $page_no = 1, $page_size = 100)
    {
        return $this->call('GET', 'account_health/get_metric_source_detail', [
            RequestOptions::QUERY => [
                'metric_id' => $metric_id,
                'page_no' => $page_no,
                'page_size' => $page_size,
            ]
        ]);
    }

    /**
     * v2.account_health.get_penalty_point_history
     */
    public function getPenaltyPointHistory($violation_type = null, $page_no = 1, $page_size = 100)
    {
        return $this->call('GET', 'account_health/get_penalty_point_history', [
            RequestOptions::QUERY => array_filter([
                'page_no' => $page_no,
                'page_size' => $page_size,
                'violation_type' => $violation_type,
            ])
        ]);
    }

    /**
     * v2.account_health.get_punishment_history
     */
    public function getPunishmentHistory($punishment_status, $page_no = 1, $page_size = 100)
    {
        return $this->call('GET', 'account_health/get_punishment_history', [
            RequestOptions::QUERY => array_filter([
                'page_no' => $page_no,
                'page_size' => $page_size,
                'punishment_status' => $punishment_status,
            ])
        ]);
    }

    /**
     * v2.account_health.get_listings_with_issues
     */
    public function getListingsWithIssues($page_no = 1, $page_size = 100)
    {
        return $this->call('GET', 'account_health/get_listings_with_issues', [
            RequestOptions::QUERY => array_filter([
                'page_no' => $page_no,
                'page_size' => $page_size,
            ])
        ]);
    }

    /**
     * v2.account_health.get_late_orders
     */
    public function getLateOrders($page_no = 1, $page_size = 100)
    {
        return $this->call('GET', 'account_health/get_late_orders', [
            RequestOptions::QUERY => array_filter([
                'page_no' => $page_no,
                'page_size' => $page_size,
            ])
        ]);
    }
}
