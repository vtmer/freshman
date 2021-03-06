<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>新生网-后台登录</title>

    <!-- Bootstrap core CSS -->
    <link href="{{{ URL::asset('static/css/bootstrap.css')}}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{{ URL::asset('static/css/signin.css')}}}" rel="stylesheet">
  </head>
  <body>

    <div class="container">
      {{ Form::open(array("route"=> "BackendDoLogin","role"=>"form","class"=>"form-signin")) }}
    	<h2 class="form-signin-heading">Welcome</h2>
    	{{ Form::text("loginname",Input::old("loginname"),array("class"=>"form-control","placeholder"=>"用户名", "required"=>"on","autofocus"=>"on")) }}
    	{{ Form::password("password",array("class"=>"form-control","placeholder"=>"密码","required"=>"on"))}}
    	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <hr />
    @include('Backend.Model.Alert')
      {{ Form::close() }}
    </div>
  </body>
</html>

