<?php

namespace Sco\Admin\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Routing\Controller;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Contracts\ModelFactoryInterface;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin::app');
    }

    public function getList(ComponentInterface $component)
    {
        if (!$component->isView()) {
            throw new AuthorizationException();
        }

        return $component->get();
    }


    public function config(ComponentInterface $component)
    {
        if (!$component->isView()) {
            throw new AuthorizationException();
        }

        return $component->getConfigs();
    }

    public function getCreate(ComponentInterface $component)
    {

    }

    public function create()
    {
        return view('admin::app');
    }

    public function store(ComponentInterface $component)
    {
        $component->store();
    }

    public function getEdit(ComponentInterface $component, $id)
    {
        if ((!$id && !$component->isCreate()) || ($id && !$component->isEdit())) {
            throw new AuthorizationException();
        }

    }

    public function edit(ComponentInterface $component, $id)
    {
        dd($component->find($id));
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
