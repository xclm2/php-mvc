<?php
namespace App\Controller;

use App\Model\Users;

class IndexController {

    public function index() 
    {
        return view('index', ['title' => 'Home']);
    }

    public function edit() 
    {
        echo "EDIT PAGE";
    }
}