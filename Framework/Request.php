<?php
namespace App\Framework;

/**
 * Request Class
 * 
 * Handles HTTP request data by providing access to GET and POST parameters
 * through magic methods and direct data access.
 */
class Request
{
    /**
     * @var array Stores request parameters
     */
    public array $data;

    /**
     * Constructor
     * 
     * Initializes the request object with GET parameters by default
     */
    public function __construct()
    {
        $this->data = $_GET;
    }
    
    /**
     * Magic method to set request parameters
     * 
     * @param string $name  The parameter name
     * @param mixed  $value The parameter value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Magic method to get request parameters
     * 
     * @param  string $name The parameter name
     * @return mixed|null   The parameter value if exists, null otherwise
     */
    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * Switches to POST data
     * 
     * Changes the data source from GET to POST parameters
     * 
     * @return self Returns the current instance for method chaining
     */
    public function post()
    {
        $this->data = $_POST;
        return $this;
    }

    public function toArray()
    {
        return $this->data;
    }
}