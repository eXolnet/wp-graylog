<?php

namespace WPLOG\Processors;

class WordpressProcessor
{
    public function __invoke(array $record)
    {
        $app = defined('LOG_APP') ? LOG_APP : '';
        $record['extra']['app'] = $app;
        $record['extra']['env'] = WP_ENV;
        $record['extra']['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $record['extra']['level_name'] = 'ERROR';
        $user = wp_get_current_user();
        if ($user) {
            $record['extra']['connected_user_ID'] = $user->ID;
            $record['extra']['connected_user_email'] = $user->get('user_email');
        }
        $record['extra'] = array_filter($record['extra']);
        return $record;
    }
}
