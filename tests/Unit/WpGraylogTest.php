<?php

namespace Exolnet\Wordpress\Graylog\Tests\Unit;

use Exolnet\Wordpress\Graylog\Exceptions\WpGraylogException;
use Exolnet\Wordpress\Graylog\WpGraylog;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Exolnet\Wordpress\Graylog\WpGraylog
 */
class WpGraylogTest extends TestCase
{
    /**
     * @var \Exolnet\Wordpress\Graylog\WpGraylog
     */
    protected $wpGraylog;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->wpGraylog = new WpGraylog();
    }

    /**
     * @return void
     */
    public function testItCanBeInitialized(): void
    {
        $this->assertInstanceOf(WpGraylog::class, $this->wpGraylog);
    }

    /**
     * @return void
     * @test
     */
    public function testItIsASingleton(): void
    {
        $instance1 = WpGraylog::instance();
        $instance2 = WpGraylog::instance();

        $this->assertInstanceOf(WpGraylog::class, $instance1);
        $this->assertEquals($instance1, $instance2);
    }

    /**
     * @return void
     */
    public function testGetChannelNameDefault(): void
    {
        $this->assertEquals(
            'graylog',
            $this->wpGraylog->getChannelName()
        );
    }

    /**
     * @return void
     */
    public function testGetGraylogTransportDefault(): void
    {
        $this->assertEquals(
            'udp',
            $this->wpGraylog->getGraylogTransport()
        );
    }

    /**
     * @return void
     */
    public function testGetGraylogHostDefault(): void
    {
        $this->assertNull(
            $this->wpGraylog->getGraylogHost()
        );
    }

    /**
     * @return void
     */
    public function testGetGraylogInitializeErrorHandler(): void
    {
        $this->assertFalse(
            $this->wpGraylog->getGraylogInitializeErrorHandler()
        );
    }

    /**
     * @return void
     */
    public function testGetGraylogPortDefault(): void
    {
        $this->assertEquals(
            12201,
            $this->wpGraylog->getGraylogPort()
        );
    }

    /**
     * @return void
     */
    public function testGetGraylogPathDefault(): void
    {
        $this->assertEquals(
            '/gelf',
            $this->wpGraylog->getGraylogPath()
        );
    }

    /**
     * @return void
     */
    public function testGetGraylogLevelDefault(): void
    {
        $this->assertEquals(
            Logger::NOTICE,
            $this->wpGraylog->getGraylogLevel()
        );
    }

    /**
     * @return void
     */
    public function testGetLoggerWithoutHostConfigured(): void
    {
        $this->expectException(WpGraylogException::class);

        $this->wpGraylog->getLogger();
    }
}
