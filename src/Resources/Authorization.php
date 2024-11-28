<?php
/*
 * This file is part of shopee-php.
 *
 * (c) Jin <j@sax.vn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jekka\Shopee\Resources;

use GuzzleHttp\RequestOptions;
use Jekka\Shopee\Resource;

class Authorization extends Resource
{
    /**
     * API: v2.public.get_shops_by_partner
     */
    public function getShopsByPartner($params = [])
    {
        return $this->call('GET', 'public/get_shops_by_partner', [
            RequestOptions::QUERY => array_merge([
                'page_no' => 1,
                'page_size' => 100,
            ], $params),
        ]);
    }

    /**
     * API: v2.public.get_merchants_by_partner
     */
    public function getMerchantsByPartner($params = [])
    {
        return $this->call('GET', 'public/get_merchants_by_partner', [
            RequestOptions::QUERY => array_merge([
                'page_no' => 1,
                'page_size' => 100,
            ], $params),
        ]);
    }

    /**
     * API: v2.public.get_access_token
     */
    public function getToken($code, $shop_id, $partner_id)
    {
        return $this->call('POST', 'auth/token/get', [
            RequestOptions::JSON => [
                'code' => $code,
                'shop_id' => intval($shop_id),
                'partner_id' => intval($partner_id),
            ]
        ]);
    }

    /**
     * API: v2.public.refresh_access_token
     */
    public function refreshNewToken($refresh_token, $shop_id, $partner_id)
    {
        return $this->call('POST', 'auth/access_token/get', [
            RequestOptions::JSON => [
                'refresh_token' => $refresh_token,
                'shop_id' => intval($shop_id),
                'partner_id' => intval($partner_id),
            ]
        ]);
    }

    /**
     * API: v2.public.get_token_by_resend_code
     */
    public function getTokenByResendCode($resend_code)
    {
        return $this->call('POST', 'public/get_token_by_resend_code', [
            RequestOptions::JSON => [
                'resend_code' => $resend_code,
            ]
        ]);
    }

    /**
     * API: v2.public.get_refresh_token_by_upgrade_code
     */
    public function getRefreshTokenByUpgradeCode($upgrade_code, $shop_id_list)
    {
        return $this->call('POST', 'public/get_refresh_token_by_upgrade_code', [
            RequestOptions::JSON => [
                'upgrade_code' => $upgrade_code,
                'shop_id_list' => $shop_id_list,
            ]
        ]);
    }

    /**
     * API: v2.public.get_shopee_ip_ranges
     */
    public function getShopeeIpRanges()
    {
        return $this->call('GET', 'public/get_shopee_ip_ranges');
    }
}
