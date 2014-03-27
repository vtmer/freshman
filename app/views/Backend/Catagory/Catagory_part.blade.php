@extends('Backend.Back_nav')
@if($me['permission']!='作者')
@section('title')
分类管理--freshmen
@stop

@section('Frame_part')
<div class="container">

  <div class="tab-pane" id="messages">
    <div class="row"><div class="col-md-11"><h1>分类</h1>
    </div>
    <div class="col-md-1"><h1><a href="" data-toggle="modal" data-target="#new_myModal_cata">
       <span class="glyphicon glyphicon-tag"></span></a><h1>
    </div>
  </div>

  <div class="panel panel-primary">
  <!-- Default panel contents -->
    <div class="panel-heading"></div>
      <table class="table">
	<thead>
	   <tr>
	      <th>栏目名</th>
	      <th>文章数</th>
	      <th>操作</th>
	   </tr>
	</thead>
	<tbody>
      @foreach($catagories as $catagory)
	<tr>
	<td><i class="icon-folder-close"></i> <a href="" data-toggle="modal" data-target="#update_myModal_cata" id="update{{ $catagory['id'] }}" onclick="updatecatagory({{ $catagory['id'] }})">{{ $catagory['catagory'] }}</a></td>
	<td>共有14篇文章</td>
	<td> <a href="" data-toggle="modal" data-target="#delete_myModal_cata"><span class="glyphicon glyphicon-trash" onclick="deletecatagory({{ $catagory['id'] }})"></span></a></td>
	</tr>
      @endforeach
	</tbody>
      </table>
  </div>

</div>

<div class="modal fade" id="update_myModal_cata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <div class="modal-content">
        <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	 <h3 class="modal-title" id="myModalLabel">修改栏目</h3>
        </div>
    {{ Form::open(array('route' => 'BackendUpdateCatagory',
			'class' => 'form-horizontal'))}}
	<div class="modal-body">
	   <div class="form-group">
	      {{ Form::label('catagory','栏目名',array('class'=>'col-sm-2 control-label')) }}
	      <div class="col-sm-10">
	      {{ Form::text('catagory','',array('class'=>'form-control','id'=>'catagory','placeholder'=>'栏目名',"required"=>"on","autofocus"=>"on")) }}
	      </div>
	    </div>
	</div>
    <div class="modal-footer">
    {{ Form::hidden('id','',array('id' => 'updateid'))}}
	<button type="submit" class="btn btn-primary" name="new_catagory">保存</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
	</div>
	{{ Form::close() }}
      </div><!-- /.modal-content -->

   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="new_myModal_cata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <div class="modal-content">
        <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	 <h3 class="modal-title" id="myModalLabel">创建新栏目</h3>
        </div>
    {{ Form::open(array('route' => 'BackendNewCatagory',
			'method'=> 'post',
			'class' => 'form-horizontal'))}}
	<div class="modal-body">
	   <div class="form-group">
	      {{ Form::label('inputEmail3','栏目名',array('class'=>'col-sm-2 control-label')) }}
	      <div class="col-sm-10">
	      {{ Form::text('catagory', '', array('class'=>'form-control','id'=>'inputEmail3','placeholder'=>'栏目名',"required"=>"on","autofocus"=>"on")) }}
	      </div>
	    </div>
	</div>
	<div class="modal-footer">
	<button type="submit" class="btn btn-primary" name="new_catagory">创建</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
	</div>
	{{ Form::close() }}
      </div><!-- /.modal-content -->

   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="delete_myModal_cata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">

    <div class="modal-content">
        <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	 <h3 class="modal-title" id="myModalLabel">删除栏目 <small> 亲～你确定要删除它么！</small></h3>
        </div>
    {{ Form::open(array('route' => 'BackendDeleteCatagory',
			'method'=> 'post',
			'class' => 'form-horizontal'))}}
	<div class="modal-body">
	   <div class="form-group">
	      {{ Form::label('inputEmail3','栏目名',array('class'=>'col-sm-2 control-label')) }}
	      <div class="col-sm-10">
	      {{ Form::text('deletecatagory', '', array('class'=>'form-control','id'=>'deletecatagory','placeholder'=>'栏目名','disabled'=>'on')) }}
	      </div>
	    </div>
	</div>
	<div class="modal-footer">
    {{ Form::hidden('id','',array('id' => 'deleteid'))}}
	<button type="submit" class="btn btn-primary" name="new_catagory">删除</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
	</div>
	{{ Form::close() }}
      </div><!-- /.modal-content -->

   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
	function updatecatagory(id)
	{
	   document.getElementById('catagory').value = document.getElementById('update'+id).innerHTML;
	   document.getElementById('updateid').value = id;
	}
	function deletecatagory(id)
	{
	   document.getElementById('deletecatagory').value = document.getElementById('update'+id).innerHTML;
	   document.getElementById('deleteid').value = id;

	}
</script>
@stop

@endif
