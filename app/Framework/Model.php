<?php 
namespace App\Framework;

use App\Framework\DB;
use App\Framework\Cache;
use PDO;

abstract class Model
{
    const CACHE_LIFETIME = 86400 * 30;
 
    protected string $table;
    protected $primaryKey = 'id';
    protected $data = [];
    protected $_origData = [];
    protected $_columns = [];

    public function __construct($id = null)
    {
        if ($id) { $this->load($id); }
    }

    public function load($id): static
    {
        $this->id = $id;
        if ($cachedData = Cache::get($this->_cacheKey())) {
            $this->data = $cachedData;
            return $this;
        }

        $query = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db()->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->data = (array) $result;
            $this->_origData = $this->data;
            Cache::set($this->_cacheKey(), $this->data, self::CACHE_LIFETIME);
        }

        return $this;
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

    public function save(): static
    {
        if (empty($this->_columns) || ! $this->hasChanges()) {
            return $this; 
        }

        if ($this->id) {
            $stmt = $this->db()->prepare($this->_updateQueryStr());
        } else {
            $stmt = $this->db()->prepare($this->_insertQueryStr());
        }
        
        $stmt = $this->_bindParams($stmt);
        if ($stmt->execute()) {
            if (! $this->id) {
                $this->id = $this->db()->lastInsertId();
            }

            Cache::reset($this->_cacheKey(), $this->data, self::CACHE_LIFETIME);
        }

        $this->_origData = $this->data;
        return $this;
    }

    public function delete(): static
    {
        if (! $this->id) {
            return $this;
        }

        $stmt = $this->db()->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            Cache::delete($this->_cacheKey());
            $this->data = [];
            unset($this->id);
        }

        return $this;
    }

    private function _insertQueryStr()
    {
        $fillableColumns = $this->_fillableColumns();
        
        $columns = implode(',', $fillableColumns);
        $values = '';
        foreach ($fillableColumns as $column) {
            $values .= " :$column,"; 
        }

        $values = rtrim($values, ",");

        return "INSERT INTO {$this->table} ($columns) VALUES ($values)";
    }

    private function _fillableColumns()
    {
        return array_intersect(array_keys($this->data), $this->_columns);
    }

    private function _dirtyColumns(): array
    {
        return array_keys(array_diff_assoc($this->data, $this->_origData));
    }

    private function _updateQueryStr()
    {
        $query = "UPDATE {$this->table} SET ";
        foreach ($this->_useColumns() as $column) {
            $query .= " $column=:$column ,";
        }

        $query  = rtrim($query, ",");
        $query .= " WHERE {$this->primaryKey} = :{$this->primaryKey}";
        return $query;
    }

    private function _bindParams(\PDOStatement $stmt): \PDOStatement
    {
        
        foreach ($this->_useColumns() as $column) {
            $stmt->bindValue(":$column", $this->data[$column]);
        }

        if ($this->id) {
            $stmt->bindValue(":{$this->primaryKey}", $this->id);
        }

        return $stmt;
    }

    private function _useColumns() 
    {
        $dirtyColumns = $this->_dirtyColumns();
        return array_intersect($dirtyColumns, $this->_fillableColumns());
    }

    public function getData(): array
    {
        return $this->data;
    }

    private function _cacheKey()
    {
        return static::class . '_' . $this->id;
    }

    public function hasChanges()
    {   
        return $this->_origData !== $this->data;
    }
}