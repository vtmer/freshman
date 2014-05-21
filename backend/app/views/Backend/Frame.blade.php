<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>@yield('title','新生网后台')</title>
	@section('styles')
	<script type="text/javascript" src="{{{ URL::asset('static/js/jquery.js')}}}"></script>
	<link rel="stylesheet" type="text/css" href="{{{ URL::asset('static/css/bootstrap.css')}}}">
	<link rel="stylesheet" href="{{{ URL::asset('static/css/font-awesome.css')}}}">
	<link rel="stylesheet" href="{{{ URL::asset('static/css/select2.css')}}}">
	<link rel="stylesheet" href="{{{ URL::asset('static/css/backendindex.css')}}}">
	@show

</head>
<body>
@yield('container')
<div class="container">
@include('Backend.Model.Alert')
</div>
</body>
@section('scripts')
<script type="text/javascript" src="{{{ URL::asset('static/js/bootstrap.js')}}}"></script>
<script type="text/javascript" src="{{{ URL::asset('static/js/select2.min.js')}}}"></script>
<script type="text/javascript" src="{{{ URL::asset('static/js/bootstrap-wysiwyg.js')}}}"></script>
<script type="text/javascript" src="{{{ URL::asset('static/js/tablesorter.js')}}}"></script>
<script type="text/javascript">
$("#member").select2({
   placeholder: "请选择文章栏目"//选择框内提示信息
});
    $("#member2").select2({
   placeholder: "请选择用户组"//选择框内提示信息
});
 $("#member3").select2({
   placeholder: "请分配权限"//选择框内提示信息
});
$('#editor').wysiwyg();
</script>
@show
</html>
