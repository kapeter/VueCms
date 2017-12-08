<template>
    <div class="full-page">
        <!-- Login Content -->
        <div class="pulldown">
            <div class="content content-boxed">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 login-box">
                        <div class="push-15-t animated fadeIn">
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
                                            <label for="login-email"><i class="si si-user"></i> 登录邮箱</label>
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
                                        <label class="css-input switch switch-sm switch-info">
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
                                        <button class="btn btn-block btn-info"  @click.prevent="login()">登  录</button>
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
        <div class="pulldown push-30-t text-center">
            <small>&copy; {{ thisYear }} Kapeter.com</small>
        </div>
        <!-- END Login Footer --> 
        <canvas id="cover" class="cover"></canvas>
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
        mounted() {
            this.buildCanvas();
        },
        methods: {
            login() {
                let _self = this;
                _self.loginError = false;
                _self.$validator.validateAll().then((result) => {
                    if (result) {
                        _self.$http.post(_self.loginUrl, _self.loginData)
                            .then(function (res) {
                                if ('code' in res.data && res.data.code != 10000){
                                    _self.loginError = true;
                                    _self.loginErrorText = res.data.message;
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
            },
            buildCanvas() {
                var c = document.getElementById('cover'),
                    x = c.getContext('2d'),
                    pr = window.devicePixelRatio || 1,
                    w = window.innerWidth,
                    h = window.innerHeight,
                    f = 90,
                    q,
                    m = Math,
                    r = 0,
                    u = m.PI*2,
                    v = m.cos,
                    z = m.random
                c.width = w*pr
                c.height = h*pr
                x.scale(pr, pr)
                x.globalAlpha = 0.6
                function d(i,j){   
                    x.beginPath()
                    x.moveTo(i.x, i.y)
                    x.lineTo(j.x, j.y)
                    var k = j.x + (z()*2-0.25)*f,
                        n = y(j.y)
                    x.lineTo(k, n)
                    x.closePath()
                    r-=u/-50
                    x.fillStyle = '#'+(v(r)*127+128<<16 | v(r+u/3)*127+128<<8 | v(r+u/3*2)*127+128).toString(16)
                    x.fill()
                    q[0] = q[1]
                    q[1] = {x:k,y:n}
                }
                function y(p){
                    var t = p + (z()*2-1.1)*f
                    return (t>h||t<0) ? y(p) : t
                }
                x.clearRect(0,0,w,h)
                q=[{x:0,y:h*.7+f},{x:0,y:h*.7-f}]
                while(q[1].x<w+f) d(q[0], q[1])
            }
        }
    }
</script>

<style>
    .full-page{
        width: 100%;
        height: 100%;        
        letter-spacing: 1px;
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
</style>