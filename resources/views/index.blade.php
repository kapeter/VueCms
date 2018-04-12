<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ config('app.name') }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="{{ config('app.description') }}">
	<meta name="author" content="{{ config('app.author') }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<link rel="shortcut icon" href="/favicon.ico">

	<link rel="stylesheet" href="{{ mix('css/oneui.css') }}">

	<style>
		[v-cloak] {
		  display: none;
		}
	    .loading{
	        width: 100%;
	        height: 100%;
	        position: fixed;
	        left: 0;
	        top: 0;
	        z-index: 9999;
	        background: #fff;
	        transition: all .25s linear;
	    }
	    .loading-box{
	        width: 150px;
	        height: 150px;
	        position: absolute;
	        left:50%;
	        top: 50%;
	        margin-top: -100px;
	        margin-left: -75px;
	        text-align: center;
	    }
	    .loading-box .center{
			position: absolute;
			left: 50%;
			top: 50%;
			margin-top: -36px;
			margin-left: -26px;
	    }
	    .loading-box .circle{
	    	animation: rotation 1s linear infinite;
			-moz-animation: rotation 1s linear infinite;
			-webkit-animation: rotation 1s linear infinite;
			-o-animation: rotation 1s linear infinite;
	    }
		@-webkit-keyframes rotation{
			from {-webkit-transform: rotate(0deg);}
			to {-webkit-transform: rotate(360deg);}
		}	    
	    .loading-box p{
	    	margin-top: 15px;
	    	font-size: 15px;
	    	letter-spacing: 1px;
	    	color: #333;
	    }
	</style>
</head>
<body>
    <div id="loading" class="loading">
        <div class="loading-box">
        	<img src="/img/circle.png" class="circle">
            <img src="/img/logo-no-circle.png" class="center"> 
            <p>Now Loading …</p>              
        </div>
    </div>
  	<div id="app" v-cloak></div>
 	<script type="text/javascript">
	 	window.onload=function(){ 
	 		var oLoad = document.getElementById('loading');
	 		oLoad.style.opacity ='0';
	 		setTimeout(function(){
	 			oLoad.parentNode.removeChild(oLoad);
	 		},350);
	 	}
 	</script>
 	<script src="{{ mix('js/manifest.js') }}"></script>
 	<script src="{{ mix('js/vendor.js') }}"></script>
 	<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>