<?php
namespace App\Listener;

class TestListener
{
    public function test($data)
    {
        $data->user->name = "Zeke";
    }
}