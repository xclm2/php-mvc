<?php
namespace App\Controller\Api;

use App\Framework\Api\Rest;
use App\Framework\Request;
use App\Logger;

class User extends Rest
{
    public function getUser(Request $request)
    {
        $id = $request->id;
        // Dummy user data for demonstration
        $user = [
            'id' => $id,
            'name' => 'John Doe',
            'email' => 'example@example.com',
            'orders' => [
                ['id' => 1, 'item' => 'Laptop', 'price' => 1200],
                ['id' => 2, 'item' => 'Smartphone', 'price' => 800],
            ],
        ];

        $this->response($user, 'user');
    }
}