<?php

namespace Exolnet\Wordpress\Graylog\Handlers;

use Monolog\ErrorHandler as MonologErrorHandler;
use Monolog\Utils;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Throwable;

class ErrorHandler extends MonologErrorHandler
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $wpLogger;

    /**
     * @var string|null
     */
    protected $wpUncaughtExceptionLevel;

    /**
     * @var callable|null
     */
    protected $wpPreviousExceptionHandler;

    /**
     * @var bool
     */
    protected $wpPreventFatalHandler = false;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);

        $this->wpLogger = $logger;
    }

    /**
     * @param array $levelMap
     * @param bool $callPrevious
     * @return \Exolnet\Wordpress\Graylog\Handlers\ErrorHandler
     */
    public function registerExceptionHandler(array $levelMap = [], bool $callPrevious = true): self
    {
        $prev = set_exception_handler([$this, 'wpHandleException']);

        $this->wpUncaughtExceptionLevel = $levelMap;

        if ($callPrevious && $prev) {
            $this->wpPreviousExceptionHandler = $prev;
        }

        return $this;
    }

    /**
     * This exception handler is based on Sentry's logic. After being loggec, the exception is
     * thrown allow Wordpress to catch it and display a default error page.
     *
     * @see https://github.com/getsentry/sentry-php/blob/master/src/ErrorHandler.php
     *
     * @param \Throwable $exception
     * @return void
     * @throws \Throwable
     */
    public function wpHandleException(Throwable $exception)
    {
        $this->logException($exception);

        $previousExceptionHandlerException = $exception;

        // Unset the previous exception handler to prevent infinite loop in case
        // we need to handle an exception thrown from it
        $previousExceptionHandler = $this->wpPreviousExceptionHandler;
        $this->wpPreviousExceptionHandler = null;

        try {
            if (null !== $previousExceptionHandler) {
                $previousExceptionHandler($exception);

                return;
            }
        } catch (Throwable $previousExceptionHandlerException) {
            // This `catch` statement is here to forcefully override the
            // $previousExceptionHandlerException variable with the exception
            // we just catched
        }

        // If the instance of the exception we're handling is the same as the one
        // catched from the previous exception handler then we give it back to the
        // native PHP handler to prevent an infinite loop
        if ($exception === $previousExceptionHandlerException) {
            // Disable the fatal error handler or the error will be reported twice
            $this->wpPreventFatalHandler = true;

            throw $exception;
        }

        $this->wpHandleException($previousExceptionHandlerException);
    }

    /**
     * @return void
     */
    public function handleFatalError(): void
    {
        if ($this->wpPreventFatalHandler) {
            return;
        }

        parent::handleFatalError();
    }

    /**
     * @param \Throwable $exception
     */
    protected function logException(Throwable $exception): void
    {
        $this->wpLogger->log(
            $this->wpUncaughtExceptionLevel === null ? LogLevel::ERROR : $this->wpUncaughtExceptionLevel,
            sprintf(
                'Uncaught Exception %s: "%s" at %s line %s',
                Utils::getClass($exception),
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine()
            ),
            ['exception' => $exception]
        );
    }
}
