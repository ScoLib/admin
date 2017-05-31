<?php


namespace Sco\Admin\Http\Controllers\Users;

use Auth;
use DB;
use Illuminate\Auth\AuthenticationException;
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
        $model->fill($data);
        DB::transaction(function () use ($model, $request) {
            $model->save();
            $model->roles()->sync($request->input('roles'));
        });
        return response()->json(['message' => 'ok']);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $this->getUserModel()->findOrFail($request->input('id'));
        if ($user->id == 1 && Auth::id() != $user->id) {
            throw new AuthenticationException();
        }
        $data = $request->only(['name', 'email']);
        if (!empty($request->input('password'))) {
            $data['password'] = bcrypt($request->input('password'));
        }
        $user->fill($data);
        DB::transaction(function () use ($user, $request) {
            $user->save();
            $user->roles()->sync($request->input('roles'));
        });
        return response()->json(['message' => 'ok']);
    }

    public function destroy($id)
    {
        if ($id == 1) {
            throw new AuthenticationException();
        }

        $model = $this->getUserModel()->findOrFail($id);
        $model->delete();
        return response()->json(['message' => 'ok']);
    }

    public function getAllRole()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
