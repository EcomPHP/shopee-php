<?php

namespace EcomPHP\Shopee\Tests\Errors;

use EcomPHP\Shopee\Errors\AuthorizationException;
use EcomPHP\Shopee\Errors\ShopeeException;
use PHPUnit\Framework\TestCase;

class AuthorizationExceptionTest extends TestCase
{
    public function testIsInstanceOfShopeeException()
    {
        $exception = new AuthorizationException('Authorization failed', 'AUTH_ERROR');
        
        $this->assertInstanceOf(ShopeeException::class, $exception);
    }
    
    public function testConstructor()
    {
        $message = 'Authorization failed';
        $code = 'AUTH_ERROR';
        $response = ['error' => true, 'message' => 'Authorization failed'];
        
        $exception = new AuthorizationException($message, $code, $response);
        
        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
        $this->assertEquals($response, $exception->getResponse());
    }
    
    public function testInheritedGetResponseMethod()
    {
        $response = ['error' => true, 'message' => 'Authorization failed'];
        $exception = new AuthorizationException('Authorization failed', 'AUTH_ERROR', $response);
        
        $this->assertEquals($response, $exception->getResponse());
    }
}
