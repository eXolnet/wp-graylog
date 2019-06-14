<?php

namespace WPLOG\Handlers;

use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Monolog\Handler\GelfHandler;
use Monolog\Logger as Monolog;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;
use Whoops\Handler\Handler;
use WPLOG\Processors\WordpressProcessor;

class MonologHandler extends Handler
{
    public function __construct()
    {
        /** Do nothing */
    }

    /**
     * @return int|void|null
     */
    public function handle()
    {
        $logChannel = defined('LOG_CHANNEL') ? LOG_CHANNEL : 'application';
        $logHost = defined('LOG_HOST') ? LOG_HOST : 'localhost';
        $logPort = defined('LOG_PORT') ? LOG_PORT : 12201;

        $exception = $this->getException();
        $monolog = new Monolog($logChannel);
        $monolog->pushHandler(
            new GelfHandler(
                new Publisher(
                    new UdpTransport(
                        $logHost,
                        $logPort
                    )
                ),
                Monolog::ERROR
            )
        );
        $monolog->pushProcessor(new IntrospectionProcessor());
        $monolog->pushProcessor(new WebProcessor());
        $monolog->pushProcessor(new MemoryUsageProcessor());
        $monolog->pushProcessor(new MemoryPeakUsageProcessor());
        $monolog->pushProcessor(new WordpressProcessor());

        $monolog->error(
            $exception->getMessage(),
            ['exception' => $exception]
        );
    }
}
