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

class Logistic extends Resource
{
    /**
     * API: v2.logistics.get_shipping_parameter
     * Use this api to get the parameter "info_needed" from the response to check if the order has pickup or dropoff or no integrate options.
     * This api will also return the addresses and pickup time id options for the pickup method.
     * For dropoff, it can return branch id, sender real name etc, depending on the 3PL requirements.
     *
     * @param  string  $order_sn
     * @param  string  $package_number
     * @return array|mixed
     */
    public function getShippingParameter($order_sn, $package_number = '')
    {
        return $this->call('GET', 'logistics/get_shipping_parameter', [
            RequestOptions::QUERY => [
                'order_sn' => $order_sn,
                'package_number' => $package_number,
            ],
        ]);
    }

    /**
     * API: v2.logistics.get_tracking_number
     * Use this api to get tracking_number when you have shipped order.
     *
     * @param $order_id
     * @param  array  $params
     * @return array|mixed
     */
    public function getTrackingNumber($order_id, $params = [])
    {
        $params['order_sn'] = $order_id;
        return $this->call('GET', 'logistics/get_tracking_number', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.logistics.ship_order
     * Use this api to initiate logistics including arrange pickup, dropoff or shipment for non-integrated logistic channels.
     * Should call v2.logistics.get_shipping_parameter to fetch all required param first.
     * It's recommended to initiate logistics one hour after the orders were placed since there is one-hour window buyer can cancel any order without request to seller.
     *
     * @param  string $order_sn
     * @param  string $package_number
     * @param  array $pickup
     * @param  array $dropoff
     * @param  array $non_integrated
     * @return array|mixed
     */
    public function shipOrder($order_sn, $package_number = '', $pickup = [], $dropoff = [], $non_integrated = [])
    {
        $params = [
            'order_sn' => $order_sn,
            'package_number' => $package_number,
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'non_integrated' => $non_integrated,
        ];

        return $this->call('POST', 'logistics/ship_order', [
            RequestOptions::JSON => $params,
        ]);
    }

    /**
     * API: v2.logistics.update_shipping_order
     * For pickup method only, use this api to update pickup address and pickup time for orders in "RETRY_SHIP" status.
     *
     * @param  string  $order_sn
     * @param  string  $package_number
     * @param  array  $pickup
     * @return array|mixed
     */
    public function updateShippingOrder($order_sn, $package_number = '', $pickup = [])
    {
        $params = [
            'order_sn' => $order_sn,
            'package_number' => $package_number,
            'pickup' => $pickup,
        ];

        return $this->call('POST', 'logistics/update_shipping_order', [
            RequestOptions::JSON => $params,
        ]);
    }

    /**
     * API: v2.logistics.get_shipping_document_parameter
     * Use this api to get the selectable shipping_document_type and suggested shipping_document_type.
     *
     * @param  array{order_sn: string, package_number: string}  $order_list
     * @return array|mixed
     */
    public function getShippingDocumentParameter($order_list)
    {
        return $this->call('POST', 'logistics/get_shipping_document_parameter', [
            RequestOptions::JSON => [
                'order_list' => $order_list,
            ],
        ]);
    }

    /**
     * API: v2.logistics.create_shipping_document
     * Use this api to create shipping document task for each order or package and this API is only available after retrieving the tracking number.
     *
     * @param array{order_sn: string, package_number: string, tracking_number: string, shipping_document_type: string} $order_list
     * @return array|mixed|string
     */
    public function createShippingDocument($order_list = [])
    {
        return $this->call('POST', 'logistics/create_shipping_document', [
            RequestOptions::JSON => [
                'order_list' => $order_list,
            ],
        ]);
    }

    /**
     * API: v2.logistics.get_shipping_document_result
     * Use this api to retrieve the status of the shipping document task. Document will be available for download only after the status change to 'READY'.
     *
     * @param  array{order_sn: string, package_number: string, shipping_document_type: string}  $order_list
     * @return array|mixed
     */
    public function getShippingDocumentResult($order_list = [])
    {
        return $this->call('POST', 'logistics/get_shipping_document_result', [
            RequestOptions::JSON => [
                'order_list' => $order_list,
            ],
        ]);
    }

    /**
     * API: v2.logistics.download_shipping_document
     * Use this api to download shipping_document.
     * You have to call v2.logistics.create_shipping_document to create a new shipping document task first and call v2.logistics.get_shipping_document_result to get the task status second.
     * If the task is READY, you can download this shipping document.
     *
     * @param  array{order_sn: string, package_number: string}  $order_list
     * @param  string $shipping_document_type
     * @return array|mixed
     */
    public function downloadShippingDocument($order_list = [], $shipping_document_type = '')
    {
        return $this->call('POST', 'logistics/download_shipping_document', [
            RequestOptions::JSON => [
                'order_list' => $order_list,
                'shipping_document_type' => $shipping_document_type,
            ],
        ]);
    }

    /**
     * API: v2.logistics.get_tracking_info
     * Use this api to get the logistics tracking information of an order.
     *
     * @param  string  $order_sn
     * @param  string  $package_number
     * @return array|mixed
     */
    public function getTrackingInfo($order_sn, $package_number = '')
    {
        return $this->call('GET', 'logistics/get_tracking_info', [
            RequestOptions::QUERY => [
                'order_sn' => $order_sn,
                'package_number' => $package_number,
            ],
        ]);
    }

    /**
     * API: v2.logistics.get_address_list
     * For integrated logistics channel, use this call to get pickup address for pickup mode order.
     *
     * @return array|mixed
     */
    public function getAddressList()
    {
        return $this->call('GET', 'logistics/get_address_list');
    }

    /**
     * API: v2.logistics.set_address_config
     * Use this API to set address config of your shop.
     *
     * @param array{address_id: int, address: string, address_type: array} $address_type_config
     * @param bool $show_pickup_address
     * @return array|mixed
     */
    public function setAddressConfig($address_type_config = [], $show_pickup_address = true)
    {
        return $this->call('POST', 'logistics/set_address_config', [
            RequestOptions::JSON => [
                'address_type_config' => $address_type_config,
                'show_pickup_address' => $show_pickup_address,
            ],
        ]);
    }

    /**
     * API: v2.logistics.delete_address
     * Use this api to delete address.
     *
     * @param  int  $address_id
     * @return array|mixed
     */
    public function deleteAddress($address_id)
    {
        return $this->call('POST', 'logistics/delete_address', [
            RequestOptions::JSON => [
                'address_id' => $address_id,
            ],
        ]);
    }

    /**
     * API: v2.logistics.get_channel_list
     * Use this api to get branch list.
     *
     * @return array|mixed
     */
    public function getChannelList()
    {
        return $this->call('GET', 'logistics/get_channel_list');
    }

    /**
     * API: v2.logistics.update_channel
     * Use this api to update shop level logistics channel's configuration.
     *
     * @param  int  $logistics_channel_id
     * @param  bool $enabled
     * @param  bool $cod_enabled
     * @return array|mixed
     */
    public function updateChannel($logistics_channel_id, $enabled = true, $cod_enabled = true)
    {
        return $this->call('POST', 'logistics/update_channel', [
            RequestOptions::JSON => [
                'logistics_channel_id' => $logistics_channel_id,
                'enabled' => $enabled,
                'cod_enabled' => $cod_enabled,
            ],
        ]);
    }

    /**
     * API: v2.logistics.batch_ship_order
     * Use this api to batch initiate logistics including arrange pickup, dropoff or shipment for non-integrated logistic channels.
     * Should call v2.logistics.get_shipping_parameter to fetch all required param first.
     * It's recommended to initiate logistics one hour after the orders were placed since there is one-hour window buyer can cancel any order without request to seller.Only channel 90003 - Padrão in Brazil has the permission of this API.
     *
     * @param  array{order_sn: string, package_number: string}  $order_list
     * @param  array  $pickup
     * @param  array  $dropoff
     * @param  array  $non_integrated
     * @return array|mixed
     */
    public function batchShipOrder($order_list = [], $pickup = [], $dropoff = [], $non_integrated = [])
    {
        return $this->call('POST', 'logistics/batch_ship_order', [
            RequestOptions::JSON => [
                'order_list' => $order_list,
                'pickup' => $pickup,
                'dropoff' => $dropoff,
                'non_integrated' => $non_integrated,
            ],
        ]);
    }

    /**
     * API: v2.logistics.get_shipping_document_data_info
     * Use this api to fetch the logistics information of an order, these info can be used for airwaybill printing.
     * Dedicated for crossborder SLS order airwaybill.
     * May not be applicable for local channel airwaybill.
     * Besides, this api supports returning personal info as images.
     *
     * @param  string $order_sn
     * @param  string $package_number
     * @param  array $recipient_address_info
     * @return array|mixed
     */
    public function getShippingDocumentDataInfo($order_sn, $package_number = '', $recipient_address_info = [])
    {
        return $this->call('POST', 'logistics/get_shipping_document_data_info', [
            RequestOptions::JSON => [
                'order_sn' => $order_sn,
                'package_number' => $package_number,
                'recipient_address_info' => $recipient_address_info,
            ],
        ]);
    }
}
