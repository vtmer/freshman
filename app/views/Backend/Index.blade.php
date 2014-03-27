@extends ('Backend.Frame')

@section('title')
新生网--后台首页
@stop


@section('container')
<div id="all">
<div id="logo">
<div class="container">
  <div id="height"></div>
  <div class="row">
  <div  class="col-md-4 freshmen"><a  href="{{{ URL::route('BackendShowArtical')}}}"title="文章列表"><i class="icon-file icon-4x"></i></a></div>
  <div    class="col-md-4 freshmen"><a  href="{{{ URL::route('BackendShowUsers')}}}" title="用户管理" ><i class="icon-group icon-4x"></i></a></div>
  <div  class="col-md-4 freshmen"><a href="{{{ URL::route('BackendShowCatagory')}}}"title="分类管理"><i class="icon-tags icon-4x"></i></a></div>
  </div>
</div>
</div>
</div>
@stop

