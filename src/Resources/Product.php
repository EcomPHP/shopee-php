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

class Product extends Resource
{
    public function getModelList($item_id)
    {
        return $this->call('GET', 'product/get_model_list', [
            RequestOptions::QUERY => [
                'item_id' => $item_id
            ],
        ]);
    }

    public function getItemList($params)
    {
        $params = array_merge([
            'offset' => 0,
            'page_size' => 20,
            'item_status' => 'NORMAL',
        ], $params);

        return $this->call('GET', 'product/get_item_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    public function getItemBaseInfo($item_id_list, $need_tax_info = false, $need_complaint_policy = false)
    {
        $params = [
            'item_id_list' => implode(',', is_array($item_id_list) ? $item_id_list : [$item_id_list]),
            'need_tax_info' => boolval($need_tax_info),
            'need_complaint_policy' => boolval($need_complaint_policy),
        ];

        return $this->call('GET', 'product/get_item_base_info', [
            RequestOptions::QUERY => $params,
        ]);
    }

    public function boostItem($item_id_list)
    {
        $params = [
            'item_id_list' => is_array($item_id_list) ? $item_id_list : [$item_id_list],
        ];

        return $this->call('POST', 'product/boost_item', [
            RequestOptions::JSON => $params,
        ]);
    }

    public function getBoostedList()
    {
        return $this->call('GET', 'product/get_boosted_list');
    }

    public function getComment($params = [])
    {
        $params = array_merge([
            'cursor' => '',
            'page_size' => 20,
        ], $params);

        return $this->call('GET', 'product/get_comment', [
            RequestOptions::QUERY => $params,
        ]);
    }

    public function replyComment($comment_id, $comment)
    {
        return $this->call('POST', 'product/reply_comment', [
            RequestOptions::JSON => [
                'comment_list' => [
                    [
                        'comment_id' => $comment_id,
                        'comment' => $comment,
                    ]
                ]
            ]
        ]);
    }
}
