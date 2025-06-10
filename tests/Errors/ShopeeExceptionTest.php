<?php

namespace EcomPHP\Shopee\Tests\Errors;

use EcomPHP\Shopee\Errors\ShopeeException;
use PHPUnit\Framework\TestCase;

class ShopeeExceptionTest extends TestCase
{
    public function testConstructor()
    {
        $message = 'Test error message';
        $code = 'ERROR_CODE';
        $response = ['error' => true, 'message' => 'Test error message'];
        
        $exception = new ShopeeException($message, $code, $response);
        
        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
        $this->assertEquals($response, $exception->getResponse());
    }
    
    public function testGetResponse()
    {
        $response = ['error' => true, 'message' => 'Test error message'];
        $exception = new ShopeeException('Test error message', 'ERROR_CODE', $response);
        
        $this->assertEquals($response, $exception->getResponse());
    }
    
    public function testDefaultValues()
    {
        $exception = new ShopeeException();
        
        $this->assertEquals('', $exception->getMessage());
        $this->assertEquals('', $exception->getCode());
        $this->assertEquals('', $exception->getResponse());
    }
}
