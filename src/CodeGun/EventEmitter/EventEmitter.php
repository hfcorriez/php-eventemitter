<?php

namespace CodeGun\EventEmitter;

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

        if (!empty($this->listeners[$event])) {
            if ($args !== null) {
                // Check arguments, set inline args more than 1
                $args = array_slice(func_get_args(), 1);
            } else {
                $args = array();
            }

            // Loop listeners for callback
            foreach ($this->listeners[$event] as $listener) {
                // Closure Listener
                call_user_func_array($listener, $args);
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
        $this->listeners[strtolower($event)][] = $listener;
    }

    /**
     * Alias for removeListener
     *
     * @param string   $event
     * @param callable $listener
     */
    public function off($event, \Closure $listener)
    {
        $this->removeListener($event, $listener);
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
     * Detach a event listener
     *
     * @static
     * @param string   $event
     * @param \Closure $listener
     */
    public function removeListener($event, \Closure $listener)
    {
        $event = strtolower($event);
        if (!empty($this->listeners[$event])) {
            // Find Listener index
            if (($key = array_search($listener, $event)) !== false) {
                // Remove it
                unset($this->listeners[$event][$key]);
            }
        }
    }

    /**
     * Remove all listeners of given event
     *
     * @param string $event
     */
    public function removeAllListeners($event)
    {
        $this->listeners[$event] = array();
    }

    /**
     * Remove all of all listeners
     */
    public function removeAllOfAllListeners()
    {
        $this->listeners = array();
    }
}