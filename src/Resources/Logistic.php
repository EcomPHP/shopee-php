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
     * API: v2.logistics.get_booking_shipping_parameter
     * Use this api to get the parameter "info_needed" from the response to check if the booking has pickup or dropoff or no integrate options.
     *
     * @param  string  $booking_sn
     * @return array|mixed
     */
    public function getBookingShippingParameter($booking_sn)
    {
        return $this->call('GET', 'logistics/get_booking_shipping_parameter', [
            RequestOptions::QUERY => [
                'booking_sn' => $booking_sn,
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
     * API: v2.logistics.get_booking_tracking_number
     * Use this api to get tracking_number when you have shipped booking.
     *
     * @param $booking_sn
     * @param  array  $params
     * @return array|mixed
     */
    public function getBookingTrackingNumber($booking_sn, $params = [])
    {
        $params['booking_sn'] = $booking_sn;
        return $this->call('GET', 'logistics/get_booking_tracking_number', [
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
     * API: v2.logistics.ship_booking
     * Use this api to initiate logistics for booking including arrange pickup, dropoff or shipment for non-integrated logistic channels.
     *
     * @param  string $booking_sn
     * @param  array $pickup
     * @param  array $dropoff
     * @param  array $non_integrated
     * @return array|mixed
     */
    public function shipBooking($booking_sn, $pickup = [], $dropoff = [], $non_integrated = [])
    {
        $params = [
            'booking_sn' => $booking_sn,
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'non_integrated' => $non_integrated,
        ];

        return $this->call('POST', 'logistics/ship_booking', [
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
     * API: v2.logistics.get_booking_shipping_document_parameter
     * Use this api to get the selectable shipping_document_type and suggested shipping_document_type for booking.
     *
     * @param  array{booking_sn: string}  $booking_list
     * @return array|mixed
     */
    public function getBookingShippingDocumentParameter($booking_list)
    {
        return $this->call('POST', 'logistics/get_booking_shipping_document_parameter', [
            RequestOptions::JSON => [
                'booking_list' => $booking_list,
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
     * API: v2.logistics.create_booking_shipping_document
     * Use this api to create shipping document task for each booking or package.
     *
     * @param array{booking_sn: string, tracking_number: string, shipping_document_type: string} $booking_list
     * @return array|mixed|string
     */
    public function createBookingShippingDocument($booking_list = [])
    {
        return $this->call('POST', 'logistics/create_booking_shipping_document', [
            RequestOptions::JSON => [
                'booking_list' => $booking_list,
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
     * API: v2.logistics.get_booking_shipping_document_result
     * Use this api to retrieve the status of the booking shipping document task.
     *
     * @param  array{booking_sn: string, shipping_document_type: string} $booking_list
     * @return array|mixed
     */
    public function getBookingShippingDocumentResult($booking_list = [])
    {
        return $this->call('POST', 'logistics/get_booking_shipping_document_result', [
            RequestOptions::JSON => [
                'booking_list' => $booking_list,
            ],
        ]);
    }

    /**
     * API: v2.logistics.download_shipping_document
     * Use this API to download the shipping document for provided orders. This API allows specifying the type of shipping document
     * and optionally saving it to a specified file path locally.
     *
     * @param  array{order_sn: string, package_number: string, tracking_number: string}  $order_list  List of orders or packages for which the shipping document is requested.
     * @param  string  $shipping_document_type  Type of the shipping document to be downloaded (e.g., invoice, label).
     * @param  string  $save_path  Optional file path to save the downloaded shipping document.
     * @return array|mixed|string
     */
    public function downloadShippingDocument($order_list = [], $shipping_document_type = '', $save_path = '')
    {
        $options = [
            RequestOptions::JSON => [
                'order_list' => $order_list,
                'shipping_document_type' => $shipping_document_type,
            ],
        ];

        if ($save_path) {
            $options[RequestOptions::SINK] = $save_path;
        }

        return $this->call('POST', 'logistics/download_shipping_document', $options);
    }

    /**
     * API: v2.logistics.download_booking_shipping_document
     * Use this API to download the shipping document for provided bookings.
     *
     * @param  array{booking_sn: string}  $booking_list
     * @param  string  $shipping_document_type
     * @param  string  $save_path
     * @return array|mixed|string
     */
    public function downloadBookingShippingDocument($booking_list = [], $shipping_document_type = '', $save_path = '')
    {
        $options = [
            RequestOptions::JSON => [
                'booking_list' => $booking_list,
                'shipping_document_type' => $shipping_document_type,
            ],
        ];

        if ($save_path) {
            $options[RequestOptions::SINK] = $save_path;
        }

        return $this->call('POST', 'logistics/download_booking_shipping_document', $options);
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
     * API: v2.logistics.get_booking_tracking_info
     * Use this api to get the logistics tracking information of a booking.
     *
     * @param  string  $booking_sn
     * @return array|mixed
     */
    public function getBookingTrackingInfo($booking_sn)
    {
        return $this->call('GET', 'logistics/get_booking_tracking_info', [
            RequestOptions::QUERY => [
                'booking_sn' => $booking_sn,
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

    /**
     * API: v2.logistics.get_booking_shipping_document_data_info
     * Use this api to fetch the logistics information of a booking.
     *
     * @param  string $booking_sn
     * @param  array $recipient_address_info
     * @return array|mixed
     */
    public function getBookingShippingDocumentDataInfo($booking_sn, $recipient_address_info = [])
    {
        return $this->call('POST', 'logistics/get_booking_shipping_document_data_info', [
            RequestOptions::JSON => [
                'booking_sn' => $booking_sn,
                'recipient_address_info' => $recipient_address_info,
            ],
        ]);
    }
}
