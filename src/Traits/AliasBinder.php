<?php

namespace Sco\Admin\Traits;

use BadMethodCallException;

/**
 * Trait AliasBinder
 *
 * @package Sco\Admin\Traits
 */
trait AliasBinder
{
    /**
     * @var array
     */
    protected $aliases = [];

    /**
     * @param array $aliases
     * @return $this
     */
    public function register(array $aliases)
    {
        foreach ($aliases as $alias => $class) {
            $this->bind($alias, $class);
        }

        return $this;
    }

    /**
     * @param string $alias
     * @param $class
     * @return $this
     */
    public function bind(string $alias, $class)
    {
        $this->aliases[$alias] = $class;

        return $this;
    }

    /**
     * @return array
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function getAlias(string $key)
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
    public function hasAlias(string $alias)
    {
        return array_key_exists($alias, $this->aliases);
    }

    /**
     * @param string $alias
     * @param array $arguments
     * @return object
     * @throws \ErrorException
     * @throws \ReflectionException
     */
    protected function makeClass(string $alias, array $arguments)
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
