<?php


namespace Sco\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Sco\Admin\Contracts\Config as ConfigContract;

class AdminController extends Controller
{
    public function getList(ConfigContract $config)
    {
        return $config->getModel()->orderBy('id', 'desc')->paginate();
    }

    public function config(ConfigContract $config)
    {
        return $config->getConfigs();
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

    public function destroy(ConfigContract $config, $id)
    {
        dd($config, $id);
    }

    public function batchDestroy()
    {
    }
}
