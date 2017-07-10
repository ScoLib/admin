<?php


namespace Sco\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Sco\Admin\Contracts\ConfigFactoryInterface;

class AdminController extends Controller
{
    public function getList(ConfigFactoryInterface $config)
    {
        $model = $config->getModel();
        return $model->get();
    }

    public function config(ConfigFactoryInterface $config)
    {
        return $config->getConfigs();
    }

    public function create()
    {
        return view('admin::app');
    }

    public function store(ConfigFactoryInterface $config)
    {
        $config->getModel()->store();
    }

    public function edit(ConfigFactoryInterface $config, $id)
    {
        dd($config->getModel()->find($id)) ;
    }

    public function update()
    {
    }

    public function delete(ConfigFactoryInterface $config, $id)
    {
        $config->getModel()->delete($id);
        return response()->json(['message' => 'ok']);
    }

    public function batchDelete(ConfigFactoryInterface $config)
    {
    }

    public function forceDelete(ConfigFactoryInterface $config, $id)
    {
        $config->getModel()->forceDelete($id);
        return response()->json(['message' => 'ok']);
    }

    public function restore(ConfigFactoryInterface $config, $id)
    {
        $config->getModel()->restore($id);
        return response()->json(['message' => 'ok']);
    }
}
