<?php
namespace App\Framework\DB\Create;

use App\Framework\DB;
use App\Framework\DB\Create\Table;
use App\Framework\DB\Table\Column\Type;

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

            if ($column->getLength()) {
                $length = match($column->getType()) {
                    Type::ENUM => is_array($column->getLength()) ? 
                                    "'". implode("','", $column->getLength()) . "'": 
                                    $column->getLength(),
                    default => $column->getLength()
                };

                $query .= "($length)";
            }

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

            if ($column->isUnique()) {
                $query .= " UNIQUE";
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