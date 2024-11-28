<?php
/*
 * This file is part of shopee-php.
 *
 * (c) Jin <j@sax.vn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jekka\Shopee;

abstract class Resource
{
    /** @var Client */
    protected $client;

    public function useApiClient(Client $client)
    {
        $this->client = $client;
    }

    public function call($method, $action, $options = [])
    {
        return $this->client->call($method, $action, $options);
    }
}
