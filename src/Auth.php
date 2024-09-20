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

class Auth
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Use the code and shop_id or main_account_id from the authorization step to obtain access_token and refresh_token
     *
     * @param $code
     * @param $shop_id
     * @return mixed
     */
    public function getToken($code, $shop_id)
    {
        return $this->client->Authorization->getToken($code, $shop_id, $this->client->partnerId());
    }

    /**
     * refresh the access_token after it expires.
     * refresh_token can be used once only, this API will also return a new refresh_token.
     * Please use the new refresh_token for the next refreshNewToken call
     *
     * @param $refresh_token
     * @param $shop_id
     * @return mixed
     */
    public function refreshNewToken($refresh_token, $shop_id)
    {
        return $this->client->Authorization->refreshNewToken($refresh_token, $shop_id, $this->client->partnerId());
    }

    public function createAuthRequest($redirect_uri, $return_url = false)
    {
        $query = [
            'partner_id' => $this->client->partnerId(),
            'redirect' => $redirect_uri,
        ];
        $this->client->prepareSignature('/api/v2/shop/auth_partner', $query);

        $authorizationUrl = $this->client->baseUrl() . 'shop/auth_partner?' . http_build_query($query);

        if ($return_url) {
            return $authorizationUrl;
        }

        header('Location: '.$authorizationUrl);
        exit;
    }
}
