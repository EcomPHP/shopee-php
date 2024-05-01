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
}
