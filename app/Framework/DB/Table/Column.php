<?php
namespace App\Framework\DB\Table;

use App\Framework\DB\Table\Column\Type;

class Column
{
    protected bool $unique = false;

    public function __construct(
        protected string $name,
        protected string $type,
        protected mixed $length = null,
        protected bool $nullable = true,
        protected bool $primaryKey = false,
        protected bool $autoIncrement = false,
        protected mixed $default = null
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }

    public function isPrimaryKey(): bool
    {
        return $this->primaryKey;
    }

    public function isAutoIncrement(): bool
    {
        return $this->autoIncrement;
    }

    public function getDefault(): mixed
    {
        return $this->default;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function isUnique()
    {
        return $this->unique;
    }

    public function unique()
    {
        $this->unique = true;
        return $this;
    }
}