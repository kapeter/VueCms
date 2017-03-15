<!DOCTYPE html>
<html class="no-focus">
    <head>
        <meta charset="utf-8">

        <title>{{ config('app.name') }} > 登录</title>

        <meta name="description" content="{{ config('app.description') }}">
        <meta name="author" content="{{ config('app.author') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <link rel="shortcut icon" href="/favicon.ico">

        <link rel="stylesheet" href="{{ mix('css/oneui.css') }}">

        <style type="text/css">
            body{
                width: 100%;
                background: url('img/login-bg.jpg') no-repeat;
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

    </head>
    <body>
        <!-- Login Content -->
        <div class="pulldown">
            <div class="content content-boxed overflow-hidden">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 login-box">
                        <div class="push-15-t animated fadeIn">
                            <!-- Login Title -->
                            <div class="text-center">
                                <h1><img src="{{ asset('img/logo-lg.png') }}" alt="Kapeter"></h1>
                                <p class="text-muted push-15-t">永远相信美好的事情即将发生</p>
                            </div>
                            <!-- END Login Title -->

                            <!-- Login Form -->
                            <form class="js-validation-login form-horizontal push-30-t" autocomplete="off" id="login-form">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-primary floating">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                                            <label for="login-username"><i class="si si-user"></i> 用户名</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material form-material-primary floating">
                                            <input id="password" type="password" class="form-control" name="password">
                                            <label for="login-password"><i class="fa fa-eye-slash"></i> 登录密码</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group has-error login-error"></div>

                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label class="css-input switch switch-sm switch-primary">
                                            <input type="checkbox" name="remember"> <span></span> 记住我
                                        </label>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="font-s13 text-right push-5-t">
                                            <a href="{{ route('password.request') }}">忘记密码?</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group push-30-t">
                                    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                        <button class="btn btn-block btn-primary" id="login-btn">登  录</button>
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
            <small class="text-white"><?=Date('Y') ?> &copy; Kapeter.com</small>
        </div>
        <!-- END Login Footer -->

        <!-- OneUI Core JS -->
        <script src="{{ mix('js/oneui.js') }}"></script>
        <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>

        <script type="text/javascript">
            var BasePagesLogin = function() {
                var initValidationLogin = function(){
                    jQuery('.js-validation-login').validate({
                        errorClass: 'help-block text-right animated fadeInDown',
                        errorElement: 'div',
                        errorPlacement: function(error, e) {
                            jQuery(e).parents('.form-group > div').append(error);
                        },
                        highlight: function(e) {
                            jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                            jQuery(e).closest('.help-block').remove();
                        },
                        success: function(e) {
                            jQuery(e).closest('.form-group').removeClass('has-error');
                            jQuery(e).closest('.help-block').remove();
                        },
                        rules: {
                            'email': {
                                required: true,
                                email: true,
                            },
                            'password': {
                                required: true,
                            }
                        },
                        messages: {
                            'email': {
                                required: '请输入用户名',
                                email: '请输入正确格式的邮箱地址'
                            },
                            'password': {
                                required: '请输入密码',
                            }
                        }
                    });
                };

                return {
                    init: function () {
                        initValidationLogin();
                    }
                };
            }();

            jQuery(function(){ 
                BasePagesLogin.init(); 

                $('#login-btn').on('click',function(event){
                    var e = event || window.event;
                    e.preventDefault();
                    $('.login-error').empty();

                    $.ajax({
                        url: "/api/login",
                        type: "POST",
                        data: $('#login-form').serialize(),
                        success: function(res){
                            if (res.code != 200){
                                $('.login-error').append('<div class="col-xs-12"><div class="help-block animated fadeInDown">'+res.error+'</div></div>');
                            }else{
                                localStorage.token = res.token;
                                window.location.href = '/dashboard?token=' + localStorage.token;
                            }
                        },
                        error: function(res){
                            $('.login-error').append('<div class="help-block animated fadeInDown">服务器错误</div>');
                        }
                    });
                })


            });
        </script>
    </body>
</html>