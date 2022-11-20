<?php
/*
 * This file is part of shopee-php.
 *
 * (c) Jin <j@sax.vn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NVuln\Shopee;

use GuzzleHttp\Client;
use NVuln\Shopee\Errors\AuthorizationException;
use NVuln\Shopee\Errors\ShopeeException;

abstract class Resource
{
    protected $httpClient;

    protected $prefix = '';

    public function useHttpClient(Client $client)
    {
        $this->httpClient = $client;
    }

    public function call($method, $action, $options = [])
    {
        $response = $this->httpClient->request($method, $this->prefix.'/'.$action, $options);
        $json = json_decode($response->getBody()->getContents(), true);
        if (is_array($json)) {
            if (isset($json['error']) && $json['error']) {
                $this->handleErrorResponse($json['error'], $json['message']);
            }

            return $json['response'] ?? $json;
        }

        return $response->getBody()->getContents();
    }

    protected function handleErrorResponse($error_code, $error_message)
    {
        if ($error_code == 'error_auth') {
            throw new AuthorizationException($error_message, $error_code);
        }

        throw new ShopeeException($error_message, $error_code);
    }
}
