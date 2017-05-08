<?php


namespace Sco\Admin\Http\Controllers\Manager;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sco\Admin\Exceptions\AdminHttpException;
use Sco\Admin\Http\Requests\ManagerRequest;
use Sco\Admin\Models\Manager;

class UserController extends Controller
{
    public function getList()
    {
        $users = Manager::with('roles')->paginate();
        return response()->json($users);
    }

    public function save(ManagerRequest $request)
    {
        if (empty($request->input('id'))) {
            $model = new Manager();
        } else {
            $model = Manager::findOrFail($request->input('id'));
        }
        $model->name = $request->input('name');
        $model->email = $request->input('email');
        if (!empty($request->input('password'))) {
            $model->password = $request->input('password');
        }

        $model->save();

        return response()->json(['message' => 'ok']);
    }

    public function delete($id)
    {
        if ($id == 1) {
            throw new AdminHttpException('超级管理员不能删除');
        }

        $model = Manager::findOrFail($id);
        $model->delete();
        return response()->json(['message' => 'ok']);
    }

    public function saveRole(Request $request)
    {
        $user = Manager::findOrFail($request->input('id'));
        $user->roles()->sync($request->input('roles'));

        return response()->json(['message' => 'ok']);
    }
}
