<?php

namespace Pagon;

if (function_exists('FNMATCH')) {
    define('FNMATCH', true);
} else {
    define('FNMATCH', false);
}

class EventEmitter
{
    /**
     * @var array Events listeners
     */
    protected $listeners = array();

    /**
     * fire event
     *
     * @static
     * @param string $event
     * @param mixed  $args
     */
    public function emit($event, $args = null)
    {
        $event = strtolower($event);

        if ($args !== null) {
            // Check arguments, set inline args more than 1
            $args = array_slice(func_get_args(), 1);
        } else {
            $args = array();
        }

        $all_listeners = array();

        foreach ($this->listeners as $name => $listeners) {
            if (strpos($name, '*') === false || !self::match($name, $event)) {
                continue;
            }

            foreach ($this->listeners[$name] as &$listener) {
                $all_listeners[$name][] = & $listener;
            }
        }

        if (!empty($this->listeners[$event])) {
            foreach ($this->listeners[$event] as &$listener) {
                $all_listeners[$event][] = & $listener;
            }
        }

        // Loop listeners for callback
        foreach ($all_listeners as $name => $listeners) {
            $this_args = $args;
            if (strpos($name, '*') !== false) {
                array_push($this_args, $event);
            }
            foreach ($listeners as &$listener) {
                if ($listener instanceof \Closure) {
                    // Closure Listener
                    call_user_func_array($listener, $this_args);
                } elseif (is_array($listener) && $listener[0] instanceof \Closure) {
                    if ($listener[1]['times'] > 0) {
                        // Closure Listener
                        call_user_func_array($listener[0], $this_args);
                        $listener[1]['times']--;
                    }
                }
            }
        }
    }

    /**
     * Attach a event listener
     *
     * @static
     * @param array|string $event
     * @param \Closure     $listener
     */
    public function on($event, \Closure $listener)
    {
        if (is_array($event)) {
            foreach ($event as $e) {
                $this->listeners[strtolower($e)][] = $listener;
            }
        } else {
            $this->listeners[strtolower($event)][] = $listener;
        }
    }

    /**
     * Attach a listener to emit once
     *
     * @param array|string $event
     * @param callable     $listener
     */
    public function once($event, \Closure $listener)
    {
        if (is_array($event)) {
            foreach ($event as $e) {
                $this->listeners[strtolower($e)][] = array($listener, array('times' => 1));
            }
        } else {
            $this->listeners[strtolower($event)][] = array($listener, array('times' => 1));
        }
    }

    /**
     * Attach a listener to emit once
     *
     * @param array|string $event
     * @param int          $times
     * @param callable     $listener
     */
    public function many($event, $times = 1, \Closure $listener)
    {
        if (is_array($event)) {
            foreach ($event as $e) {
                $this->listeners[strtolower($e)][] = array($listener, array('times' => $times));
            }
        } else {
            $this->listeners[strtolower($event)][] = array($listener, array('times' => $times));
        }
    }

    /**
     * Alias for removeListener
     *
     * @param array|string $event
     * @param callable     $listener
     */
    public function off($event, \Closure $listener)
    {
        if (is_array($event)) {
            foreach ($event as $e) {
                $this->off($e, $listener);
            }
        } else {
            $event = strtolower($event);
            if (!empty($this->listeners[$event])) {
                // Find Listener index
                if (($key = array_search($listener, $this->listeners[$event])) !== false) {
                    // Remove it
                    unset($this->listeners[$event][$key]);
                }
            }
        }
    }

    /**
     * Get listeners of given event
     *
     * @param string $event
     * @return array
     */
    public function listeners($event)
    {
        if (!empty($this->listeners[$event])) {
            return $this->listeners[$event];
        }
        return array();
    }

    /**
     * Attach a event listener
     *
     * @static
     * @param array|string $event
     * @param \Closure     $listener
     */
    public function addListener($event, \Closure $listener)
    {
        $this->on($event, $listener);
    }

    /**
     * Detach a event listener
     *
     * @static
     * @param string   $event
     * @param \Closure $listener
     */
    public function removeListener($event, \Closure $listener)
    {
        $this->off($event, $listener);
    }

    /**
     * Remove all listeners of given event
     *
     * @param string $event
     */
    public function removeAllListeners($event = null)
    {
        if ($event === null) {
            $this->listeners = array();
        } else if (($event = strtolower($event)) && !empty($this->listeners[$event])) {
            $this->listeners[$event] = array();
        }
    }

    /**
     * Match the pattern
     *
     * @param string $pattern
     * @param string $string
     * @return bool|int
     */
    protected static function match($pattern, $string)
    {
        if (FNMATCH) {
            return fnmatch($pattern, $string);
        } else {
            return preg_match("#^" . strtr(preg_quote($pattern, '#'), array('\*' => '.*', '\?' => '.')) . "$#i", $string);
        }
    }
}