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
    protected $prefix = 'auth';

    /**
     * @param $code
     * @param $shop_id
     * @return mixed
     */
    public function getToken($code, $shop_id, $partner_id)
    {
        return $this->call('POST', 'token/get', [
            RequestOptions::JSON => [
                'code' => $code,
                'shop_id' => intval($shop_id),
                'partner_id' => intval($partner_id),
            ]
        ]);
    }

    /**
     * @param $refresh_token
     * @param $shop_id
     * @return mixed
     */
    public function refreshNewToken($refresh_token, $shop_id, $partner_id)
    {
        return $this->call('POST', 'access_token/get', [
            RequestOptions::JSON => [
                'refresh_token' => $refresh_token,
                'shop_id' => intval($shop_id),
                'partner_id' => intval($partner_id),
            ]
        ]);
    }
}
