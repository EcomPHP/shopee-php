<?php
/*
 * This file is part of shopee-php.
 *
 * (c) Jin <j@sax.vn>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NVuln\Shopee\Errors;

use Exception;

class ShopeeException extends Exception
{
    public function __construct($message = "", $code = "")
    {
        parent::__construct($message);

        $this->code = $code;
    }
}
