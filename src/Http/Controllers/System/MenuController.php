<?php

namespace Sco\Admin\Http\Controllers\System;

use Sco\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Sco\Admin\Models\Permission;

/**
 * 菜单管理
 *
 */
class MenuController extends BaseController
{

    private $permissionModel;

    /**
     * 菜单列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $menus = $this->getPermissionModel()->getMenuTreeList();

        return $this->render('system.menu.index', compact('menus'));
    }

    /**
     * 新增菜单
     *
     * @param int $pid
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd($pid = 0)
    {

        if ($pid) {

        }

        $menus = $this->getPermissionModel()->getMenuTreeList();
        //return response()->json($menus);
        return $this->render('system.menu.add', compact('menus'));
    }

    /**
     * 保存菜单信息
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdd(Request $request)
    {
        $this->validate($request, [
            'pid'          => 'integer',
            'display_name' => 'required',
            'name'         => ['bail', 'required', 'regex:/^[\w\.]+$/'],
            //'' => '',
        ]);

        $this->getPermissionModel()->saveMenu($request);
        return response()->json(success('新增菜单完成', ['url' => route('admin.system.menu')]));
    }

    /**
     * 编辑菜单
     *
     * @param integer $id 菜单ID
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $menu  = Permission::find($id);
        $menus = $this->getPermissionModel()->getMenuTreeList();
        return response()->json(success('ok', compact('menu', 'menus')));
        //return $this->render('system.menu.edit', compact('menu', 'menus'));
    }

    /**
     * 保存菜单信息
     *
     * @param \Illuminate\Http\Request $request 提交数据
     * @param integer                  $id      菜单ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEdit(Request $request, $id)
    {
        $this->validate($request, [
            'pid'          => 'integer',
            'display_name' => 'required',
            'name'         => ['bail', 'required', 'regex:/^[\w\.]+$/'],
            //'' => '',
        ]);

        $this->getPermissionModel()->saveMenu($request, $id);
        return response()->json(success('编辑菜单完成', ['url' => route('admin.system.menu')]));
    }

    /**
     * 删除菜单
     *
     * @param integer $id
     */
    public function getDelete($id)
    {

    }


    /**
     * @return \Sco\Admin\Models\Permission
     */
    private function getPermissionModel()
    {
        if ($this->permissionModel) {
            return $this->permissionModel;
        }

        return $this->permissionModel = new Permission();
    }
}
