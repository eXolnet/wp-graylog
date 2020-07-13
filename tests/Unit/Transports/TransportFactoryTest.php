<?php

namespace Exolnet\Wordpress\Graylog\Tests\Unit\Transports;

use Exolnet\Wordpress\Graylog\Transport;
use Exolnet\Wordpress\Graylog\Transports\TransportFactory;
use Gelf\Transport\HttpTransport;
use Gelf\Transport\TcpTransport;
use Gelf\Transport\UdpTransport;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Exolnet\Wordpress\Graylog\Transports\TransportFactory
 */
class TransportFactoryTest extends TestCase
{
    /**
     * @var \Exolnet\Wordpress\Graylog\Transports\TransportFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new TransportFactory();
    }

    /**
     * @return void
     * @test
     */
    public function testMakeUdpTransport(): void
    {
        $transport = $this->factory->make(Transport::UDP(), '127.0.0.1', 12001);

        $this->assertInstanceOf(UdpTransport::class, $transport);
    }

    /**
     * @return void
     * @test
     */
    public function testMakeTcpTransport(): void
    {
        $transport = $this->factory->make(Transport::TCP(), '127.0.0.1', 12001);

        $this->assertInstanceOf(TcpTransport::class, $transport);
    }

    /**
     * @return void
     * @test
     */
    public function testMakeSslTransport(): void
    {
        $transport = $this->factory->make(Transport::SSL(), '127.0.0.1', 12001);

        $this->assertInstanceOf(TcpTransport::class, $transport);
    }

    /**
     * @return void
     * @test
     */
    public function testMakeHttpTransport(): void
    {
        $transport = $this->factory->make(Transport::HTTP(), '127.0.0.1', 12001, '/gelf');

        $this->assertInstanceOf(HttpTransport::class, $transport);
    }

    /**
     * @return void
     * @test
     */
    public function testMakeHttpsTransport(): void
    {
        $transport = $this->factory->make(Transport::HTTPS(), '127.0.0.1', 12001, '/gelf');

        $this->assertInstanceOf(HttpTransport::class, $transport);
    }
}
