<?php

namespace Sco\Admin;

use Illuminate\Foundation\Application;

class Admin
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function routes()
    {
        require __DIR__ . '/../routes/admin.php';
    }
}
