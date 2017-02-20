<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ config('app.name') }} > Dashboard</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="{{ config('app.description') }}">
	<meta name="author" content="{{ config('app.author') }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<link rel="shortcut icon" href="/favicon.ico">

	<link rel="stylesheet" href="{{ mix('css/oneui.css') }}">
</head>
<body>
  	<div id="app"></div>

	<script src="{{ mix('js/oneui.js') }}"></script>
 	<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>