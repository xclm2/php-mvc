<?php
define('__ROOT__', __DIR__ . '/../../');
require_once __ROOT__ . '/app/bootstrap.php';

if (php_sapi_name() !== 'cli') {
    exit;
}

use App\Framework\DB\Version;

$version = new Version();
$version->run();

