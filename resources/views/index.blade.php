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
	        transition: all .25s ease-out;
	    }
	    .loading-box{
	        width: 150px;
	        height: 150px;
	        position: absolute;
	        left:50%;
	        top: 50%;
			transform: translate(-50%, -50%);
	        text-align: center;
			line-height: 150px;
	    }
	</style>
</head>
<body>
    <div id="loading" class="loading">
        <div class="loading-box">   
			<img src="/svg/bars.svg" />     
        </div>
    </div>
  	<div id="app" v-cloak></div>
 	<script type="text/javascript">
	 	window.onload=function(){ 
	 		var oLoad = document.getElementById('loading');
	 		oLoad.style.opacity ='0';
	 		setTimeout(function(){
	 			oLoad.parentNode.removeChild(oLoad);
	 		},300);
	 	}
 	</script>
 	<script src="{{ mix('js/manifest.js') }}"></script>
 	<script src="{{ mix('js/vendor.js') }}"></script>
 	<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>