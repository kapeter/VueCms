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
	        transition: all .35s;
	    }
	    .loading-box{
	        width: 160px;
	        height: 160px;
	        position: absolute;
	        left:50%;
	        top: 50%;
	        margin-top: -80px;
	        margin-left: -80px;
	        text-align: center;
	    }
	    .loading-box p{
	    	margin-top: 15px;
	    	font-size: 16px;
	    }

		::-webkit-scrollbar  
		{  
		    width: 5px;  
		    height: 5px;  
		    background-color: rgba(0,0,0,0.15);  
		}  

		::-webkit-scrollbar-thumb  
		{  
		    background-color: #999;  
		}  
	</style>
</head>
<body>
    <div id="loading" class="loading">
        <div class="loading-box">
            <img src="/img/loading.gif"> 
            <p>Now Loading …</p>              
        </div>
    </div>
  	<div id="app" v-cloak></div>

 	<script src="{{ mix('js/oneui.js') }}"></script>
 	<script src="{{ mix('js/manifest.js') }}"></script>
 	<script src="{{ mix('js/vendor.js') }}"></script>
 	<script src="{{ mix('js/app.js') }}"></script>
 	<script type="text/javascript">
 		//移除loading动画
	 	window.onload=function(){ 
	 		var oLoad = document.getElementById('loading');
	 		oLoad.style.opacity ='0';
	 		setTimeout(function(){
	 			oLoad.parentNode.removeChild(oLoad);
	 		},350);
	 	}
 	</script>
</body>
</html>