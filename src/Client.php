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

use EcomPHP\Shopee\Errors\AuthorizationException;
use EcomPHP\Shopee\Resources\AccountHealth;
use EcomPHP\Shopee\Resources\AddOnDeal;
use EcomPHP\Shopee\Resources\Ads;
use EcomPHP\Shopee\Resources\BundleDeal;
use EcomPHP\Shopee\Resources\Chat;
use EcomPHP\Shopee\Resources\Discount;
use EcomPHP\Shopee\Resources\FirstMile;
use EcomPHP\Shopee\Resources\FollowPrize;
use EcomPHP\Shopee\Resources\MediaSpace;
use EcomPHP\Shopee\Resources\Merchant;
use EcomPHP\Shopee\Resources\Push;
use EcomPHP\Shopee\Resources\Returns;
use EcomPHP\Shopee\Resources\ShopCategory;
use EcomPHP\Shopee\Resources\ShopFlashSale;
use EcomPHP\Shopee\Resources\TopPicks;
use EcomPHP\Shopee\Resources\Voucher;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use EcomPHP\Shopee\Errors\ShopeeException;
use EcomPHP\Shopee\Resources\Authorization;
use EcomPHP\Shopee\Resources\Logistic;
use EcomPHP\Shopee\Resources\Order;
use EcomPHP\Shopee\Resources\Payment;
use EcomPHP\Shopee\Resources\Product;
use EcomPHP\Shopee\Resources\Shop;
use Psr\Http\Message\RequestInterface;

/**
 * @property-read Ads $Ads
 * @property-read Authorization $Authorization
 * @property-read AccountHealth $AccountHealth
 * @property-read Chat $Chat
 * @property-read Logistic $Logistic
 * @property-read Order $Order
 * @property-read Payment $Payment
 * @property-read Product $Product
 * @property-read Shop $Shop
 * @property-read FirstMile $FirstMile
 * @property-read Discount $Discount
 * @property-read BundleDeal $BundleDeal
 * @property-read AddOnDeal $AddOnDeal
 * @property-read Voucher $Voucher
 * @property-read FollowPrize $FollowPrize
 * @property-read TopPicks $TopPicks
 * @property-read ShopCategory $ShopCategory
 * @property-read Returns $Returns
 * @property-read MediaSpace $MediaSpace
 * @property-read Merchant $Merchant
 * @property-read Push $Push
 * @property-read ShopFlashSale $ShopFlashSale
 */
class Client
{
    protected $resources = [
        Ads::class,
        Authorization::class,
        AccountHealth::class,
        Chat::class,
        Logistic::class,
        Order::class,
        Payment::class,
        Product::class,
        Shop::class,
        FirstMile::class,
        Discount::class,
        BundleDeal::class,
        AddOnDeal::class,
        Voucher::class,
        FollowPrize::class,
        TopPicks::class,
        ShopCategory::class,
        Returns::class,
        MediaSpace::class,
        Merchant::class,
        Push::class,
        ShopFlashSale::class,
    ];

    protected $partner_id;
    protected $partner_key;
    protected $debug_mode = false;
    protected $shop_id;
    protected $access_token;

    protected $china_region = false;
    protected $brazil_region = false;

    public function __construct($partner_id, $partner_key)
    {
        $this->partner_id = intval($partner_id);
        $this->partner_key = $partner_key;
    }

    public function useDebugMode()
    {
        $this->debug_mode = true;
    }

    public function useChinaRegion()
    {
        $this->china_region = true;
        $this->brazil_region = false;
    }

    public function useBrazilRegion()
    {
        $this->brazil_region = true;
        $this->china_region = false;
    }

    public function setAccessToken($shop_id, $access_token)
    {
        $this->shop_id = intval($shop_id);
        $this->access_token = $access_token;
    }

    public function partnerId()
    {
        return $this->partner_id;
    }

    public function partnerKey()
    {
        return $this->partner_key;
    }

    public function auth()
    {
        return new Auth($this);
    }
    /**
     * Magic call resource
     *
     * @param $resourceName
     * @throws \Exception
     * @return mixed
     */
    public function __get($resourceName)
    {
        $resourceClassName = __NAMESPACE__."\\Resources\\".$resourceName;
        if (!in_array($resourceClassName, $this->resources)) {
            $resourceClassName = null;
            foreach ($this->resources as $resource) {
                // skip class in resources folder
                if (strpos($resource, __NAMESPACE__."\\Resources\\") === 0) {
                    continue;
                }

                // find external resource
                $lookup = "\\".$resourceName;
                if (0 === substr_compare($resource, $lookup, - strlen($lookup))) {
                    $resourceClassName = $resource;
                    break;
                }
            }
        }

        if ($resourceClassName === null) {
            throw new ShopeeException("Invalid resource ".$resourceName);
        }

        //Initiate the resource object
        /** @var \EcomPHP\Shopee\Resource $resource */
        $resource = new $resourceClassName();
        if (!$resource instanceof Resource) {
            throw new ShopeeException("Invalid resource object ".$resourceName);
        }

        $resource->useApiClient($this);

        return $resource;
    }

    public function httpClient()
    {
        $stack = HandlerStack::create();
        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
            $uri = $request->getUri();
            parse_str($uri->getQuery(), $query);
            $query['partner_id'] = $this->partnerId();

            if ($this->access_token) {
                $query['access_token'] = $this->access_token;
            }

            if ($this->shop_id) {
                $query['shop_id'] = $this->shop_id;
            }
            $this->prepareSignature($uri->getPath(), $query);

            $uri = $uri->withQuery(http_build_query($query));
            return $request->withUri($uri);
        }));

        return new GuzzleHttpClient([
            'handler' => $stack,
            'base_uri' => $this->baseUrl(),
            RequestOptions::HTTP_ERRORS => false,
        ]);
    }

    public function call($method, $api, $options = [])
    {
        // trim prefix api/v2/
        $api = trim($api, '/');
        if (strpos($api, 'api/v2/') === 0) {
            $api = substr($api, 7);
        }

        $response = $this->httpClient()->request($method, $api, $options);
        $body = $response->getBody()->getContents();

        $json = json_decode($body, true);
        if (is_array($json)) {
            if (isset($json['error']) && $json['error']) {
                $this->handleErrorResponse($json['error'], $json['message'] ?? null, $json);
            }

            return $json['response'] ?? $json;
        }

        return $body;
    }

    protected function handleErrorResponse($error_code, $error_message, $response)
    {
        if ($error_code == 'error_auth') {
            throw new AuthorizationException($error_message, $error_code);
        }

        throw new ShopeeException($error_message, $error_code, $response);
    }

    public function validatePushMechanismRequest($webhook_receive_url = null, $throw = true)
    {
        if (!$webhook_receive_url) {
            $webhook_receive_url = sprintf('%s://%s%s', empty($_SERVER['HTTPS']) ? 'http' : 'https', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']);
        }

        $stringToBeSigned = $webhook_receive_url . '|' . file_get_contents('php://input');
        $sign = hash_hmac('sha256', $stringToBeSigned, $this->partnerKey());

        $isValid = hash_equals($_SERVER['HTTP_AUTHORIZATION'], $sign);
        if (!$isValid && $throw) {
            throw new ShopeeException("Invalid signature");
        }

        return $isValid;
    }

    public function prepareSignature($path, &$query)
    {
        // remove access_token and shop_id on auth request
        if (preg_match('/^\/api\/v2\/auth\/(access_)?token\/get$/', $path)) {
            unset($query['access_token'], $query['shop_id']);
        }

        $query = array_merge([
            'timestamp' => time(),
            'access_token' => '',
            'shop_id' => '',
        ], $query);

        $stringToBeSigned = $this->partnerId().  $path . $query['timestamp'] . $query['access_token'] . $query['shop_id'];
        $query['sign'] = hash_hmac('sha256', $stringToBeSigned, $this->partnerKey());
    }

    public function baseUrl()
    {
        switch (($this->brazil_region << 2) + ($this->china_region << 1) + $this->debug_mode) {
            case 1:
                return 'https://partner.test-stable.shopeemobile.com/api/v2/';
            case 2:
                return 'https://openplatform.shopee.cn/api/v2/';
            case 3:
                return 'https://openplatform.test-stable.shopee.cn/api/v2/';
            case 4:
                return 'https://openplatform.shopee.com.br/api/v2/';
            case 5:
                return 'https://openplatform.test-stable.shopee.com.br/api/v2/';
            case 0:
            default:
                return 'https://partner.shopeemobile.com/api/v2/';
        }
    }
}
