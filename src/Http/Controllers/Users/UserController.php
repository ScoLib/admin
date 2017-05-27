<?php


namespace Sco\Admin\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sco\Admin\Exceptions\AdminHttpException;
use Sco\Admin\Http\Requests\StoreUserRequest;
use Sco\Admin\Http\Requests\UpdateUserRequest;
use Sco\Admin\Models\Role;

class UserController extends Controller
{

    /**
     * @return \Illuminate\Foundation\Auth\User
     */
    private function getUserModel()
    {
        $userModelName = config('admin.user');
        return new $userModelName();
    }

    public function getList()
    {
        $users = $this->getUserModel()->with('roles')->paginate();
        return response()->json($users);
    }

    public function store(StoreUserRequest $request)
    {
        $model = $this->getUserModel();
        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);
        $model->fill($data)->save();
        return response()->json(['message' => 'ok']);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $this->getUserModel()->findOrFail($request->input('id'));
        $data = $request->only(['name', 'email']);
        if (!empty($request->input('password'))) {
            $data['password'] = bcrypt($request->input('password'));
        }
        $user->fill($data)->save();
        return response()->json(['message' => 'ok']);
    }

    public function delete($id)
    {
        if ($id == 1) {
            throw new AdminHttpException('超级管理员不能删除');
        }

        $model = $this->getUserModel()->findOrFail($id);
        $model->delete();
        return response()->json(['message' => 'ok']);
    }

    public function saveRole(Request $request)
    {
        $user = $this->getUserModel()->findOrFail($request->input('id'));
        $user->roles()->sync($request->input('roles'));

        return response()->json(['message' => 'ok']);
    }

    public function getAllRole()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
