<?php
/*
 * This file is part of shopee-php.
 *
 * (c) Jin <j@sax.vn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EcomPHP\Shopee\Resources;

use GuzzleHttp\RequestOptions;
use EcomPHP\Shopee\Resource;

class Authorization extends Resource
{
    /**
     * API: v2.public.get_shops_by_partner
     * get basic info of shops which have authorized to the partner.
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
     * Use this API to get basic info of merchants which have authorized to the partner.
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
     * Use the code from the authorization step to call this API to obtain the authorized shop_id, merchant_id, supplier_id, or user_id, and its corresponding access_token and refresh_token.
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
     * Use this API to refresh the access_token after it expires. Refresh_token can be used once only, this API will also return a new refresh_token. Please use the new refresh_token for the next RefreshAccessToken call
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
     * Use the resend code to get access token and refresh token. When you lost your access token or refresh token, you can go to authorization management page to resend code by yourselves. You can only use this endpoint in live environment, we don't support in test-stable environment.
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
     * You can get shopee ip address ranges through this open api.
     */
    public function getShopeeIpRanges()
    {
        return $this->call('GET', 'public/get_shopee_ip_ranges');
    }
}
