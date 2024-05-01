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

class Push extends Resource
{
    /**
     * API: v2.push.set_app_push_config
     * you can turn on or turn off your app push config setting through this open api
     */
    public function setAppPushConfig($callback_url = null, $set_on = [], $set_off = [], $blocked_shop_id_list = [])
    {
        return $this->call('POST', 'push/set_app_push_config', [
            RequestOptions::JSON => [
                'callback_url' => $callback_url,
                'set_push_config_on' => $set_on,
                'set_push_config_off' => $set_off,
                'blocked_shop_id_list' => $blocked_shop_id_list,
            ]
        ]);
    }

    /**
     * API: v2.push.get_app_push_config
     * you can get your app current push config setting through this api
     */
    public function getAppPushConfig()
    {
        return $this->call('GET', 'push/get_app_push_config');
    }

    /**
     * API: v2.push.get_lost_push_message
     * Get the lost push messages that were lost within 3 days of the current time and not confirmed to have been consumed
     */
    public function getLostPushMessage()
    {
        return $this->call('GET', 'push/get_lost_push_message');
    }

    /**
     * API: v2.push.confirm_consumed_lost_push_message
     * Confirm consumed lost push message
     */
    public function confirmConsumedLostPushMessage($last_message_id)
    {
        return $this->call('POST', 'push/confirm_consumed_lost_push_message', [
            RequestOptions::JSON => [
                'last_message_id' => $last_message_id,
            ]
        ]);
    }
}
