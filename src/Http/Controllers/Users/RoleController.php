<?php


namespace Sco\Admin\Http\Controllers\Users;

use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sco\Admin\Exceptions\AdminHttpException;
use Sco\Admin\Http\Requests\RoleRequest;
use Sco\Admin\Models\Permission;
use Sco\Admin\Models\Role;

class RoleController extends Controller
{
    public function get($id)
    {
        return Role::with(['perms' => function ($query) {
            return $query->select('id');
        }])->findOrFail($id);
    }

    public function getList()
    {
        $roles = Role::paginate();
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
            if ($model->name == 'admin' && !Auth::user()->hasRole($model->name)) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
        }

        //$model->name         = $request->input('name');
        $model->display_name = $request->input('display_name');

        DB::transaction(function () use ($model, $request) {
            $model->save();
            $model->savePermissions($request->input('perms'));
        });

        return response()->json(['message' => 'ok']);
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        if ($role->name == 'admin') {
            throw new AdminHttpException('超级管理员角色不能删除');
        }

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
            foreach ($request->input('ids') as $id) {
                $role = Role::findOrFail($id);
                if ($role->name == 'admin') {
                    throw new AdminHttpException('超级管理员角色不能删除');
                }

                $role->delete();
            }
        });

        return response()->json(['message' => 'ok']);
    }
}
