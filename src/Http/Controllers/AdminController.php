<?php

namespace Sco\Admin\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Facades\AdminNavigation;

/**
 * Class AdminController
 *
 * @package Sco\Admin\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * Get page left navigation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenu()
    {
        $pages = AdminNavigation::filterByAccessRights()
            ->sort()
            ->getPages();
        return response()->json($pages);
    }

    /**
     * Component index page
     *
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(ComponentInterface $component)
    {
        if (! $component->isDisplay()) {
            throw new AuthorizationException();
        }

        return view('admin::app');
    }

    /**
     * Component list data
     *
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getList(ComponentInterface $component)
    {
        if (! $component->isDisplay()) {
            throw new AuthorizationException();
        }

        return $component->get();
    }

    /**
     * Component config data
     *
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function config(ComponentInterface $component)
    {
        if (! $component->isDisplay()) {
            throw new AuthorizationException();
        }

        return $component->getConfigs();
    }

    /**
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @return null|\Sco\Admin\Contracts\Form\FormInterface
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getCreateInfo(ComponentInterface $component)
    {
        if (! $component->isCreate()) {
            throw new AuthorizationException();
        }

        $form = $component->fireCreate();

        return $form;
    }

    /**
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(ComponentInterface $component)
    {
        if (! $component->isCreate()) {
            throw new AuthorizationException();
        }

        return view('admin::app');
    }

    /**
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ComponentInterface $component, Request $request)
    {
        if (! $component->isCreate()) {
            throw new AuthorizationException();
        }

        $component->store();
    }

    /**
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @param $id
     * @return null|\Sco\Admin\Contracts\Form\FormInterface
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getEditInfo(ComponentInterface $component, $id)
    {
        if (! $component->isEdit()) {
            throw new AuthorizationException();
        }

        $form = $component->fireEdit($id);

        return $form;
    }

    /**
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(ComponentInterface $component, $id)
    {
        if (! $component->isEdit()) {
            throw new AuthorizationException();
        }

        return view('admin::app');
    }

    /**
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ComponentInterface $component, Request $request, $id)
    {
        if (! $component->isEdit()) {
            throw new AuthorizationException();
        }

        $component->update($id);

        return response()->json(['message' => 'ok']);
    }

    /**
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(ComponentInterface $component, $id)
    {
        if (! $component->isDelete()) {
            throw new AuthorizationException();
        }

        $component->delete($id);

        return response()->json(['message' => 'ok']);
    }

    /**
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function forceDelete(ComponentInterface $component, $id)
    {
        if (! $component->isDestroy()) {
            throw new AuthorizationException();
        }

        $component->forceDelete($id);

        return response()->json(['message' => 'ok']);
    }

    /**
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(ComponentInterface $component, $id)
    {
        if (! $component->isRestore()) {
            throw new AuthorizationException();
        }
        $component->restore($id);

        return response()->json(['message' => 'ok']);
    }

    /**
     * @param \Sco\Admin\Contracts\ComponentInterface $component
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reorder(ComponentInterface $component)
    {
        if (! $component->isEdit()) {
            throw new AuthorizationException();
        }

        //TODO

        return response()->json(['message' => 'ok']);
    }
}
