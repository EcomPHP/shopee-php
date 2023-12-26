<?php
/*
 * This file is part of shopee-php.
 *
 * (c) Jin <j@sax.vn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EcomPHP\Shopee;

use GuzzleHttp\Client;
use EcomPHP\Shopee\Errors\AuthorizationException;
use EcomPHP\Shopee\Errors\ShopeeException;

abstract class Resource
{
    /** @var Client */
    protected $httpClient;

    public function useHttpClient(Client $client)
    {
        $this->httpClient = $client;
    }

    public function call($method, $action, $options = [])
    {
        $response = $this->httpClient->request($method, $action, $options);
        $json = json_decode($response->getBody()->getContents(), true);
        if (is_array($json)) {
            if (isset($json['error']) && $json['error']) {
                $this->handleErrorResponse($json['error'], $json['message'], $json);
            }

            return $json['response'] ?? $json;
        }

        return $response->getBody()->getContents();
    }

    protected function handleErrorResponse($error_code, $error_message, $response)
    {
        if ($error_code == 'error_auth') {
            throw new AuthorizationException($error_message, $error_code);
        }

        throw new ShopeeException($error_message, $error_code, $response);
    }
}
