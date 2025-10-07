<?php
namespace App\Framework\Router;

use App\Framework\Router;
use App\Logger;

/**
 * Class Api
 *
 * Extends the base Router class to handle API-specific routing.
 */
final class Api extends Router
{
    /**
     * @inheritDoc
     */
    public function match($path, $request = null)
    {
        $path = rtrim($path, '/');
        
        // Get current request method
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (isset($this->_routes[$requestMethod][$path])) {
            [$controller, $method] = $this->_extractControllerMethod(
                $this->_routes[$requestMethod][$path]['controller']
            );

            $controller->$method($request);
            exit;
        }
    }
}