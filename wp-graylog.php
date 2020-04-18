<?php
/*
Plugin Name:  wp-graylog
Plugin URI:   https://github.com/eXolnet/wp-graylog
Description:  Register a Monolog handler to send exception to a Graylog channel.
Version:      1.0.0
Author:       eXolnet
Author URI:   https://www.exolnet.com
*/

use Exolnet\Wordpress\Graylog\WpGraylog;

// If the plugin was installed with its vendor folder, we want to include the autoloader to make
// the required classes available. Otherwise, it's was probably installed with Composer.
if (file_exists(__DIR__.'/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
}

$wpGraylog = WpGraylog::instance();

if ($wpGraylog->getGraylogInitializeErrorHandler()) {
    $wpGraylog->initializeErrorHandler();
}
