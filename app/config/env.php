<?php
namespace App;

final class Env {
    private const ENV = '.env';

    public function loadEnv() 
    {
        if (! file_exists(self::ENV)) {
            throw new \Exception("Environment file not found.");
        }

        if (! is_readable(self::ENV)) {
            throw new \Exception("Environment file is not readable.");
        }

        $lines = file(self::ENV, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            // Remove first and last quotes if they exist
            $value = preg_replace('/^[\'"](.*)[\'"]$/', '$1', $value);
            
            if (! array_key_exists($name, $_SERVER) && ! array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

$main = new Env();
$main->loadEnv();