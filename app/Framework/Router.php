<?php
declare(strict_types=1);

namespace App\Framework;

use Exception;

class Router
{
    private const STYLE_PATH = '/public';
    private array $_routes = [];

    public function add(string $path, string $controller, array $params = [])
    {
        $this->_routes[$path] = [
            'controller' => $controller, 
            'params' => $params
        ];
    }

    public function match ($path) 
    {
        $this->_readStyles($path);

        if (array_key_exists($path, $this->_routes)) {
            [$controller, $method] = $this->_extractControllerMethod($this->_routes[$path]['controller']);
            $controller->$method();
            exit;
        }
    }

    protected function _extractControllerMethod($controller)
    {
        $parts = explode('@', $controller);
        
        if (count($parts) !== 2) {
            throw new Exception("Invalid route controller format.");
        }

        $class = $parts[0];
        $method = $parts[1];
        $controller = new $class();

        if (! method_exists($controller, $method)) {
            throw new Exception("Method not exist in {$class}.");
        }

        return [$controller, $method];
    }

    protected function _readStyles($path)
    {
        if (str_starts_with($path, self::STYLE_PATH)) {
            $file = __ROOT__ . $path;
            if (file_exists($file) && is_readable($file)) {
                
                header("Content-Type: {$this->_getMimeType($file)}");
                readfile($file);
                exit;
            } else {
                http_response_code(404);
                echo "404 Not Found: Resource {$path} not found.";
                exit;
            }
        }
    }

    private function _getMimeType($file)
    {
        $mimeType = mime_content_type($file);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if ($ext === 'css') {
            $mimeType = 'text/css';
        } elseif ($ext === 'js') {
            $mimeType = 'application/javascript';
        } elseif ($ext === 'png') {
            $mimeType = 'image/png';
        } elseif ($ext === 'jpg' || $ext === 'jpeg') {
            $mimeType = 'image/jpeg';
        } elseif ($ext === 'gif') {
            $mimeType = 'image/gif';
        }

        return $mimeType;
    }
}