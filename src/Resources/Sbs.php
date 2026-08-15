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

class Sbs extends Resource
{
    /**
     * API: v2.sbs.get_fulfillment_mapping_inventory_list
     * Query Fulfillment Mapping relationships and inventory information.
     */
    public function getFulfillmentMappingInventoryList($params = [])
    {
        $params = array_merge([
            'page_size' => 100,
        ], $params);

        if (isset($params['mtsku_ids']) && is_array($params['mtsku_ids'])) {
            $params['mtsku_ids'] = implode(',', $params['mtsku_ids']);
        }

        return $this->call('GET', 'sbs/get_fulfillment_mapping_inventory_list', [
            RequestOptions::QUERY => $params,
        ]);
    }
}