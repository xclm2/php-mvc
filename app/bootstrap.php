<?php
require_once __ROOT__ . '/vendor/autoload.php';
require_once __ROOT__ . '/app/config/env.php';
require_once __ROOT__ . '/app/functions.php';

if (env('APP_DEBUG')) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

if (php_sapi_name() !== 'cli') {
    require_once __ROOT__ . '/app/config/routes.php';
}
