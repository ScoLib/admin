<?php


namespace Sco\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Sco\Admin\Exceptions\Handler;

/**
 * 后台基础控制器
 * 所有后台控制器都应继承该类
 *
 */
class BaseController extends Controller
{
    public function __construct()
    {
        $ehandler = app(\Illuminate\Contracts\Debug\ExceptionHandler::class);
        \App::singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            function () use ($ehandler) {
                return new Handler($ehandler);
            }
        );
    }

    /**
     * 后台入口页（控制台）
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin::layouts.app');
    }
}
