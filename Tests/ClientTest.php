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

    public function testDefaultTimeoutsAreSet()
    {
        $client = Client::getInstance('https://test.com', 'access-token', 'tenant-token');

        // Safe, non-zero defaults must be present so a request can never hang forever.
        $this->assertSame(10, $client->getConnectTimeout());
        $this->assertSame(30, $client->getTimeout());
    }

    public function testTimeoutsAreOverridableViaGetInstance()
    {
        $client = Client::getInstance('https://test.com', 'access-token', 'tenant-token', null, 3, 5);

        $this->assertSame(3, $client->getConnectTimeout());
        $this->assertSame(5, $client->getTimeout());
    }

    public function testTimeoutsAreOverridableViaSetters()
    {
        $client = Client::getInstance('https://test.com', 'access-token', 'tenant-token');
        $client->setConnectTimeout(2)->setTimeout(4);

        $this->assertSame(2, $client->getConnectTimeout());
        $this->assertSame(4, $client->getTimeout());
    }

    /**
     * A slow/unreachable upstream must surface as a catchable \Exception within the
     * configured timeout, NOT block the process indefinitely. We point at a
     * non-routable address (TEST-NET-1, RFC 5737) with a 1s connect timeout; curl
     * must give up quickly and the existing error handling must throw (HTTP code 0).
     */
    public function testSlowUpstreamThrowsWithinTimeoutInsteadOfHanging()
    {
        $client = Client::getInstance('http://192.0.2.1', 'access-token', 'tenant-token', null, 1, 1);

        $start = microtime(true);

        try {
            $client->get('/ping');
            $this->fail('Expected an exception when the upstream is unreachable.');
        } catch (\Exception $e) {
            $elapsed = microtime(true) - $start;

            // Must be a catchable \Exception (the contract's code-1 connectivity error),
            // and it must return well within a generous bound of the 1s timeout.
            $this->assertSame(1, $e->getCode());
            $this->assertLessThan(10, $elapsed, 'Request did not abort within the timeout window.');
            $this->assertSame(0, $client->getStatusCode());
        }
    }
}
