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

    public function getCreateInfo(ComponentInterface $component)
    {
        if (!$component->isCreate()) {
            throw new AuthorizationException();
        }

        $form = $component->fireCreate();

    }

    public function create(ComponentInterface $component)
    {
        if (!$component->isCreate()) {
            throw new AuthorizationException();
        }

        return view('admin::app');
    }

    public function store(ComponentInterface $component)
    {
        if (!$component->isCreate()) {
            throw new AuthorizationException();
        }

        $component->store();
    }

    public function getEditInfo(ComponentInterface $component, $id)
    {
        if (!$component->isEdit()) {
            throw new AuthorizationException();
        }

    }

    public function edit(ComponentInterface $component, $id)
    {
        if (!$component->isEdit()) {
            throw new AuthorizationException();
        }

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
