<?php

namespace Exolnet\Wordpress\Graylog\Tests\Unit\Handlers;

use Exolnet\Wordpress\Graylog\Handlers\ErrorHandler;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;

/**
 * @covers \Exolnet\Wordpress\Graylog\Handlers\ErrorHandler
 */
class ErrorHandlerTest extends TestCase
{
    /**
     * @var \Exolnet\Wordpress\Graylog\Handlers\ErrorHandler
     */
    protected $errorHandler;

    /**
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|\Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->logger = m::mock(LoggerInterface::class);
        $this->errorHandler = new ErrorHandler($this->logger);
    }

    /**
     * @return void
     */
    public function testItCanBeInitialized(): void
    {
        $this->assertInstanceOf(ErrorHandler::class, $this->errorHandler);
    }

    /**
     * @return void
     * @test
     * @throws \Throwable
     */
    public function testWpHandleException(): void
    {
        $exception = m::mock(RuntimeException::class);

        $this->logger->shouldReceive('log')->once();

        $this->expectExceptionObject($exception);

        $this->errorHandler->wpHandleException($exception);
    }

    /**
     * @return void
     * @test
     * @throws \Throwable
     */
    public function testWpHandleExceptionWithExceptionWhileLogging(): void
    {
        $exception1 = m::mock(RuntimeException::class);
        $exception2 = m::mock(RuntimeException::class);

        $this->logger->shouldReceive('log')->once()->andThrow($exception2);

        $this->expectExceptionObject($exception2);

        $this->errorHandler->wpHandleException($exception1);
    }
}
