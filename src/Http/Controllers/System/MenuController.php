<?php

namespace Sco\Admin\Http\Controllers\Controllers\System;

use Sco\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Sco\Admin\Models\Permission;
use Sco\Admin\Repositories\PermissionRepository;

/**
 * 菜单管理
 *
 */
class MenuController extends BaseController
{

    /**
     * 菜单列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $menus = (new Permission())->getMenuTreeList();

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

        $menus = app(PermissionRepository::class)->getMenuTreeList();
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

        app(PermissionRepository::class)->saveMenu($request);
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
        $menus = (new Permission)->getMenuTreeList();
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

        app(PermissionRepository::class)->saveMenu($request, $id);
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


}
