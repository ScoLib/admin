<?php


namespace Sco\Admin\Http\Controllers;

use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function getList()
    {
        app('admin.config.instance')->filters()->orderBy()->paginate();
    }

    public function config()
    {
        $config = app('admin.config.instance');
        return $config;
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }

    public function batchDestroy()
    {
    }
}
