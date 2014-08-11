<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title>@yield('title','广工大新生网')</title>
		@section('styles')
		<link rel="stylesheet" type="text/css" href="{{{ URL::asset('static/css/index.css')}}}">
		<link rel="stylesheet" type="text/css" href="{{{ URL::asset('static/css/common.css')}}}">
		@show
	</head>
	<body>
        <button class="suggestButton">反馈</button>
		@yield('container')
	</body>
	@section('scripts')
	<script type="text/javascript" src="{{{ URL::asset('static/js/jquery-1.11.0.min.js')}}}"></script>
	<script type="text/javascript" src="{{{ URL::asset('static/js/suggest.js')}}}"></script>
	@show
</html>
