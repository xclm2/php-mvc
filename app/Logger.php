<?php
namespace App;

use Monolog\Logger as MainLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

class Logger {
    private static ?MainLogger $logger = null;
    private const LOG_DIR = __ROOT__ . '/log/';

    private function __construct()
    {
        self::$logger = new MainLogger(env('APP_NAME'));
        self::$logger->pushHandler(new StreamHandler(self::getLogFile(), Level::Debug));
    }

    public static function getInstance() 
    {
        if (self::$logger === null) {
            new self();
        }

        return self::$logger;
    }

    public static function debug( $message) 
    {
        self::getInstance()->log(Level::Debug, $message);
    }

    public static function warning($message) 
    {
        self::getInstance()->log(Level::Warning, $message);
    }

    private static function getLogFile()
    {
        return self::LOG_DIR . 'app.log';
    }

    public function __clone() {}
    public function __wakeup() {}
}