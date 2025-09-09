<?php
namespace App\Framework;

use PDO;

class DB extends PDO
{
    public function __construct()
    {
        try {
            parent::__construct($this->_getDSN(), env('DB_USERNAME'), env('DB_PASSWORD'));
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    private function _getDSN()
    {
        return sprintf('mysql:dbname=%s;host=%s;port=%s', env('DB_DATABASE'), env('DB_HOST'), env('DB_PORT'));
    }
}