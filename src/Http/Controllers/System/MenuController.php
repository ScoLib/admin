<?php

namespace Sco\Admin\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sco\Admin\Http\Requests\StorePermissionRequest;
use Sco\Admin\Http\Requests\PermissionRequest;
use Sco\Admin\Http\Requests\UpdatePermissionRequest;
use Sco\Admin\Models\Permission;

/**
 * 菜单管理
 */
class MenuController extends Controller
{
    /**
     * 菜单列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        $menus = (new Permission())->getMenuTreeList();
        return response()->json($menus->values());
    }

    /**
     * 保存菜单信息
     *
     * @param \Sco\Admin\Http\Requests\StorePermissionRequest $request 提交数据
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePermissionRequest $request)
    {
        $model = new Permission();
        $model->fill($request->input())->save();
        return response()->json(['message' => 'ok']);
    }

    /**
     *  更新菜单
     *
     * @param \Sco\Admin\Http\Requests\UpdatePermissionRequest $request 提交数据
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePermissionRequest $request)
    {
        $perm = Permission::findOrFail($request->input('id'));
        $perm->update($request->input());
        return response()->json(['message' => 'ok']);
    }

    /**
     * 删除菜单
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        (new Permission())->destroyMenu($id);
        return response()->json(['message' => 'ok']);
    }

    /**
     * 批量删除菜单
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDestroy(Request $request)
    {
        if (!is_array($request->input('ids'))) {
            throw new AdminHttpException('参数错误');
        }

        (new Permission())->destroyMenu($request->input('ids'));
        return response()->json(['message' => 'ok']);
    }
}
