<?php

namespace Exolnet\Wordpress\Graylog\Tests\Unit\Handlers;

use Exolnet\Wordpress\Graylog\Handlers\GraylogHandler;
use PHPUnit\Framework\TestCase;

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

        $this->graylogHandler = new GraylogHandler('localhost');
    }


    /**
     * @return void
     */
    public function testItCanBeInitialized(): void
    {
        $this->assertInstanceOf(GraylogHandler::class, $this->graylogHandler);
    }
}
