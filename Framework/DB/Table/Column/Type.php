<?php
namespace App\Framework\DB\Table\Column;

/**
 * Class Type
 * This class defines constants for various SQL data types.
 * It can be used to ensure consistency when defining column types in database tables.
 */
class Type
{
    public const INT = 'INT';
    public const VARCHAR = 'VARCHAR';
    public const TEXT = 'TEXT';
    public const DATE = 'DATE';
    public const TIMESTAMP = 'TIMESTAMP';
    public const BOOLEAN = 'BOOLEAN';
    public const FLOAT = 'FLOAT';
    public const DECIMAL = 'DECIMAL';
    public const JSON = 'JSON';
    public const ENUM = 'ENUM';
    public const SET = 'SET';
    public const CHAR = 'CHAR';
    public const BLOB = 'BLOB';
    public const MEDIUMTEXT = 'MEDIUMTEXT';
    public const MEDIUMBLOB = 'MEDIUMBLOB';
    public const TINYINT = 'TINYINT';
    public const BIGINT = 'BIGINT';
    public const SMALLINT = 'SMALLINT';
    public const DOUBLE = 'DOUBLE';
    public const DATETIME = 'DATETIME';

    public const DEFAULT_DATETIME = 'CURRENT_TIMESTAMP';
}