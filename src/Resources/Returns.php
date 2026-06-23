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

class Returns extends Resource
{
    /**
     * API: v2.returns.get_return_detail
     * Use this api to get detail information of a return by return sn.
     */
    public function getReturnDetail($return_sn)
    {
        return $this->call('GET', 'returns/get_return_detail', [
            RequestOptions::QUERY => [
                'return_sn' => $return_sn,
            ]
        ]);
    }

    /**
     * API: v2.returns.get_return_list
     * Use this api to get detail information of many return by shop id.
     */
    public function getReturnList($params = [])
    {
        return $this->call('GET', 'returns/get_return_list', [
            RequestOptions::QUERY => array_merge([
                'page_no' => 1,
                'page_size' => 50,
            ], $params)
        ]);
    }

    /**
     * API: v2.returns.confirm
     * Confirm refund
     */
    public function confirm($return_sn)
    {
        return $this->call('POST', 'returns/confirm', [
            RequestOptions::JSON => [
                'return_sn' => $return_sn,
            ]
        ]);
    }

    /**
     * API: v2.returns.dispute
     * Dispute return.
     * 
     * Support to raise dispute when return_status in REQUESTED / PROCESSING/ACCEPTED
     */
    public function dispute($return_sn, $email, $extra_params = [])
    {
        $extra_params['return_sn'] = $return_sn;
        $extra_params['email'] = $email;

        return $this->call('POST', 'returns/dispute', [
            RequestOptions::JSON => $extra_params,
        ]);
    }

    /**
     * API: v2.returns.get_available_solutions
     * Get the available solutions offered to buyers.
     */
    public function getAvailableSolutions($return_sn)
    {
        return $this->call('GET', 'returns/get_available_solutions', [
            RequestOptions::QUERY => [
                'return_sn' => $return_sn,
            ]
        ]);
    }

    /**
     * API: v2.returns.offer
     * v2.returns.offer
     */
    public function offer($return_sn, $proposed_solution, $proposed_adjusted_refund_amount = null)
    {
        $params = [
            'return_sn' => $return_sn,
            'proposed_solution' => $proposed_solution,
        ];

        if ($proposed_adjusted_refund_amount) {
            $params['proposed_adjusted_refund_amount'] = $proposed_adjusted_refund_amount;
        }

        return $this->call('POST', 'returns/offer', [
            RequestOptions::JSON => $params,
        ]);
    }

    /**
     * API: v2.returns.accept_offer
     * v2.returns.accept_offer
     */
    public function acceptOffer($return_sn)
    {
        return $this->call('POST', 'returns/accept_offer', [
            RequestOptions::JSON => [
                'return_sn' => $return_sn,
            ],
        ]);
    }

    /**
     * API: v2.returns.convert_image
     * Convert a specific format and pictures within 10M into url.
     */
    public function convertImage($return_sn, $upload_image)
    {
        return $this->call('POST', 'returns/convert_image', [
            RequestOptions::QUERY => [
                'return_sn' => $return_sn,
            ],
            RequestOptions::MULTIPART => [
                [
                    'name' => 'upload_image',
                    'contents' => fopen($upload_image, 'r'),
                ]
            ],
        ]);
    }

    /**
     * API: v2.returns.upload_proof
     * Support sellers to upload evidence, including text and pictures and videos converted into URLs.
     */
    public function uploadProof($return_sn, $photo, $description = '')
    {
        return $this->call('POST', 'returns/upload_proof', [
            RequestOptions::JSON => [
                'return_sn' => $return_sn,
                'photo' => $photo,
                'description' => $description,
            ]
        ]);
    }

    /**
     * API: v2.returns.query_proof
     * Support sellers to query the evidence uploaded through the upload evidence API.
     */
    public function queryProof($return_sn)
    {
        return $this->call('GET', 'returns/query_proof', [
            RequestOptions::QUERY => [
                'return_sn' => $return_sn,
            ]
        ]);
    }

    /**
     * API: v2.returns.get_return_dispute_reason
     * To get the dispute return reason.
     */
    public function getReturnDisputeReason($return_sn)
    {
        return $this->call('GET', 'returns/get_return_dispute_reason', [
            RequestOptions::QUERY => [
                'return_sn' => $return_sn,
            ]
        ]);
    }
}
