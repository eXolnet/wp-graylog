<?php
/**
 * Plugin Name: WP Log
 * Plugin URI: https://github.com/eXolnet/wp-graylog
 * Description: Adds a mu-plugin that register a Monolog handler to send exception to a Graylog channel.
 * Version: 1.0.0
 * Author: eXolnet
 *
 * @package wplog
 */

namespace WPLOG;

use WPLOG\includes\Whoops;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('WPLOG')) :


    class WPLOG
    {

        /** @var string The plugin version number */
        public $version = '1.0.0';

        /**
         * @var \Whoops
         */
        public $whoops;

        /**
         * WPLOG constructor.
         */
        public function __construct()
        {
            /* Do nothing here */
        }

        /**
         * @return void
         */
        public function initialize()
        {
            $version = $this->version;
            $basename = plugin_basename(__FILE__);
            $path = plugin_dir_path(__FILE__);
            $url = plugin_dir_url(__FILE__);
            $slug = dirname($basename);

            // constants
            $this->define('WPLOG', true);
            $this->define('WPLOG_VERSION', $version);
            $this->define('WPLOG_PATH', $path);


            // composer autoload
            include_once(WPLOG_PATH . 'vendor/autoload.php');
            include_once(WPLOG_PATH . 'Processors/WordpressProcessor.php');
            include_once(WPLOG_PATH . 'Handlers/MonologHandler.php');
            include_once(WPLOG_PATH . 'includes/Whoops.php');

            add_action('plugins_loaded', function () {
                $this->whoops = new Whoops();
            });
        }

        /**
         * @param $name
         * @param bool $value
         */
        public function define($name, $value = true)
        {
            if (!defined($name)) {
                define($name, $value);
            }
        }
    }

    /**
     * @return \WPLOG
     */
    function wplog()
    {
        // globals
        global $wplog;

        // initialize
        if (!isset($wplog)) {
            $wplog = new WPLOG();
            $wplog->initialize();
        }

        // return
        return $wplog;
    }

    // initialize
    wplog();
endif; // class_exists check
