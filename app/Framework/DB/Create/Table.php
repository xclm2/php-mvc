<?php
namespace App\Framework\DB\Create;

use App\Framework\DB\Table\Column as TableColumn;

/**
 * Class Table
 *
 * This class represents a database table and provides methods to define its structure.
 */
class Table extends Processor
{
    protected string $table;
    protected array $columns = [];
    protected array $index = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param TableColumn $column
     * @return $this
     */
    public function addColumn(TableColumn $column)
    {
        $this->columns[] = $column;
        return $this;
    }

    public function addUniqueColumn(TableColumn $column) 
    {
        $column->unique();
        return $this->addColumn($column);
    }

    /**
     * @return TableColumn[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Adds created_At and updated_At timestamp columns to the table.
     *
     * @return $this
     */
    public function timestamps()
    {
        $this->columns = array_merge($this->columns, [
            new TableColumn('created_at', TableColumn\Type::TIMESTAMP, false, false, false, false, 'CURRENT_TIMESTAMP'),
            new TableColumn('updated_at', TableColumn\Type::TIMESTAMP, false, false, false, false, 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ]);

        return $this;
    }
}