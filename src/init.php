<?php

namespace Exolnet\Wordpress\Graylog;

$wpGraylog = WpGraylog::instance();

if ($wpGraylog->getGraylogInitializeErrorHandler()) {
    $wpGraylog->initializeErrorHandler();
}
