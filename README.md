# Shopee API PHP SDK — Modern PHP Client for Shopee Open Platform v2

[![Total Downloads](https://poser.pugx.org/ecomphp/shopee-php/downloads)](https://packagist.org/packages/ecomphp/shopee-php) 
[![Latest Stable Version](https://poser.pugx.org/ecomphp/shopee-php/v/stable)](https://packagist.org/packages/ecomphp/shopee-php) 
[![Latest Unstable Version](https://poser.pugx.org/ecomphp/shopee-php/v/unstable)](https://packagist.org/packages/ecomphp/shopee-php)
[![Build Status](https://img.shields.io/github/actions/workflow/status/ecomphp/shopee-php/ci.yml?branch=master&label=ci%20build&style=flat-square)](https://github.com/ecomphp/shopee-php/actions?query=workflow%3ATest)
[![License](https://poser.pugx.org/ecomphp/shopee-php/license)](https://packagist.org/packages/ecomphp/shopee-php)

A powerful, lightweight, and developer-friendly **Shopee API PHP SDK** designed to integrate **Shopee Open Platform v2** into vanilla PHP applications, Laravel, or Symfony projects. 

Easily manage Shopee OAuth2 authentication, automate access token generation, sync products, and fetch orders with minimal configuration.

---

## 📦 Installation

Install the **Shopee PHP Client** via [Composer](https://getcomposer.org/):

```shell
composer require ecomphp/shopee-php
```

---

## 🛠️ Configuration & Setup

Initialize the **Shopee Client** using your partner credentials provided by the Shopee Open Platform Console:

```php
use EcomPHP\Shopee\Client;

$partner_id = 'your_partner_id_here';
$partner_key = 'your_partner_key_here';

$client = new Client($partner_id, $partner_key);
```

---

## 🔐 Shopee API OAuth2 Authentication (Grant Token)

The SDK provides a dedicated `Auth` class to seamlessly handle Shopee's OAuth2 login mechanism, access tokens, and refresh tokens.

```php
$auth = $client->auth();
```

### Step 1: Create the Authentication Request URL

Generate the authorization redirect URL for the shop owner to grant permissions:

```php
$redirect_uri = 'http://your-redirect-url.com';

// Returns the Shopee authentication URL instead of auto-redirecting
$authUrl = $auth->createAuthRequest($redirect_uri, true);

// Redirect user to Shopee Authorization page
header('Location: ' . $authUrl);
exit;
```

### Step 2: Handle Redirect Callback & Fetch Access Token

Once authorized, Shopee redirects the user back to your `Redirect URI` with an authorization code. Exchange it for your API tokens:

```php
$authorization_code = $_GET['code'];
$shop_id = $_GET['shop_id'];

// Exchange code for Access Token & Refresh Token
$token = $auth->getToken($authorization_code, $shop_id);

$access_token = $token['access_token'];
$refresh_token = $token['refresh_token'];

// IMPORTANT: Save your access_token, refresh_token & shop_id to your database for later use
```

### Step 3: Set Authorized Shop Credentials

To make authorized calls on behalf of a specific shop, attach the token to your client instance:

```php
$access_token = 'your_stored_access_token';
$shop_id = 'your_stored_shop_id';

$client->setAccessToken($shop_id, $access_token);
```

---

## 🔄 Refreshing Expired Access Tokens

Shopee access tokens expire quickly. Automate token renewal using your persistent `refresh_token`:

```php
$new_token = $auth->refreshNewToken($refresh_token, $shop_id);

$new_access_token = $new_token['access_token'];
$new_refresh_token = $new_token['refresh_token'];
```

---

## 🚀 Shopee API Usage Examples

> **Note:** A valid `access_token` and `shop_id` are required to interact with store-level data.

### 1. Get Product Item List

Fetch product details and stock information from your store. Refer to the official [Shopee Product API Document](https://open.shopee.com/documents/v2/v2.product.get_item_list?module=89&type=1).

```php
$products = $client->Product->getItemList([
    'offset' => 0,
    'page_size' => 50,
    'item_status' => 'NORMAL',
]);
```

### 2. Get Order List & Order Management

Retrieve recent sales and pending orders. Refer to the official [Shopee Order API Document](https://open.shopee.com/documents/v2/v2.order.get_order_list?module=94&type=1).

```php
$orders = $client->Order->getOrderList([
    'order_status' => 'READY_TO_SHIP',
    'page_size' => 50,
]);
```

---

## 🤝 Contributing

Contributions, feature suggestions, and bug reports for the **ecomphp/shopee-php** client are highly appreciated. Feel free to open issues or submit Pull Requests!

## 📄 License

This project is open-source software licensed under the [Apache License 2.0](LICENSE).
