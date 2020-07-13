<?php

namespace Exolnet\Wordpress\Graylog\Transports;

use Exolnet\Wordpress\Graylog\Transport;
use Gelf\Transport\HttpTransport;
use Gelf\Transport\SslOptions;
use Gelf\Transport\TcpTransport;
use Gelf\Transport\UdpTransport;
use InvalidArgumentException;

class TransportFactory
{
    /**
     * @param \Exolnet\Wordpress\Graylog\Transport $transport
     * @param string $host
     * @param int $port
     * @param string|null $path
     * @return \Gelf\Transport\TransportInterface
     * @throws \InvalidArgumentException
     */
    public function make(Transport $transport, string $host, int $port, ?string $path = null)
    {
        if ($transport->equals(Transport::UDP())) {
            return $this->makeUdpTransport($host, $port);
        }

        if ($transport->equals(Transport::TCP())) {
            return $this->makeTcpTransport($host, $port);
        }

        if ($transport->equals(Transport::SSL())) {
            return $this->makeSslTransport($host, $port);
        }

        if ($transport->equals(Transport::HTTP())) {
            return $this->makeHttpTransport($host, $port, $path);
        }

        if ($transport->equals(Transport::HTTPS())) {
            return $this->makeHttpsTransport($host, $port, $path);
        }

        throw new InvalidArgumentException("Transport [{$transport}] is not supported.");
    }

    /**
     * @param string $host
     * @param int|null $port
     * @return \Gelf\Transport\UdpTransport
     */
    protected static function makeUdpTransport(string $host, int $port): UdpTransport
    {
        return new UdpTransport($host, $port);
    }

    /**
     * @param string $host
     * @param int|null $port
     * @return \Gelf\Transport\TcpTransport
     */
    protected static function makeTcpTransport(string $host, int $port): TcpTransport
    {
        return new TcpTransport($host, $port);
    }

    /**
     * @param string $host
     * @param int|null $port
     * @return \Gelf\Transport\TcpTransport
     */
    protected static function makeSslTransport(string $host, int $port): TcpTransport
    {
        return new TcpTransport($host, $port, new SslOptions());
    }

    /**
     * @param string $host
     * @param int|null $port
     * @param string|null $path
     * @return \Gelf\Transport\HttpTransport
     */
    protected static function makeHttpTransport(string $host, int $port, ?string $path): HttpTransport
    {
        return new HttpTransport($host, $port, $path ?? HttpTransport::DEFAULT_PATH);
    }

    /**
     * @param string $host
     * @param int|null $port
     * @param string|null $path
     * @return \Gelf\Transport\HttpTransport
     */
    protected static function makeHttpsTransport(string $host, int $port, ?string $path): HttpTransport
    {
        return new HttpTransport($host, $port, $path ?? HttpTransport::DEFAULT_PATH, new SslOptions());
    }
}
