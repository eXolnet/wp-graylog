<?php

use Exolnet\Wordpress\Graylog\WpGraylog;

$wpGraylog = WpGraylog::instance();

if ($wpGraylog->getGraylogInitializeErrorHandler()) {
    $wpGraylog->initializeErrorHandler();
}
