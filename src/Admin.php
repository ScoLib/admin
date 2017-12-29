<?php

namespace Sco\Admin;

use Illuminate\Foundation\Application;

class Admin
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register the routes for an application.
     *
     * @return void
     */
    public function routes()
    {
        require __DIR__ . '/../routes/admin.php';
    }

    /**
     * Component entity
     *
     * @return \Sco\Admin\Contracts\ComponentInterface
     */
    public function component()
    {
        return $this->app['admin.instance.component'];
    }
}
