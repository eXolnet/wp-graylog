<?php

namespace Exolnet\Wordpress\Graylog\Handlers;

use Exolnet\Wordpress\Graylog\Processors\WordpressProcessor;
use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;

class GraylogHandler extends GelfHandler
{
    /**
     * @param string $host
     * @param int $port
     * @param int $level
     * @param array $extra
     */
    public function __construct(string $host, int $port, $level = Logger::NOTICE)
    {
        $transport = new UdpTransport($host, $port);
        $publisher = new Publisher($transport);

        parent::__construct($publisher, $level, true);

        // Processors will be called in the reverse order that they are listed below
        $this->pushProcessor(new WordpressProcessor());
        $this->pushProcessor(new IntrospectionProcessor());
        $this->pushProcessor(new WebProcessor());
        $this->pushProcessor(new MemoryUsageProcessor());
        $this->pushProcessor(new MemoryPeakUsageProcessor());
    }
}
