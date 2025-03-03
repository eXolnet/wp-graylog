<?php

namespace Exolnet\Wordpress\Graylog;

use Exolnet\Wordpress\Graylog\Exceptions\WpGraylogException;
use Exolnet\Wordpress\Graylog\Handlers\ErrorHandler;
use Exolnet\Wordpress\Graylog\Handlers\GraylogHandler;
use Gelf\Transport\HttpTransport;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use Throwable;

class WpGraylog
{
    /**
     * @var string
     */
    public const DEFAULT_TRANSPORT = 'udp';

    /**
     * @var int
     */
    public const DEFAULT_PORT = 12201;

    /**
     * @var string
     */
    public const DEFAULT_PATH = HttpTransport::DEFAULT_PATH;

    /**
     * @var string
     */
    public const DEFAULT_LEVEL = Logger::NOTICE;

    /**
     * @var string
     */
    public const CHANNEL_NAME_FALLBACK = 'graylog';

    /**
     * @var static
     */
    protected static $instance;

    /**
     * @var \Monolog\Logger
     */
    protected $logger;

    /**
     * @return string
     */
    public function getChannelName(): string
    {
        return defined('GRAYLOG_CHANNEL') && GRAYLOG_CHANNEL ? GRAYLOG_CHANNEL : static::CHANNEL_NAME_FALLBACK;
    }

    /**
     * @return \Exolnet\Wordpress\Graylog\Transport
     */
    public function getGraylogTransport(): Transport
    {
        return new Transport(
            defined('GRAYLOG_TRANSPORT') && GRAYLOG_TRANSPORT ? GRAYLOG_TRANSPORT : static::DEFAULT_TRANSPORT
        );
    }

    /**
     * @return string|null
     */
    public function getGraylogHost(): ?string
    {
        return defined('GRAYLOG_HOST') && GRAYLOG_HOST ? GRAYLOG_HOST : null;
    }

    /**
     * @return bool
     */
    public function getGraylogInitializeErrorHandler(): bool
    {
        if (defined('GRAYLOG_INITIALIZE_ERROR_HANDLER')) {
            return (bool)GRAYLOG_INITIALIZE_ERROR_HANDLER;
        }

        return $this->getGraylogHost() !== null;
    }

    /**
     * @return int
     */
    public function getGraylogPort(): int
    {
        return defined('GRAYLOG_PORT') && GRAYLOG_PORT ? (int)GRAYLOG_PORT : static::DEFAULT_PORT;
    }

    /**
     * @return string
     */
    public function getGraylogPath(): string
    {
        return defined('GRAYLOG_PATH') && GRAYLOG_PATH ? GRAYLOG_PATH : static::DEFAULT_PATH;
    }

    /**
     * @return string
     */
    public function getGraylogLevel(): string
    {
        return defined('GRAYLOG_LEVEL') && GRAYLOG_LEVEL ? GRAYLOG_LEVEL : static::DEFAULT_LEVEL;
    }

    /**
     * @return \Monolog\Logger
     */
    public function getLogger(): Logger
    {
        if (! $this->logger) {
            $this->logger = $this->makeLogger();
        }

        return $this->logger;
    }

    /**
     * @param string $message
     * @param \Exolnet\Wordpress\Graylog\Severity|null $severity
     * @param array $context
     * @return void
     */
    public function captureMessage(string $message, ?Severity $severity = null, array $context = []): void
    {
        $level = ($severity ?? Severity::NOTICE())->getValue();

        $this->getLogger()->log($level, $message, $context);
    }

    /**
     * @param \Throwable $exception
     * @return void
     */
    public function captureException(Throwable $exception): void
    {
        $this->captureMessage($exception->getMessage(), Severity::ERROR(), [
            'exception' => $exception,
        ]);
    }

    /**
     * @return void
     */
    public function captureLastError(): void
    {
        if (! $error = error_get_last()) {
            return;
        }

        $this->captureMessage($error['message'], Severity::ERROR(), [
            'exception' => $error,
        ]);
    }

    /**
     * @return void
     */
    public function initializeErrorHandler(): void
    {
        ErrorHandler::register($this->getLogger());
    }

    /**
     * @return \Monolog\Logger
     */
    protected function makeLogger(): Logger
    {
        $logger = new Logger($this->getChannelName());

        $logger->pushHandler($this->makeHandler());

        return $logger;
    }

    /**
     * @return \Monolog\Handler\HandlerInterface
     */
    protected function makeHandler(): HandlerInterface
    {
        if (! $graylogHost = $this->getGraylogHost()) {
            throw new WpGraylogException('Graylog host is not configured to configure Monolog channel.');
        }

        return new GraylogHandler(
            $this->getGraylogTransport(),
            $graylogHost,
            $this->getGraylogPort(),
            $this->getGraylogPath(),
            $this->getGraylogLevel()
        );
    }

    /**
     * @return static
     */
    public static function instance(): self
    {
        if (! static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
