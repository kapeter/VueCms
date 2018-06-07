<template>
    <div class="flex-box">
        <!-- Login Content -->
        <div class="content content-boxed">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 login-box">
                    <div class="animated fadeIn">
                        <!-- Login Title -->
                        <div class="text-center">
                            <h1><img src="/img/logo-lg.png" alt="Kapeter"></h1>
                        </div>
                        <!-- END Login Title -->

                        <!-- Login Form -->
                        <form class="form-horizontal push-60-t" autocomplete="off">
                            <div class="form-group" :class="{'has-error' : errors.has('email') }">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-info floating" :class="{ 'open' : loginData.email != ''}">
                                        <input v-validate="'required|email'" type="email" class="form-control" name="email" v-model="loginData.email">
                                        <label for="login-email"><i class="fa fa-user"></i> 邮箱</label>
                                    </div>
                                    <div class="help-block text-right animated fadeInDown"  v-show="errors.has('email')">
                                        {{ errors.first('email') }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" :class="{'has-error' : errors.has('password') }">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-info floating" :class="{ 'open' : loginData.password != ''}">
                                        <input v-validate="'required'" type="password" class="form-control" name="password" v-model="loginData.password">
                                        <label for="login-password"><i class="fa fa-eye-slash"></i> 密码</label>
                                    </div>
                                    <div class="help-block text-right animated fadeInDown"  v-show="errors.has('password')">
                                        {{ errors.first('password') }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label class="css-input switch switch-sm switch-info">
                                        <el-checkbox v-model="loginData.remember">保持登录状态</el-checkbox>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group push-30-t">
                                <div class="text-center">
                                    <button class="btn btn-info login-btn"  @click.prevent="login()">{{ btnText }}</button>
                                </div>
                            </div>

                            <div class="push-15-t has-error login-error" v-show="loginError">
                                <div class="col-xs-12">
                                    <div class="help-block text-center animated fadeInDown">
                                        {{ loginErrorText }}
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END Login Form -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END Login Content -->

        <!-- Login Footer -->
        <div class="push-30-t text-center">
            <small>&copy; {{ thisYear }} Kapeter.com</small>
        </div>
        <!-- END Login Footer --> 
    </div>
</template>

<script>
    export default{
        data(){
            return {
                loginUrl: 'login',
                loginData: {
                    email: '',
                    password: '',
                    remember: ''
                },
                loginError: false,
                loginErrorText: '',
                btnText: '登录系统'

            }
        },
        computed: {
            thisYear() {
                return (new Date()).getFullYear();
            }
        },
        methods: {
            login() {
                let _self = this;
                _self.loginError = false;
                _self.$validator.validateAll().then((result) => {
                    if (result) {
                        _self.btnText = '用户验证中';
                        _self.$http.post(_self.loginUrl, _self.loginData)
                            .then(function (res) {
                                if ('code' in res.data && res.data.code != 10000){
                                    _self.loginError = true;
                                    _self.loginErrorText = res.data.message;
                                    _self.btnText = '登录系统';
                                }else{
                                    _self.$store.dispatch('login',{ 'token' : res.data.token }).then(() => {
                                        _self.$router.push({ path: '/' });
                                    }).catch(err => {
                                        console.log(res);
                                    });
                                    
                                }
                            });
                    }
                });
            }
        }
    }
</script>

<style>
    .flex-box{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;        
        flex-direction: column;        
    }   
    .login-box{
        background-color: #fff;
        padding:30px 45px;
        box-sizing: border-box;
        box-shadow: 0px 1px 15px 1px rgba(113, 106, 202, 0.08);
        position: relative;
        z-index: 10;
    }
    .login-error{
        margin-top: -15px;
    }
    .cover{
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }
    .login-btn{
        padding: 8px 30px;
    }
</style>