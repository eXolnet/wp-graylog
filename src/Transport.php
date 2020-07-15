<?php

namespace Exolnet\Wordpress\Graylog;

use MyCLabs\Enum\Enum;

/**
 * @method \Exolnet\Wordpress\Graylog\Transport UDP()
 * @method \Exolnet\Wordpress\Graylog\Transport TCP()
 * @method \Exolnet\Wordpress\Graylog\Transport SSL()
 * @method \Exolnet\Wordpress\Graylog\Transport HTTP()
 * @method \Exolnet\Wordpress\Graylog\Transport HTTPS()
 */
class Transport extends Enum
{
    /**
     * @var string
     */
    protected const UDP = 'udp';

    /**
     * @var string
     */
    protected const TCP = 'tcp';

    /**
     * @var string
     */
    protected const SSL = 'ssl';

    /**
     * @var string
     */
    protected const HTTP = 'http';

    /**
     * @var string
     */
    protected const HTTPS = 'https';
}
