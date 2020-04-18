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
    public function testGetGraylogLevelDefault(): void
    {
        $this->assertNull(
            $this->wpGraylog->getGraylogLevel()
        );
    }

    /**
     * @return void
     */
    public function testGetGraylogPortDefault(): void
    {
        $this->assertNull(
            $this->wpGraylog->getGraylogPort()
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
