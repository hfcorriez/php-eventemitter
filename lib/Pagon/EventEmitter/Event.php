<?php

namespace Pagon\EventEmitter;

class Event
{
    /**
     * @var EventEmitter
     */
    protected static $emitter;

    /**
     * Emit the event
     *
     * @param string $event
     * @param mixed  $args
     */
    public static function emit($event, $args = null)
    {
        call_user_func_array(array(static::emitter(), 'emit'), func_get_args());
    }

    /**
     * Register event
     *
     * @param string   $event
     * @param callable $listener
     */
    public static function on($event, \Closure $listener)
    {
        static::emitter()->on($event, $listener);
    }

    /**
     * Register event
     *
     * @param array|string $event
     * @param callable     $listener
     */
    public static function once($event, \Closure $listener)
    {
        static::emitter()->once($event, $listener);
    }

    /**
     * Remove listener of giving event
     *
     * @param array|string $event
     * @param callable     $listener
     */
    public static function off($event, \Closure $listener)
    {
        static::emitter()->off($event, $listener);
    }

    /**
     * Get all listeners of giving event
     *
     * @param string $event
     */
    public static function listeners($event)
    {
        static::emitter()->listeners($event);
    }

    /**
     * Remove listener
     *
     * @param string   $event
     * @param callable $listener
     */
    public static function removeListener($event, \Closure $listener)
    {
        static::emitter()->removeListener($event, $listener);
    }

    /**
     * Remove all of event listeners
     *
     * @param $event
     */
    public static function removeAllListeners($event)
    {
        static::emitter()->removeAllListeners($event);
    }

    /**
     * Set or get emitter
     *
     * @param EventEmitter $emitter
     * @param bool         $force
     * @return EventEmitter
     */
    public static function emitter(EventEmitter $emitter = null, $force = false)
    {
        if ($force) {
            static::$emitter = $emitter;
        } else if (!static::$emitter) {
            static::$emitter = $emitter ? $emitter : new EventEmitter();
        }
        return static::$emitter;
    }
}
