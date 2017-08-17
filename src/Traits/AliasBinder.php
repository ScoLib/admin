<?php

namespace Sco\Admin\Traits;

use Sco\Admin\Exceptions\BadMethodCallException;

trait AliasBinder
{
    protected $aliases = [];

    public function registerAliases(array $aliases)
    {
        foreach ($aliases as $alias => $class) {
            $this->bind($alias, $class);
        }

        return $this;
    }

    public function bind($alias, $class)
    {
        $this->aliases[$alias] = $class;
        return $this;
    }

    public function getAlias($key)
    {
        return $this->aliases[$key];
    }

    /**
     * Check if alias is registered.
     *
     * @param string $alias
     *
     * @return bool
     */
    public function hasAlias($alias)
    {
        return array_key_exists($alias, $this->aliases);
    }

    /**
     * @param string $alias
     * @param array  $arguments
     *
     * @return object
     */
    public function makeClass($alias, array $arguments)
    {
        $reflection = new \ReflectionClass($this->getAlias($alias));

        return $reflection->newInstanceArgs($arguments);
    }

    public function __call($method, $parameters)
    {
        if (!$this->hasAlias($method)) {
            throw new BadMethodCallException("Not Found {$method}");
        }

        return $this->makeClass($method, $parameters);
    }
}
