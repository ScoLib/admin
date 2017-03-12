@extends('admin::layouts.auth')

@section('title', '登录')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('admin.index') }}"><b>Sco</b>Admin</a>
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