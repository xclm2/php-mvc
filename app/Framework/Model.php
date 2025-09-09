<?php 
namespace App\Framework;

use App\Framework\DB;

abstract class Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $data = [];

    public function __construct($id = null)
    {
        if ($id) { $this->load($id); }
    }

    public function load($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db()->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        if ($result) {
            $this->data = (array) $result;
        }
    }

    protected function db()
    {
        return DB::getInstance();
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function getData()
    {
        return $this->data;
    }
    
}