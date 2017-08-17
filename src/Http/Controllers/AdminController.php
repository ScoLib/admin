<?php

namespace Sco\Admin\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
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
        return $form;
    }

    public function create(ComponentInterface $component)
    {
        if (!$component->isCreate()) {
            throw new AuthorizationException();
        }

        return view('admin::app');
    }

    public function store(ComponentInterface $component, Request $request)
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

        $form = $component->fireEdit($id);
        return $form;
    }

    public function edit(ComponentInterface $component, $id)
    {
        if (!$component->isEdit()) {
            throw new AuthorizationException();
        }

        return view('admin::app');
    }

    public function update(ComponentInterface $component, Request $request, $id)
    {
        if (!$component->isEdit()) {
            throw new AuthorizationException();
        }

        $component->update($id);
    }

    public function delete(ComponentInterface $component, $id)
    {
        if (!$component->isDelete()) {
            throw new AuthorizationException();
        }

        $component->delete($id);
        return response()->json(['message' => 'ok']);
    }

    public function forceDelete(ComponentInterface $component, $id)
    {
        if (!$component->isDestroy()) {
            throw new AuthorizationException();
        }

        $component->forceDelete($id);
        return response()->json(['message' => 'ok']);
    }

    public function restore(ComponentInterface $component, $id)
    {
        if (!$component->isRestore()) {
            throw new AuthorizationException();
        }
        $component->restore($id);
        return response()->json(['message' => 'ok']);
    }
}
