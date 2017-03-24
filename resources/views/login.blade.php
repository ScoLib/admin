<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('admin::layouts.partials.head')
</head>
<body class="login-layout">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <i class="ace-icon fa fa-leaf green"></i>
                            <span class="red">Sco</span>
                            <span class="white" id="id-text2">Admin</span>
                        </h1>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                        @if (count($errors) > 0)
                                            {{ $errors->first() }}
                                        @else
                                            请输入您的邮箱和密码
                                        @endif
                                    </h4>

                                    <div class="space-6"></div>

                                    <form action="{{ route('admin.postLogin') }}" method="post">
                                        {!! csrf_field() !!}
                                        <fieldset>
                                            <label class="block clearfix">
											    <span class="block input-icon input-icon-right">
                                                    <input type="email" name="email"
                                                           class="form-control"
                                                           placeholder="邮箱"
                                                           value="{{ old('email') }}">
                                                    <i class="ace-icon glyphicon glyphicon-envelope"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
											    <span class="block input-icon input-icon-right">
                                                    <input type="password" name="password"
                                                           class="form-control"
                                                           placeholder="密码">
													<i class="ace-icon glyphicon glyphicon-lock"></i>
                                                </span>
                                            </label>

                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <label class="inline">
                                                    <input type="checkbox" class="ace" value="1"/>
                                                    <span class="lbl"> 记住我</span>
                                                </label>

                                                <button type="submit"
                                                        class="width-35 pull-right btn btn-sm btn-primary">
                                                    <i class="ace-icon fa fa-key"></i>
                                                    <span class="bigger-110">登录</span>
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>

                                </div><!-- /.widget-main -->

                            </div><!-- /.widget-body -->
                        </div><!-- /.login-box -->

                    </div><!-- /.position-relative -->


                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->

</body>
</html>
