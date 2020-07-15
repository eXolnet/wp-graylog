<?php

namespace Exolnet\Wordpress\Graylog\Handlers;

use Exolnet\Wordpress\Graylog\Processors\WordpressProcessor;
use Exolnet\Wordpress\Graylog\Transport;
use Exolnet\Wordpress\Graylog\Transports\TransportFactory;
use Gelf\Publisher;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;

class GraylogHandler extends GelfHandler
{
    /**
     * @param \Exolnet\Wordpress\Graylog\Transport $transport
     * @param string $host
     * @param int $port
     * @param string|null $path
     * @param int $level
     */
    public function __construct(
        Transport $transport,
        string $host,
        int $port,
        ?string $path,
        $level = Logger::NOTICE
    ) {
        $transport = $this->getTransportFactory()->make($transport, $host, $port, $path);
        $publisher = new Publisher($transport);

        parent::__construct($publisher, $level, true);

        // Processors will be called in the reverse order that they are listed below
        $this->pushProcessor(new WordpressProcessor());
        $this->pushProcessor(new IntrospectionProcessor());
        $this->pushProcessor(new WebProcessor());
        $this->pushProcessor(new MemoryUsageProcessor());
        $this->pushProcessor(new MemoryPeakUsageProcessor());
    }

    /**
     * @return \Exolnet\Wordpress\Graylog\Transports\TransportFactory
     */
    protected function getTransportFactory(): TransportFactory
    {
        return new TransportFactory();
    }
}
