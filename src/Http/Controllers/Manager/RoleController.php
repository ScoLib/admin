<?php


namespace Sco\Admin\Http\Controllers\Manager;

use Sco\Admin\Exceptions\AdminHttpException;
use Sco\Admin\Http\Controllers\BaseController;
use Sco\Admin\Models\Role;

class RoleController extends BaseController
{
    public function getList()
    {
        $roles = Role::paginate();
        return response()->json($roles);
    }

    public function getAll()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function delete($id)
    {
        if ($id == 1) {
            throw new AdminHttpException('超级管理员角色不能删除');

        }

    }

    public function authorize()
    {
    }
}
