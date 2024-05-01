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

class Order extends Resource
{
    /**
     * API: v2.order.get_order_list
     * Use this api to search orders.
     *
     * @param  array  $params
     * @return array|mixed
     */
    public function getOrderList($params = [])
    {
        $params = array_merge([
            'time_range_field' => 'create_time',
            'time_from' => strtotime('-7 days'),
            'time_to' => time(),
            'page_size' => 20,
        ], $params);

        return $this->call('GET', 'order/get_order_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.order.get_shipment_list
     * Use this api to get order list which order_status is READY_TO_SHIP.
     *
     * @param  array  $params
     * @return array|mixed
     */
    public function getShipmentList($params = [])
    {
        $params['page_size'] = 20;
        return $this->call('GET', 'order/get_shipment_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.order.get_order_detail
     * Use this api to get order detail.
     *
     * @param $ids
     * @param  array  $params
     * @return array|mixed
     */
    public function getOrderDetail($ids, $params = [])
    {
        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }

        $params['order_sn_list'] = $ids;

        return $this->call('GET', 'order/get_order_detail', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.order.split_order
     * Use this api to split an order into multiple packages.
     */
    public function splitOrder($order_sn, $package_list)
    {
        return $this->call('POST', 'order/split_order', [
            RequestOptions::JSON => [
                'order_sn' => $order_sn,
                'package_list' => $package_list,
            ],
        ]);
    }

    /**
     * API: v2.order.unsplit_order
     * Use this ai to undo split of order. After undo split, the order will have only one package. It can only be used when order status still at READY_TO_SHIP.
     */
    public function unsplitOrder($order_sn)
    {
        return $this->call('POST', 'order/unsplit_order', [
            RequestOptions::JSON => [
                'order_sn' => $order_sn,
            ],
        ]);
    }

    /**
     * API: v2.order.cancel_order
     * Use this api to cancel an order. This action can only be performed before an order has been shipped.
     */
    public function cancelOrder($order_sn, $cancel_reason, $item_list = [])
    {
        return $this->call('POST', 'order/cancel_order', [
            RequestOptions::JSON => [
                'order_sn' => $order_sn,
                'cancel_reason' => $cancel_reason,
                'item_list' => $item_list,
            ],
        ]);
    }

    /**
     * API: v2.order.set_note
     * Use this api to set note for an order.
     */
    public function setNoteOrder($order_sn, $note)
    {
        return $this->call('POST', 'order/set_note', [
            RequestOptions::JSON => [
                'order_sn' => $order_sn,
                'note' => $note,
            ],
        ]);
    }

    /**
     * API: v2.order.get_pending_buyer_invoice_order_list
     * This endpoint only for PH and BR local sellers only. This API is used for seller to retrieve a list of order IDs that are pending invoice upload.
     */
    public function getPendingBuyerInvoiceOrderList($params = [])
    {
        $params['page_size'] = 20;
        return $this->call('GET', 'order/get_pending_buyer_invoice_order_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.order.upload_invoice_doc
     * This endpoint is for PH and BR local seller. Upload the invoice document
     */
    public function uploadInvoiceDoc($order_sn, $file_type, $file)
    {
        return $this->call('POST', 'order/upload_invoice_doc', [
            RequestOptions::MULTIPART => [
                [
                    'name' => 'order_sn',
                    'contents' => $order_sn,
                ],
                [
                    'name' => 'file_type',
                    'contents' => $file_type,
                ],
                [
                    'name' => 'file',
                    'contents' => fopen($file, 'r'),
                ],
            ],
        ]);
    }

    /**
     * API: v2.order.download_invoice_doc
     * This endpoint only for PH and BR local seller. Seller can download the invoice uploaded before through this endpoint.
     */
    public function downloadInvoiceDoc($order_sn)
    {
        return $this->call('GET', 'order/download_invoice_doc', [
            RequestOptions::QUERY => [
                'order_sn' => $order_sn,
            ],
        ]);
    }

    /**
     * API: v2.order.get_buyer_invoice_info
     * Use this api to get buyer invoice info.
     *
     * @param $order_sn_list
     * @return array|mixed
     */
    public function getBuyerInvoiceInfo($order_sn_list)
    {
        if (is_string($order_sn_list)) {
            $order_sn_list = [$order_sn_list];
        }

        $params = [
            'queries' => array_map(function ($order_sn) {
                return [
                    'order_sn' => $order_sn,
                ];
            }, $order_sn_list)
        ];

        return $this->call('POST', 'order/get_buyer_invoice_info', [
            RequestOptions::JSON => $params,
        ]);
    }
}
