<?php
namespace App\Framework;

use App\Framework\Request;

class Dispatcher
{
    public function __construct(
        protected \App\Framework\Router $_router
    ) {}

    public function handle()
    {
        $request = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($request, PHP_URL_PATH);
        
        // Prevent API routes from being handled by Web router and vice versa
        if (str_starts_with($path, '/api') && $this->_router instanceof \App\Framework\Router\Web) {
            return;
        }

        $this->_router->match($path, new Request());
    }
}