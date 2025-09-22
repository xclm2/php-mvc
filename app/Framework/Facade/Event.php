<?php
namespace App\Framework\Facade;

use App\Framework\Event\EventData;
use App\Framework\ExceptionError\Event\MethodNotFound;

class Event
{
    private const EVENTS = __ROOT__ . '/app/config/events.json';

    private static $_registeredEvents = [];
    
    public static function dispatch($eventName, array $params = [])
    {
        $events = self::registeredEvents()[$eventName] ?? [];
        foreach ($events as $event) {
            $class = $event['class'];
            $method = $event['method'];

            $obj = new $class();
            if (! method_exists($obj, $method)) {
                throw new MethodNotFound("Method \"$class::$method\" not found");
            }

            $obj->$method(new EventData($params));
        }
    }

    private static function registeredEvents()
    {
        if (empty(self::$_registeredEvents)) {
            if (! file_exists(self::EVENTS)) {
                return self::$_registeredEvents;
            }

            $events = file_get_contents(self::EVENTS);
            self::$_registeredEvents = json_decode($events, true);
        }
        
        return self::$_registeredEvents;
    }
}