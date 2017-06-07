<?php


namespace Sco\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Sco\Admin\Config\Factory;

class AdminController extends Controller
{
    public function getList()
    {

    }

    public function config($model)
    {
        $config = (new Factory())->makeFromUri($model);
        return response()->json($config->getAttribute());
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function batchDestroy()
    {

    }
}
