<?php
namespace App\Framework\DB\Create;

use App\Framework\DB;
use App\Framework\DB\Create\Table;
use App\Framework\DB\Table\Column\Type;
use App\Logger;

/**
 * Class Processor
 *
 * This class handles the creation and alteration of database tables.
 */
class Processor
{
    /**
     * Create a new table in the database.
     *
     * @param Table $table The table object containing the table name and columns.
     * @return void
     */
    public static function create(Table $table)
    {
        $query = "CREATE TABLE IF NOT EXISTS {$table->getTable()} (";

        foreach ($table->getColumns() as $column) {
            $query .= "{$column->getName()} {$column->getType()}";
            if ($column->isPrimaryKey()) {
                $query .= " PRIMARY KEY";
            }

            if ($column->isAutoIncrement()) {
                $query .= " AUTO_INCREMENT";
            }

            if ($column->getDefault() !== null) {
                $query .= match ($column->getType()) {
                    Type::TIMESTAMP => " DEFAULT {$column->getDefault()}",
                    default => " DEFAULT '{$column->getDefault()}'"
                };
            }

            if ($column->isNullable()) {
                $query .= " NULL";
            } else {
                $query .= " NOT NULL";
            }

            if ($column->getType() === Type::ENUM) {
                $query .= " CHECK ({$column->getName()} IN (" . implode(", ", array_map(fn($value) => "'$value'", $column->getDefault())) . "))";
            }

            $query .= ", ";
        }

        // Remove the last comma and space
        $query = rtrim($query, ', ') . ")";

        // Execute the query
        $stmt = DB::getInstance()->prepare($query);
        $stmt->execute();
    }
}