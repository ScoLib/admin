<style>
    body {
        background: #d2d6de;
    }
</style>
<template>
    <div class="login-box">
        <div class="login-logo">
            <b>Sco</b>Admin
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">
                {{ $t('sco.login.login_tip') }}
            </p>

            <div :class="['form-group', 'has-feedback', errors.email ? 'has-error' : '']">
                <input type="email" name="email"
                       class="form-control"
                       :placeholder="$t('sco.login.email')"
                       @keyup.enter="login"
                       v-model="info.email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div class="help-block" v-if="errors.email">
                    {{ errors.email[0] }}
                </div>
            </div>
            <div :class="['form-group', 'has-feedback', errors.password ? 'has-error' : '']">
                <input type="password" name="password"
                       class="form-control"
                       :placeholder="$t('sco.login.password')"
                       @keyup.enter="login"
                       v-model="info.password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <div class="help-block" v-if="errors.password">
                {{ errors.password[0] }}
            </div>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" class="ace"
                                   value="1" v-model="info.remember"/> {{ $t('sco.login.remember') }}
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <el-button
                            type="primary"
                            class="btn btn-primary btn-block btn-flat"
                            :loading="buttonLoading"
                            @click.prevent="login">
                        {{ $t('sco.login.login') }}
                    </el-button>
                </div>
                <!-- /.col -->
            </div>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
</template>

<script>
    export default {
        data() {
            return {
                info: {
                    email: '',
                    password: '',
                    remember: true,
                },
                buttonLoading: false,
                errors: {},
            }
        },
        methods: {
            login () {
                this.errors = {};
                this.buttonLoading = true;
                this.$http.post(`/${this.getUrlPrefix()}/login`, this.info).then(response => {
//                    this.buttonLoading = false;
                    this.$store.commit('setUser', response.data);
                    this.$router.push({name: 'admin.dashboard'});
                }).catch(error => {
                    this.buttonLoading = false;
                    if (typeof error.response.data.errors == 'object') {
                        this.errors = error.response.data.errors;
                    }
                })
            }
        }
    }
</script>
