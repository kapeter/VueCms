<template>
    <div class="full-page">
        <!-- Login Content -->
        <div class="pulldown">
            <div class="content content-boxed overflow-hidden">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 login-box">
                        <div class="push-15-t animated fadeIn">
                            <!-- Login Title -->
                            <div class="text-center">
                                <h1><img src="/img/logo-lg.png" alt="Kapeter"></h1>
                                <p class="text-muted push-15-t">永远相信美好的事情即将发生</p>
                            </div>
                            <!-- END Login Title -->

                            <!-- Login Form -->
                            <form class="form-horizontal push-30-t" autocomplete="off">
                                <div class="form-group" :class="{'has-error' : errors.has('email') }">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-primary floating">
                                            <input v-validate="'required|email'" type="email" class="form-control" name="email" v-model="loginData.email">
                                            <label for="login-email"><i class="si si-user"></i> 登录邮箱</label>
                                        </div>
                                        <div class="help-block text-right animated fadeInDown"  v-show="errors.has('email')">
                                            {{ errors.first('email') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" :class="{'has-error' : errors.has('password') }">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-primary floating">
                                            <input v-validate="'required'" type="password" class="form-control" name="password" v-model="loginData.password">
                                            <label for="login-password"><i class="fa fa-eye-slash"></i> 登录密码</label>
                                        </div>
                                        <div class="help-block text-right animated fadeInDown"  v-show="errors.has('password')">
                                            {{ errors.first('password') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group has-error login-error" v-show="loginError">
                                    <div class="col-xs-12">
                                        <div class="help-block animated fadeInDown">
                                            {{ loginErrorText }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label class="css-input switch switch-sm switch-primary">
                                            <input type="checkbox" name="remember" v-model="loginData.remember"> <span></span> 记住我
                                        </label>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="font-s13 text-right push-5-t">
                                            <a href="#">忘记密码?</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group push-30-t">
                                    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                        <button class="btn btn-block btn-primary"  @click.prevent="login()">登  录</button>
                                    </div>
                                </div>
                            </form>
                            <!-- END Login Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Login Content -->

        <!-- Login Footer -->
        <div class="pulldown push-30-t text-center animated fadeInUp">
            <small class="text-white">&copy; {{ thisYear }} Kapeter.com</small>
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
                        _self.$http.post(_self.loginUrl, _self.loginData)
                            .then(function (res) {
                                if (res.data.code && res.data.code != 10000){
                                    _self.loginError = true;
                                    _self.loginErrorText = res.data.message;
                                }else{
                                    _self.setCookie('token', res.data.token);
                                    _self.$store.dispatch('login').then(() => {
                                        _self.$router.push({ path: '/' });
                                    }).catch(err => {
                                        console.log(res);
                                    });
                                    
                                }
                            });
                    }
                });
            },
            setCookie(key, value, expire) {
                let exdate = new Date();
                exdate.setDate(exdate.getDate() + expire);
                document.cookie = key + "=" + value + ((expire==null) ? "" : ";expires="+exdate.toGMTString());
            }
        }
    }
</script>

<style>
    .full-page{
        width: 100%;
        height: 100%;
        background: url('/img/login-bg.jpg') no-repeat;
        background-position: right center;
        background-size: cover; 
        letter-spacing: 1px;
    }   
    .login-box{
        background-color: #fff;
        padding:15px 30px;
        box-sizing: border-box;
        box-shadow: 0 1px 3px rgba(0,0,0,.13);
    }
    .login-error{
        margin-top: -15px;
    }
</style>