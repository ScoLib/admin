<?php

namespace Sco\Admin;

use Mockery as m;
use Sco\Admin\Contracts\ComponentInterface;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function getEnvironmentSetUp($app)
    {

    }

    protected function getPackageProviders($app)
    {
        return [
            'Sco\Admin\Providers\AdminServiceProvider',
            'Sco\Admin\Providers\ResourcesServiceProvider',
            'Sco\Admin\Providers\NavigationServiceProvider',
            'Sco\Admin\Providers\ComponentServiceProvider',
            'Sco\Admin\Providers\ArtisanServiceProvider'
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Admin'           => 'Sco\Admin\Facades\Admin',
            'AdminColumn'     => 'Sco\Admin\Facades\AdminColumn',
            'AdminElement'    => 'Sco\Admin\Facades\AdminElement',
            'AdminForm'       => 'Sco\Admin\Facades\AdminForm',
            'AdminNavigation' => 'Sco\Admin\Facades\AdminNavigation',
            'AdminView'       => 'Sco\Admin\Facades\AdminView',
            'AdminViewFilter' => 'Sco\Admin\Facades\AdminViewFilter'
        ];
    }

    protected function getComponentMock()
    {
        $this->app['admin.instance.component'] = m::mock(ComponentInterface::class);
    }
}
