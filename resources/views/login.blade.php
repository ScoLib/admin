<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('admin::layouts.partials.head')
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>Sco</b>Admin
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">
            @if (count($errors) > 0)
                {{ $errors->first() }}
            @else
                请输入您的邮箱和密码
            @endif
        </p>

        <form action="{{ route('admin.login.submit') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group has-feedback">
                <input type="email" name="email"
                       class="form-control"
                       placeholder="邮箱"
                       value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password"
                       class="form-control"
                       placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" class="ace" value="1" checked/> 记住我
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</body>
</html>
