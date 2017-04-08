<?php


namespace Sco\Admin\Http\Controllers\Manager;


use Sco\Admin\Http\Controllers\BaseController;
use Sco\Admin\Models\Manager;

class UserController extends BaseController
{
    public function getList()
    {
        $users = Manager::paginate();
        return response()->json($users);
    }
}