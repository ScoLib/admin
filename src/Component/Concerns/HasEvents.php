<?php


namespace Sco\Admin\Component\Concerns;

use Illuminate\Contracts\Events\Dispatcher;

trait HasEvents
{
    /**
     * Register a component event with the dispatcher.
     *
     * @param  string          $event
     * @param  \Closure|string $callback
     *
     * @return void
     */
    protected static function registerEvent($event, $callback)
    {
        if (isset(static::$dispatcher)) {
            $name = static::class;

            static::$dispatcher->listen("admin.component.{$event}: {$name}", $callback);
        }
    }

    /**
     * Fire the given event for the component
     *
     * @param string $event
     * @param bool   $halt
     *
     * @return bool
     */
    protected function fireEvent($event, $halt = true)
    {
        if (!isset(static::$dispatcher)) {
            return true;
        }

        $method = $halt ? 'until' : 'fire';
        return static::$dispatcher->{$method}(
            "admin.component.{$event}: " . static::class,
            $this
        );
    }

    /**
     * Get the event dispatcher instance.
     *
     * @return \Illuminate\Contracts\Events\Dispatcher
     */
    public static function getEventDispatcher()
    {
        return static::$dispatcher;
    }

    /**
     * Set the event dispatcher instance.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $dispatcher
     *
     * @return void
     */
    public static function setEventDispatcher(Dispatcher $dispatcher)
    {
        static::$dispatcher = $dispatcher;
    }
}
