<?php

namespace Exolnet\Wordpress\Graylog\Tests\Unit\Handlers;

use Exolnet\Wordpress\Graylog\Handlers\GraylogHandler;
use Exolnet\Wordpress\Graylog\Severity;
use Exolnet\Wordpress\Graylog\Transport;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Exolnet\Wordpress\Graylog\Handlers\GraylogHandler
 */
class GraylogHandlerTest extends TestCase
{
    /**
     * @var \Exolnet\Wordpress\Graylog\Handlers\GraylogHandler
     */
    protected $graylogHandler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->graylogHandler = new GraylogHandler(Transport::UDP(), 'localhost', 12201, null, 'notice');
    }

    /**
     * @return void
     */
    public function testItCanBeInitialized(): void
    {
        $this->assertInstanceOf(GraylogHandler::class, $this->graylogHandler);
    }

    /**
     * @return void
     */
    public function testLevelIsCorrectlyConfigured(): void
    {
        $this->assertEquals(
            Severity::NOTICE()->getValue(),
            $this->graylogHandler->getLevel()
        );
    }
}
