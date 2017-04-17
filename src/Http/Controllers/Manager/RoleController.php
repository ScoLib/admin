<?php


namespace Sco\Admin\Http\Controllers\Manager;

use Sco\Admin\Http\Controllers\BaseController;
use Sco\Admin\Models\Role;

class RoleController extends BaseController
{
    public function getList()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function authorize()
    {
    }
}
