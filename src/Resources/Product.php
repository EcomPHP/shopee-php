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
    public function getCategory($params = [])
    {
        return $this->call('GET', 'product/get_category', [
            RequestOptions::QUERY => $params,
        ]);
    }

    public function getAttributes($category_id, $language = null)
    {
        $params = [
            'category_id' => $category_id,
        ];

        if ($language) {
            $params['language'] = $language;
        }

        return $this->call('GET', 'product/get_attributes', [
            RequestOptions::QUERY => $params,
        ]);
    }

    public function getAttributeTree($category_id_list, $language = null)
    {
        $params = [
            'category_id_list' => implode(',', is_array($category_id_list) ? $category_id_list : [$category_id_list]),
        ];

        if ($language) {
            $params['language'] = $language;
        }

        return $this->call('GET', 'product/get_attribute_tree', [
            RequestOptions::QUERY => $params,
        ]);
    }

    public function getBrandList($category_id, $params = [])
    {
        $params = array_merge([
            'offset' => 0,
            'page_size' => 10,
            'status' => 1,
        ], $params);

        $params['category_id'] = $category_id;

        return $this->call('GET', 'product/get_brand_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    public function getModelList($item_id)
    {
        return $this->call('GET', 'product/get_model_list', [
            RequestOptions::QUERY => [
                'item_id' => $item_id
            ],
        ]);
    }

    public function getItemList($params = [])
    {
        // if you want to search multiple item status, please pass params as string, pass an array will be serialized by the http_build_query function and it may skip duplicate params
        // ex: offset=0&page_size=20&item_status=NORMAL&item_status=BANNED
        if (is_array($params) || !$params) {
            $params = array_merge([
                'offset' => 0,
                'page_size' => 20,
                'item_status' => 'NORMAL',
            ], $params);
        }

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

    public function addItem($params)
    {
        return $this->call('POST', 'product/add_item', [
            RequestOptions::JSON => $params,
        ]);
    }

    public function updateItem($item_id, $params = [])
    {
        $params['item_id'] = $item_id;

        return $this->call('POST', 'product/update_item', [
            RequestOptions::JSON => $params,
        ]);
    }

    public function deleteItem($item_id)
    {
        return $this->call('POST', 'product/delete_item', [
            RequestOptions::JSON => [
                'item_id' => $item_id,
            ],
        ]);
    }

    public function initTierVariation($item_id, $tier_variation, $model)
    {
        $params = [
            'item_id' => $item_id,
            'tier_variation' => $tier_variation,
            'model' => $model,
        ];

        return $this->call('POST', 'product/init_tier_variation', [
            RequestOptions::JSON => $params,
        ]);
    }

    public function updateTierVariation($item_id, $tier_variation, $model_list)
    {
        $params = [
            'item_id' => $item_id,
            'tier_variation' => $tier_variation,
            'model_list' => $model_list,
        ];

        return $this->call('POST', 'product/update_tier_variation', [
            RequestOptions::JSON => $params,
        ]);
    }

    public function addModel($item_id, $model_list)
    {
        $params = [
            'item_id' => $item_id,
            'model_list' => $model_list,
        ];

        return $this->call('POST', 'product/add_model', [
            RequestOptions::JSON => $params,
        ]);
    }
}
