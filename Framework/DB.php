<?php
namespace App\Framework;

use PDO;

/**
 * Class DB
 *
 * This class extends PDO to provide a singleton database connection.
 * It automatically creates the database if it does not exist.
 */
class DB extends PDO
{
    private static ?DB $_instance = null;

    /**
     * Private constructor to prevent direct instantiation.
     * Initializes the PDO connection and creates the database if it doesn't exist.
     */
    private function __construct()
    {
        try {
            parent::__construct($this->_getDSN(), env('DB_USERNAME'), env('DB_PASSWORD'));
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            if ($e->getCode() == 1049) {
                $this->createDB();
                
                parent::__construct($this->_getDSN(), env('DB_USERNAME'), env('DB_PASSWORD'));
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return;
            }

            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Create the database if it does not exist
     */
    private function createDB()
    {
        // Connect to MySQL server without specifying a database
        $con = new PDO(sprintf('mysql:host=%s;port=%s', env('DB_HOST'), env('DB_PORT')), env('DB_USERNAME'), env('DB_PASSWORD'));
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbName = env('DB_DATABASE');
        $con->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    }

    /**
     * Get the singleton instance of the DB class
     *
     * @return DB
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Get the Data Source Name (DSN) for the PDO connection
     *
     * @return string
     */
    private function _getDSN()
    {
        return sprintf('mysql:dbname=%s;host=%s;port=%s', env('DB_DATABASE'), env('DB_HOST'), env('DB_PORT'));
    }

    public function __clone() {}
    public function __wakeup() {}
}