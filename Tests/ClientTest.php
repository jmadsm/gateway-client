<?php

namespace Jma\GatewayClient\Tests;

use ReflectionProperty;
use PHPUnit\Framework\TestCase;
use JmaDsm\GatewayClient\Client;

class ClientTest extends TestCase
{
    protected function tearDown(): void
    {
        // Reset the singleton instance after each test to isolate them.
        $reflector = new ReflectionProperty(Client::class, 'instance');
        $reflector->setAccessible(true);
        $reflector->setValue(null, null);
    }

    public function testGetInstance()
    {
        $client1 = Client::getInstance('https://example.com', 'access-token', 'tenant-token');
        $client2 = Client::getInstance('https://another-example.com', 'access-token', 'tenant-token');

        // Ensure that the two calls to getInstance return the same instance.
        $this->assertSame($client1, $client2);
    }

    public function testBaseUrl()
    {
        $client = Client::getInstance('https://test.com', 'access-token', 'tenant-token');
        $client->setBaseUrl('https://example.com');
        $this->assertEquals('https://example.com', $client->getBaseUrl());
    }
}
