<?php


namespace Sco\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Sco\Admin\Contracts\Config as ConfigContract;

class AdminController extends Controller
{
    public function getList(ConfigContract $config)
    {
        $model = $config->getModel();
        return $model->orderBy($model->getKeyName(), 'desc')->paginate();
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

    public function destroy(ConfigContract $config, $id)
    {
        $info = $config->getModel()->findOrFail($id);
        $info->delete();
    }

    public function batchDestroy()
    {
    }
}
