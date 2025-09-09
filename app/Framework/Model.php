<?php 
namespace App\Framework;

abstract class Model extends DB
{
    protected $table;
    protected $primaryKey = 'id';
    protected $data = [];

    public function __construct($id = null)
    {
        parent::__construct();
        if ($id) { $this->load($id); }
    }

    public function load($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        if ($result) {
            $this->data = (array) $result;
        }
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