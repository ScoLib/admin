<?php


namespace Sco\Admin\Http\Controllers\Users;

use Auth;
use DB;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sco\Admin\Exceptions\InvalidArgumentException;
use Sco\Admin\Http\Requests\StoreRoleRequest;
use Sco\Admin\Http\Requests\UpdateRoleRequest;
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

    public function store(StoreRoleRequest $request)
    {
        $role = new Role();
        $role->fill($request->input());
        DB::transaction(function () use ($role, $request) {
            $role->save();
            $role->savePermissions($request->input('perms'));
        });
        return response()->json(['message' => 'ok']);
    }

    public function update(UpdateRoleRequest $request)
    {
        $role = Role::findOrFail($request->input('id'));
        if ($role->name == 'admin' && !Auth::user()->hasRole($role->name)) {
            throw new AuthorizationException();
        }

        $role->fill($request->input());
        DB::transaction(function () use ($role, $request) {
            $role->save();
            $role->savePermissions($request->input('perms'));
        });
        return response()->json(['message' => 'ok']);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if ($role->name == 'admin') {
            throw new AuthorizationException();
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
    public function batchDestroy(Request $request)
    {
        if (!is_array($request->input('ids'))) {
            throw new InvalidArgumentException('参数错误');
        }

        DB::transaction(function () use ($request) {
            foreach ($request->input('ids') as $id) {
                $role = Role::findOrFail($id);
                if ($role->name == 'admin') {
                    throw new AuthorizationException();
                }

                $role->delete();
            }
        });

        return response()->json(['message' => 'ok']);
    }
}
