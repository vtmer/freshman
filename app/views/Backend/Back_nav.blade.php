@extends ('Backend.Frame')

@section('title')
新生网--后台管理
@stop

@section('container')
<div class="container">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
	  <li <?php if($page=='artical') echo "class='active'"; ?>><a  href="{{{ URL::route('BackendShowArtical')}}}"title="文章列表"><i class="icon-file icon-5x"></i></a></li>

	  @if($me['permission'] !== '作者')
	  <li <?php if($page=='user') echo "class='active'"; ?>><a  href="{{{ URL::route('BackendShowUsers')}}}" title="用户管理" ><i class="icon-group icon-5x"></i></a></li>
	  <li <?php if($page=='catagory') echo "class='active'"; ?>><a href="{{{ URL::route('BackendShowCatagory')}}}"title="分类管理"><i class="icon-tags icon-5x"></i></a></li>
	  @endif
	  <li><a href="#" data-toggle="modal" data-target="#userModal" title="Hello! {{{ $me['displayname']}}},你想修改个人信息么？"><i class="icon-user-md icon-5x"></i></a></li>
	  <li><a href="{{{ URL::route('BackendDoLogout')}}}" title="退出～亲，不要走！"><i class="icon-signout icon-5x"></i></a></li>
	</ul>
</div>




<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">

     <div class="modal-content">
	<div class="modal-header">
    	  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	  <h3 class="modal-title" id="myModalLabel">Hello! {{{ $me['displayname']}}},你想修改个人信息么？</h3>
	</div>
	{{ Form::open(array('route' => array('BackendUpdateUser',$me['id']),'method'=>'post','class' => 'form-horizontal')) }}
	<div class="modal-body">
	  <div class="form-group">
	    {{ Form::label('loginname','登录名',array('class'=>'col-sm-2 control-label'))}}
        <div class="col-sm-10">
            {{ Form::text('loginname',$me['loginname'],array('class' => 'form-control','disabled' => 'true','id' => 'inputEmail13')) }}
	    </div>
	  </div>
	  <div class="form-group">
	    {{ Form::label('displayname','用户名',array('class'=>'col-sm-2 control-label'))}}
	    <div class="col-sm-10">
	        {{ Form::text('displayname',$me['displayname'],array('class' => 'form-control','id' => 'inputEmail13','value' => $me['displayname'],"required"=>"on","autofocus"=>"on")) }}
	    </div>
	   </div>
	   <div class="form-group">
	    {{ Form::label('inputPassword2','原密码',array('class'=>'col-sm-2 control-label'))}}
	     <div class="col-sm-10">
            {{ Form::password('originpassword',array('class'=> 'form-control','id'=>'inputPassword2','placeholder' => '原密码'))}}
	     </div>
	   </div>
	   <div class="form-group">
	    {{ Form::label('inputPassword','密码',array('class'=>'col-sm-2 control-label'))}}
	     <div class="col-sm-10">
            {{ Form::password('password',array('class' => 'form-control','id' => 'inputPassword3','placeholder' => '新密码'))}}
	     </div>
	   </div>


	      @if($me['permission'] == '1')
	      <div class="form-group">
		{{ Form::label('member','权限分配',array('class'=>'col-sm-2 control-label'))}}
	        <div class="col-sm-10">
		   <select id="member" multiple="multiple" style="width:100%" class="populate placeholder select2-offscreen" tabindex="-1">
		      <option value="1" @if($me['permission'] == '1') selected @endif>admin</option>
		      <option value="2" selected>editor</option>
	           </select>
	        </div>
	      </div>
      	      @endif
      </div>
      <div class="modal-footer">
      {{ Form::hidden('id',$me['id'])}}
	<button name="save_user" type="submit" class="btn btn-primary">保存</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      {{ Form::close() }}

    </div><!-- /.modal-content-->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@yield('Frame_part')

@stop

