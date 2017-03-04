@extends('admin::layouts.auth')

@section('title', '登录')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('admin.index') }}"><b>Sco</b>CMF</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">
                @if (count($errors) > 0)
                    {{ $errors->first() }}
                @else
                    请输入您的用户名和密码
                @endif
            </p>

            <form action="{{ route('admin.postLogin') }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="邮箱"
                           value="{{ old('email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                @if (config('captcha.switch.admin'))
                    <div class="form-group row">
                        <div class="col-sm-7">
                            <input type="text" name="captcha" class="form-control" placeholder="验证码">
                        </div>
                        <div class="col-sm-5">
                            <img src="{{ captcha_src('admin') }}" title="换一个？" alt="换一个？"
                                 onclick="this.src='{{ captcha_src('admin') }}' + Math.random();">
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-8">
                        <div class="checkbox">
                            <label>
                                <input name="remember" type="checkbox" value="1"> 记住我
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection