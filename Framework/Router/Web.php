<?php
namespace App\Framework\Router;

use App\Framework\Router;
use App\Logger;

final class Web extends Router
{
    protected array $_routes = [];

    /**
     * @inheritDoc
     */
    public function match($path, $request = null)
    {
        /**
         * If in React mode, serve the React app and exit
         * This allows React Router to handle the routing on the client side.
         */
        if (env('FRONTEND_MODE', 'php') === 'react') {
            require __ROOT__ . '/app/View/index.php';
            exit;
        }

        $this->_readStyles($path);

        // Get current request method
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->_routes[$requestMethod][$path])) {
            [$controller, $method] = $this->_extractControllerMethod(
                $this->_routes[$requestMethod][$path]['controller']
            );

            $controller->$method($request);
            exit;
        }

        // Route not found
        http_response_code(404);
        echo "404 Not Found: Route {$path} not found for {$requestMethod} method.";
        exit;
    }
}