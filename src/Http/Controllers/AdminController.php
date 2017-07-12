<?php

namespace Sco\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Sco\Admin\Contracts\ModelFactoryInterface;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin::app');
    }

    public function getList(ModelFactoryInterface $modelFactory)
    {
        return $modelFactory->get();
    }

    public function config(ModelFactoryInterface $modelFactory)
    {
        return $modelFactory->getConfigManager();
    }

    public function create()
    {
        return view('admin::app');
    }

    public function store(ModelFactoryInterface $modelFactory)
    {
        $modelFactory->store();
    }

    public function edit(ModelFactoryInterface $modelFactory, $id)
    {
        dd($modelFactory->find($id));
    }

    public function update()
    {
    }

    public function delete(ModelFactoryInterface $modelFactory, $id)
    {
        $modelFactory->delete($id);
        return response()->json(['message' => 'ok']);
    }

    public function batchDelete(ModelFactoryInterface $modelFactory)
    {
    }

    public function forceDelete(ModelFactoryInterface $modelFactory, $id)
    {
        $modelFactory->forceDelete($id);
        return response()->json(['message' => 'ok']);
    }

    public function restore(ModelFactoryInterface $modelFactory, $id)
    {
        $modelFactory->restore($id);
        return response()->json(['message' => 'ok']);
    }
}
