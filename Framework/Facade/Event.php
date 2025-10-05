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

    /**
     * Registers event listner in runtime
     *
     * @param string $eventName
     * @param array $target [class, method]
     * @return void
     */
    public static function listen(string $eventName, array $target)
    {
        self::validateListener($target);
        self::registeredEvents();

        if (! isset(self::$_registeredEvents[$eventName])) {
            self::$_registeredEvents[$eventName][] = ['class' => $target[0], 'method' => $target[1]];
            return;
        }

        $targetActions = array_unique(self::$_registeredEvents[$eventName]);
        self::$_registeredEvents[$eventName] = $targetActions;
    }

    private static function registeredEvents()
    {
        if (empty(self::$_registeredEvents)) {
            if (! file_exists(self::EVENTS)) {
                return self::$_registeredEvents;
            }

            $events = file_get_contents(self::EVENTS);
            self::validateListenersFromJSON(json_decode($events, true));
            self::$_registeredEvents = json_decode($events, true);
        }
        
        return self::$_registeredEvents;
    }

    private static function validateListenersFromJSON($events)
    {
        foreach ($events as $listeners) {
            foreach ($listeners as $listener) {
            
                self::validateListener($listener);
            }
        }
    }

    private static function validateListener(array $target)
    {
        if (! isset($target[0]) && ! isset($target['class'])) {
            print_r($target);
            throw new \Exception("Must specify target class.");
        }

        $class = $target[0] ?? $target['class'];
        if (! class_exists($class)) {
            throw new \Exception("Class $class not found.");
        }

        $method = $target[1] ?? $target['method'];
        if (! isset($target[1]) && ! isset($target['method'])) {
            print_r($target);
            throw new \Exception("Must specify the method to be called.");
        }

        if (! method_exists($class, $method)) {
            throw new MethodNotFound("Method \"$class::$method\" not found");
        }
    }
}