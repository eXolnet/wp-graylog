<?php

namespace Exolnet\Wordpress\Graylog;

use Monolog\Logger;
use MyCLabs\Enum\Enum;

/**
 * @method \Exolnet\Wordpress\Graylog\Severity DEBUG()
 * @method \Exolnet\Wordpress\Graylog\Severity INFO()
 * @method \Exolnet\Wordpress\Graylog\Severity NOTICE()
 * @method \Exolnet\Wordpress\Graylog\Severity WARNING()
 * @method \Exolnet\Wordpress\Graylog\Severity ERROR()
 * @method \Exolnet\Wordpress\Graylog\Severity CRITICAL()
 * @method \Exolnet\Wordpress\Graylog\Severity ALERT()
 * @method \Exolnet\Wordpress\Graylog\Severity EMERGENCY()
 */
class Severity extends Enum
{
    /**
     * Detailed debug information
     */
    protected const DEBUG = Logger::DEBUG;

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    protected const INFO = Logger::INFO;

    /**
     * Uncommon events
     */
    protected const NOTICE = Logger::NOTICE;

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    protected const WARNING = Logger::WARNING;

    /**
     * Runtime errors
     */
    protected const ERROR = Logger::ERROR;

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    protected const CRITICAL = Logger::CRITICAL;

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    protected const ALERT = Logger::ALERT;

    /**
     * Urgent alert.
     */
    protected const EMERGENCY = Logger::EMERGENCY;
}
