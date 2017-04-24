<?php


namespace Sco\Admin\Http\Controllers\Manager;

use DB;
use Illuminate\Http\Request;
use Sco\Admin\Exceptions\AdminHttpException;
use Sco\Admin\Http\Controllers\BaseController;
use Sco\Admin\Http\Requests\RoleRequest;
use Sco\Admin\Models\Permission;
use Sco\Admin\Models\Role;

class RoleController extends BaseController
{
    public function getList()
    {
        $roles = Role::with([
            'perms' => function ($query) {
                $query->select('id');
            },
        ])->paginate();
        return response()->json($roles);
    }

    public function getAll()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function getPermissionList()
    {
        $perms = (new Permission())->getPermRouteList();
        return response()->json($perms, 200, [], JSON_FORCE_OBJECT);
    }

    public function save(RoleRequest $request)
    {
        if (empty($request->input('id'))) {
            $model = new Role();
        } else {
            $model = Role::findOrFail($request->input('id'));
        }

        $model->name         = $request->input('name');
        $model->display_name = $request->input('display_name');

        DB::transaction(function () use ($model, $request) {
            $model->save();
            $model->savePermissions($request->input('perms'));
        });

        return response()->json(['message' => 'ok']);
    }

    public function delete($id)
    {
        if ($id == 1) {
            throw new AdminHttpException('超级管理员角色不能删除');
        }

        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'ok']);
    }

    /**
     * 批量删除角色
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDelete(Request $request)
    {
        if (!is_array($request->input('ids'))) {
            throw new AdminHttpException('参数错误');
        }

        DB::transaction(function () use ($request) {
            Role::destroy($request->input('ids'));
        });

        return response()->json(['message' => 'ok']);
    }
}
