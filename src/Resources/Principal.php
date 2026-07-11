<?php
/*
 * This file is part of shopee-php.
 *
 * Copyright (c) 2026 Jin <j@sax.vn> All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EcomPHP\Shopee\Resources;

use EcomPHP\Shopee\Resource;
use GuzzleHttp\RequestOptions;

class Principal extends Resource
{
    /**
     * API: v2.principal.get_shop_sales_performance_detail
     */
    public function getShopSalesPerformanceDetail($params = [])
    {
        return $this->call('GET', 'principal/get_shop_sales_performance_detail', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.principal.get_principal_sales_performance_detail
     */
    public function getPrincipalSalesPerformanceDetail($params = [])
    {
        return $this->call('GET', 'principal/get_principal_sales_performance_detail', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.principal.get_shop_affiliate_performance
     */
    public function getShopAffiliatePerformance($params = [])
    {
        return $this->call('GET', 'principal/get_shop_affiliate_performance', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.principal.get_principal_affiliate_performance
     */
    public function getPrincipalAffiliatePerformance($params = [])
    {
        return $this->call('GET', 'principal/get_principal_affiliate_performance', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.principal.get_content_affiliate_performance
     */
    public function getContentAffiliatePerformance($params = [])
    {
        return $this->call('GET', 'principal/get_content_affiliate_performance', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.principal.get_shop_livestream_performance
     */
    public function getShopLivestreamPerformance($params = [])
    {
        return $this->call('GET', 'principal/get_shop_livestream_performance', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.principal.get_principal_livestream_performance
     */
    public function getPrincipalLivestreamPerformance($params = [])
    {
        return $this->call('GET', 'principal/get_principal_livestream_performance', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.principal.get_session_livestream_performance
     */
    public function getSessionLivestreamPerformance($params = [])
    {
        return $this->call('GET', 'principal/get_session_livestream_performance', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.principal.get_shop_video_performance
     */
    public function getShopVideoPerformance($params = [])
    {
        return $this->call('GET', 'principal/get_shop_video_performance', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.principal.get_principal_video_performance
     */
    public function getPrincipalVideoPerformance($params = [])
    {
        return $this->call('GET', 'principal/get_principal_video_performance', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.principal.get_clip_video_performance
     */
    public function getClipVideoPerformance($params = [])
    {
        return $this->call('GET', 'principal/get_clip_video_performance', [
            RequestOptions::QUERY => $params,
        ]);
    }
}