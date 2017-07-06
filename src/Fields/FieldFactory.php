<?php


namespace Sco\Admin\Fields;

use Illuminate\Foundation\Application;
use Sco\Admin\Contracts\FieldFactory as FieldFactoryContract;
use Sco\Admin\Exceptions\BadMethodCallException;

class FieldFactory implements FieldFactoryContract
{
    protected $app;

    protected $aliases = [
        'text' => Text::class,
    ];

    public function __construct(Application $app)
    {
        $this->app = $app;
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
     * @param array $arguments
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
            throw new BadMethodCallException("Not Found {$method} Field");
        }

        return $this->makeClass($method, $parameters);
    }
}
