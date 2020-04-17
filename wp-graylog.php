<?php
/*
Plugin Name:  wp-graylog
Plugin URI:   https://github.com/eXolnet/wp-graylog
Description:  Adds a mu-plugin that register a Monolog handler to send exception to a Graylog channel.
Version:      1.0.0
Author:       eXolnet
Author URI:   https://www.exolnet.com
*/

use Exolnet\Wordpress\Graylog\WpGraylog;

$wpGraylog = WpGraylog::instance();

if ($wpGraylog->getGraylogInitializeErrorHandler()) {
    $wpGraylog->initializeErrorHandler();
}
