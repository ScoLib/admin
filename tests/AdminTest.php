<?php

namespace Sco\Admin;

use Illuminate\Support\Facades\Route;
use Sco\Admin\Contracts\ComponentInterface;

class AdminTest extends TestCase
{
    public function testLoadRoutes()
    {
        $this->assertEquals(1, \Sco\Admin\Facades\Admin::routes());

        $this->assertTrue(Route::has('admin.model.index'));
    }

    public function testGetCurrentComponentException()
    {
        $this->expectException(\ReflectionException::class);
        \Sco\Admin\Facades\Admin::component();
    }

    public function testGetCurrentComponent()
    {
        \Sco\Admin\Facades\Admin::shouldReceive('component')
            ->once()
            ->andReturn($return = ComponentInterface::class);

        $this->assertEquals($return, \Sco\Admin\Facades\Admin::component());
    }
}
