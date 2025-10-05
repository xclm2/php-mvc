<?php
define('__ROOT__', __DIR__);
require_once __DIR__ . '/app/bootstrap.php';
if (env('APP_DEBUG', false)) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}