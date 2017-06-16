<?php


namespace Sco\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Sco\Admin\Contracts\Config as ConfigContract;

class AdminController extends Controller
{
    public function getList()
    {
        //return $model->paginate();
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
