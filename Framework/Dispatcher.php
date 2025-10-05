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
        
        $this->_router->match($path, new Request());
    }
}