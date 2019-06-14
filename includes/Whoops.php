<?php

namespace WPLOG\includes;

use Whoops\Handler\Handler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use WPLOG\Handlers\MonologHandler;

if (!class_exists('Whoops')) :
    class Whoops
    {

        /** @var Run */
        public $whoops;

        /** @var array */
        public $whoopsHandlers = [];

        /**
         * Whoops constructor.
         */
        public function __construct()
        {
            $this->whoops = new Run;
            if (defined('WP_DEBUG') && WP_DEBUG) {
                $this->pushHandlers(new PrettyPageHandler);
            }
            $this->pushHandlers(new MonologHandler);

            $this->register();
        }

        /**
         *
         */
        public function initialize()
        {
            /* do nothing */
        }

        /**
         * @param \Whoops\Handler\Handler $handler
         */
        public function pushHandlers(Handler $handler)
        {
            $this->whoopsHandlers[] = $handler;
        }

        /**
         * @return void
         */
        public function register()
        {
            foreach ($this->whoopsHandlers as $handler) {
                $this->whoops->pushHandler($handler);
            }

            $this->whoops->register();
        }
    }
endif;
