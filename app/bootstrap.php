<?php
require_once __ROOT__ . '/vendor/autoload.php';
require_once __ROOT__ . '/app/functions.php';
require_once __ROOT__ . '/app/config/env.php';

if (php_sapi_name() !== 'cli') {
    require_once __ROOT__ . '/app/config/routes.php';
}
