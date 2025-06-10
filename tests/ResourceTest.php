<?php

namespace EcomPHP\Shopee\Tests;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resource;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Resource
     */
    private $resource;
    
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;
    
    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        
        // Create a mock of the abstract Resource class
        $this->resource = $this->getMockForAbstractClass(Resource::class);
    }
    
    public function testUseApiClient()
    {
        $this->resource->useApiClient($this->client);
        
        // Use reflection to check if the client property was set correctly
        $reflectionClass = new \ReflectionClass(Resource::class);
        $property = $reflectionClass->getProperty('client');
        $property->setAccessible(true);
        
        $this->assertSame($this->client, $property->getValue($this->resource));
    }
    
    public function testCall()
    {
        $method = 'GET';
        $action = 'test/endpoint';
        $options = ['option1' => 'value1'];
        $expectedResponse = ['success' => true];
        
        // Set up the client mock to expect a call to the call method
        $this->client->expects($this->once())
            ->method('call')
            ->with($method, $action, $options)
            ->willReturn($expectedResponse);
        
        // Set the client on the resource
        $this->resource->useApiClient($this->client);
        
        // Call the method and check the result
        $result = $this->resource->call($method, $action, $options);
        
        $this->assertEquals($expectedResponse, $result);
    }
}
