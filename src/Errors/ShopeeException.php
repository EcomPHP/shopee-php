<?php
/*
 * This file is part of shopee-php.
 *
 * (c) Jin <j@sax.vn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jekka\Shopee\Errors;

use Exception;

class ShopeeException extends Exception
{
    protected $response;

    public function __construct($message = "", $code = "", $response = "")
    {
        parent::__construct($message);

        $this->code = $code;
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
