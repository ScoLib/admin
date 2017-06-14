<?php


namespace Sco\Admin\Column;

use Sco\Admin\Exceptions\InvalidArgumentException;

class ColumnManager
{
    protected $app;

    protected $initialDrivers = [
        'el' => 'ElColumn',
    ];

    protected $drivers = [];

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function make($option, $driver = null)
    {
        $driverName = $this->driver($driver);
        return new $driverName($option);
    }

    public function driver($driver = null)
    {
        $driver = $driver ?: $this->getDefaultDriver();
        if (!isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    protected function getDefaultDriver()
    {
        return 'el';
    }

    protected function createDriver($driver)
    {
        if (isset($this->initialDrivers[$driver])) {
            return __NAMESPACE__ . '\\' . $this->initialDrivers[$driver];
        }
        throw new InvalidArgumentException("column driver({$driver}) not found");
    }
}
