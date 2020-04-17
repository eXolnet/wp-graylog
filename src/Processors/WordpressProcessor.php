<?php

namespace Exolnet\Wordpress\Graylog\Processors;

use Throwable;
use WP_User;

class WordpressProcessor
{
    /**
     * @param array $record
     * @return array
     */
    public function __invoke(array $record): array
    {
        $record['extra']['app'] = $this->getApplicationName();
        $record['extra']['env'] = $this->getEnvironment();
        $record['extra']['user_agent'] = $this->getUserAgent();

        if ($user = $this->getWordpressUser()) {
            $record['extra']['user_id'] = $user->ID;
            $record['extra']['user_username'] = $user->get('user_login');
            $record['extra']['user_email'] = $user->get('user_email');
        }

        // Remove empty extra fields
        $record['extra'] = array_filter($record['extra']);

        return $record;
    }

    /**
     * @return string|null
     */
    protected function getApplicationName(): ?string
    {
        if (defined('GRAYLOG_APP')) {
            return GRAYLOG_APP;
        }

        if (function_exists('get_bloginfo')) {
            return get_bloginfo('name');
        }

        return null;
    }

    /**
     * @return string|null
     */
    protected function getEnvironment(): ?string
    {
        return defined('WP_ENV') ? WP_ENV : null;
    }

    /**
     * @return string|null
     */
    protected function getUserAgent(): ?string
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? null;
    }

    /**
     * @return \WP_User|null
     */
    protected function getWordpressUser(): ?WP_User
    {
        try {
            return wp_get_current_user();
        } catch (Throwable $e) {
            return null;
        }
    }
}
