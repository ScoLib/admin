<?php

namespace Sco\Admin\Traits;

use BadMethodCallException;

trait AliasBinder
{
    protected $aliases = [];

    public function register(array $aliases)
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

    public function getAliases()
    {
        return $this->aliases;
    }

    public function getAlias($key)
    {
        return $this->aliases[$key] ?? false;
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
     * @param array $arguments
     * @return object
     * @throws \ErrorException
     */
    public function makeClass($alias, array $arguments)
    {
        $class = $this->getAlias($alias);
        $reflection = new \ReflectionClass($class);
        if ($reflection->isAbstract()) {
            throw new \ErrorException(
                sprintf(
                    'Cannot use %s, it is abstract class',
                    $class
                )
            );
        }

        return $reflection->newInstanceArgs($arguments);
    }

    public function __call($method, $parameters)
    {
        if (! $this->hasAlias($method)) {
            throw new BadMethodCallException("Not Found {$method}");
        }

        return $this->makeClass($method, $parameters);
    }
}
