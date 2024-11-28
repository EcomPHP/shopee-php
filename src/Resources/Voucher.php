<?php
/*
 * This file is part of shopee-php.
 *
 * Copyright (c) 2024 Jin <j@sax.vn> All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jekka\Shopee\Resources;

use Jekka\Shopee\Resource;
use GuzzleHttp\RequestOptions;

class Voucher extends Resource
{
    /**
     * API: v2.voucher.add_voucher
     */
    public function addVoucher($data)
    {
        return $this->call('POST', 'voucher/add_voucher', [
            RequestOptions::JSON => $data
        ]);
    }

    /**
     * API: v2.voucher.delete_voucher
     */
    public function deleteVoucher($voucher_id)
    {
        return $this->call('POST', 'voucher/delete_voucher', [
            RequestOptions::JSON => [
                'voucher_id' => $voucher_id,
            ]
        ]);
    }

    /**
     * API: v2.voucher.end_voucher
     */
    public function endVoucher($voucher_id)
    {
        return $this->call('POST', 'voucher/end_voucher', [
            RequestOptions::JSON => [
                'voucher_id' => $voucher_id,
            ]
        ]);
    }

    /**
     * API: v2.voucher.get_voucher
     */
    public function getVoucher($voucher_id)
    {
        return $this->call('POST', 'voucher/get_voucher', [
            RequestOptions::JSON => [
                'voucher_id' => $voucher_id,
            ]
        ]);
    }

    /**
     * API: v2.voucher.get_voucher_list
     */
    public function getVoucherList($params)
    {
        return $this->call('GET', 'voucher/get_voucher_list', [
            RequestOptions::QUERY => array_merge([
                'page_size' => 100,
                'page_no' => 1,
                'status' => 'all',
            ], $params)
        ]);
    }

    /**
     * API: v2.voucher.update_voucher
     */
    public function updateVoucher($voucher_id, $data)
    {
        $data['voucher_id'] = $voucher_id;

        return $this->call('POST', 'voucher/update_voucher', [
            RequestOptions::JSON => $data
        ]);
    }
}
