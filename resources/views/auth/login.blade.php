<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ config('app.name') }} > 登录</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<link rel="shortcut icon" href="/favicon.ico">

	<link rel="stylesheet" type="text/css" href="{{ mix('css/oneui.css') }}">

	<style type="text/css">
		body{
			width: 100%;
			height: 100%;
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
	</style>

</head>
<body>
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

                        <form class="js-validation-login form-horizontal push-30-t" action="base_pages_dashboard.html" method="post">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input class="form-control" type="text" id="login-username" name="login-username">
                                        <label for="login-username"><i class="si si-user"></i> 用户名</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input class="form-control" type="password" id="login-password" name="login-password">
                                        <label for="login-password"><i class="fa fa-eye-slash"></i> 登录密码</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input type="checkbox" id="login-remember-me" name="login-remember-me"><span></span> 记住我?
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    <div class="font-s13 text-right push-5-t">
                                        <a href="base_pages_reminder_v2.html">忘记密码?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group push-15-t">
                                <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                    <button class="btn btn-block btn-primary" type="submit">登  录</button>
                                </div>
                            </div>
                        </form>
                        <!-- END Login Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pulldown push-30-t text-center animated fadeInUp">
        <small class="text-muted"><?=Date('Y') ?> &copy; Kapeter.com</small>
    </div>	
</body>
	<script type="text/javascript" src="{{ mix('js/oneui.js') }}"></script>
</html>