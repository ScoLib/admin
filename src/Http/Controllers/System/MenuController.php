<?php

namespace Sco\Admin\Http\Controllers\System;

use Sco\Admin\Http\Controllers\BaseController;
use Sco\Admin\Http\Requests\PermissionRequest;
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
    public function getList()
    {
        $menus = $this->getPermissionModel()->getMenuTreeList();

        return response()->json($menus->values());
    }

    /**
     * 保存菜单信息
     *
     * @param \Sco\Admin\Http\Requests\PermissionRequest $request 提交数据
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(PermissionRequest $request)
    {
        $this->getPermissionModel()->saveMenu($request);
        return response()->json(['message' => 'ok']);
    }


    /**
     * 删除菜单
     *
     * @param integer $id
     */
    public function delete($id)
    {
        $this->getPermissionModel()->deleteMenu($id);
        return response()->json(['message' => 'ok']);
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
