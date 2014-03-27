@extends('Backend.Back_nav')

@if($me['permission']!=='作者')
@section('title')
用户管理--freshmen
@stop

@section('Frame_part')
 <div class="container">
     <div class="tab-pane" id="profile">
	<div class="row">
	   <div class="col-md-11"><h1>用户</h1></div>
           <div class="col-md-1"><h1><a href="" data-toggle="modal" data-target="#new_myModal"><span class="glyphicon glyphicon-user" ></span></a><h1>
           </div>
	</div>
	<div class="panel panel-primary">
	        <!-- Default panel contents -->
	   <div class="panel-heading"></div>
	   <table class="table">
		<thead>
		   <tr>
		      <th>登录名</th>
		      <th>昵称</th>
		      <th>创建日期</th>
		      <th>用户权限</th>
		      <th>操作</th>
		   </tr>
		</thead>
		<tbody>
		      @foreach($users as $user)
			<tr>
			  <td><span class="glyphicon glyphicon-user"></span><a href=""  data-toggle="modal" data-target="#myModal" >{{$user['loginname']}}</a></td>
			  <td>{{$user['displayname']}}</td>
			  <td>{{$user['created_at']}}</td>
			  <td>{{$user['permission']}}</td>
			  <td><a href=""span class="glyphicon glyphicon-trash"></span></a></td>
			</tr>
		      @endforeach
		</tbody>
	   </table>
         </div>
      </div>
</div>


<div class="modal fade" id="new_myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	  <h3 class="modal-title" id="myModalLabel">创建新用户</h3>
	</div>
    {{ Form::open(array('route' => 'BackendNewUsers',
                        'method' => 'post',
                        'class' => 'form-horizontal'
                ))}}
	<div class="modal-body">
	     <div class="form-group">
    {{ Form::label('inputEmail3','登录名',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
    {{ Form::text('loginname','',array('class'=>'form-control','id' => 'inputEmail3','placeholder'=>'登录名',"required"=>"on"))}}
		</div>
	      </div>
	      <div class="form-group">
    {{ Form::label('inputEmail3','用户名',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
    {{ Form::text('displayname','',array('class'=>'form-control','id' => 'inputEmail3','placeholder'=>'用户名',"required"=>"on"))}}
		</div>
	      </div>
	      <div class="form-group">
    {{ Form::label('inputEmail3','密码',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
    {{ Form::password('password',array('class'=>'form-control','id' => 'inputEmail3','placeholder'=>'密码',"required"=>"on"))}}
		</div>
	      </div>
	      <div class="form-group">
    {{ Form::label('select','权限分配',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
		   <select style="width:100%" class="form-control" tabindex="-1" id="select" name="permission">
		      @if($me['permission'] == '超级用户')
		      <option value="管理員">admin</option>
		      @endif
		      <option value="作者">editor</option>
		   </select>
		</div>
	       </div>
	</div>
	<div class="modal-footer">
	 <button type="submit" class="btn btn-primary"name="new_user">创建</button>
	 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
	</form>
     {{ Form::close()}}
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop
@endif



