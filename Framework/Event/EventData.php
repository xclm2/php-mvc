<?php
namespace App\Framework\Event;

class EventData 
{
    public function __construct(protected array $data = []) {}

    /**
     * Magic method to set observer data
     * 
     * @param string $name  The parameter name
     * @param mixed  $value The parameter value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Magic method to get observer data
     * 
     * @param  string $name The parameter name
     * @return mixed|null   The parameter value if exists, null otherwise
     */
    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }
}