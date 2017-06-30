<?php


namespace Sco\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Sco\Admin\Contracts\Config as ConfigContract;

class AdminController extends Controller
{
    public function getList(ConfigContract $config)
    {
        $model = $config->getModel();
        return $model->get();
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

    public function edit(ConfigContract $config, $id)
    {
        dd($config->getModel()->find($id)) ;
    }

    public function update()
    {
    }

    public function delete(ConfigContract $config, $id)
    {
        $config->getModel()->delete($id);
        return response()->json(['message' => 'ok']);
    }

    public function batchDelete(ConfigContract $config)
    {
    }
}
