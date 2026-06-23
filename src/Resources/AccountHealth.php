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
     * API: v2.account_health.get_shop_performance
     * The data metrics of shop performance.
     */
    public function getShopPerformance()
    {
        return $this->call('GET', 'account_health/get_shop_performance');
    }

    /**
     * API: v2.account_health.shop_penalty
     *
     * @deprecated
     */
    public function shopPenalty()
    {
        return $this->call('GET', 'account_health/shop_penalty');
    }

    /**
     * API: v2.account_health.get_metric_source_detail
     * Get the Affected Orders / Relevant Listings / Relevant Violations details of metrics.
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
     * API: v2.account_health.get_penalty_point_history
     * Get the penalty point records generated in the current quarter.
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
     * API: v2.account_health.get_punishment_history
     * Get the punishment records generated in the current quarter.
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
     * API: v2.account_health.get_listings_with_issues
     * Get the Problematic Listings to improve the listings to avoid incurring penalty points.
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
     * API: v2.account_health.get_late_orders
     * Get the Late Orders to take action to avoid order cancellation and penalty points.
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
