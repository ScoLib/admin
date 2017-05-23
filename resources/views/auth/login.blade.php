@extends('admin::layouts.auth')

@section('body')
    <div class="login-box" id="app">
        <div class="login-logo">
            <b>Sco</b>Admin
        </div>
        <!-- /.login-logo -->
        <transition name="fade">
        <div class="login-box-body">
            <p class="login-box-msg">
                请输入您的邮箱和密码
            </p>

            <div :class="['form-group', 'has-feedback', errors.email ? 'has-error' : '']">
                <input type="email" name="email"
                       class="form-control"
                       placeholder="邮箱"
                       v-model="info.email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div class="help-block" v-if="errors.email">
                    @{{ errors.email[0] }}
                </div>
            </div>
            <div :class="['form-group', 'has-feedback', errors.password ? 'has-error' : '']">
                <input type="password" name="password"
                       class="form-control"
                       placeholder="密码"
                       v-model="info.password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <div class="help-block" v-if="errors.password">
                    @{{ errors.password[0] }}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" class="ace" value="1" v-model="info.remember"/> 记住我
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <el-button
                            type="primary"
                            class="btn btn-primary btn-block btn-flat"
                            :loading="buttonLoading"
                            @click.prevent="login">登录</el-button>
                </div>
                <!-- /.col -->
            </div>

        </div>
        </transition>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection

@section('script')
    <script src="{{ mix('js/admin/login.js') }}"></script>
@endsection