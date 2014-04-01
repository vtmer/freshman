@extends('Backend.Back_nav')

@section('title')
新生网--文章撰写
@stop

@section('styles')
<script type="text/javascript" src="{{{ URL::asset('static/js/jquery.js')}}}"></script>
<link href="{{{ URL::asset('static/css/select2.css')}}}" rel="stylesheet">
<link href="{{{ URL::asset('static/css/prettify.css')}}}" rel="stylesheet">
<link href="{{{ URL::asset('static/css/bootstrap.css')}}}" rel="stylesheet">
<link href="{{{ URL::asset('static/css/font-awesome.css')}}}" rel="stylesheet">
<link rel="stylesheet" href="{{{ URL::asset('static/css/backendindex.css')}}}">
@stop


@section('Frame_part')
<div class="container">
	<div class="container">
	  <div class="row">
	    <div class="col-md-9"><h1>文章撰写</h1></div>
	    <div class="col-md-1"><h1><a href="" data-toggle="modal" data-target="#save_myModal"><i class="icon-save"></i></a><h1></div><div class="col-md-1"><span id="savemessage"></span></div>
 	  </div>
	</div>
	<div id="alerts"></div>
    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
          </ul>
        </div>
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
          <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
          <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
          </ul>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
        <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
      </div>
      <div class="btn-group">
		  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
		    <div class="dropdown-menu input-append">
			    <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
			    <button class="btn" type="button">Add</button>
        </div>
        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

      </div>

      <div class="btn-group">
        <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
        <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
      </div>
    </div>
    <input type="text" placeholder="文章标题" class="form-control" id="titleinput" requried><p></p>
    <div id="editor">

    </div>
  </div>


<div class="modal fade" id="save_myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	  <h3 class="modal-title" id="myModalLabel">文章发布</h3>
	</div>
    {{ Form::open(array('route' => 'BackendSaveArtical',
                        'method' => 'post',
                        'class' => 'form-horizontal'
                ))}}
	<div class="modal-body">
    <div class="form-group">
    {{ Form::label('member','文章栏目',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
		   <select name="catagories[]" id="member" multiple="multiple" style="width:100%" class="populate placeholder select2-offscreen" tabindex="-1" required>
            @foreach($catagories as $catagory)
            <option value="{{ $catagory['id']}}">{{$catagory['catagory']}}</option>
            @endforeach
		   </select>
		</div>
	       </div>
     <div class="form-group">
    {{ Form::label('select','文章状态',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
		   <select style="width:100%" class="form-control" tabindex="-1" id="select" name="active">
		      <option value="1">发布</option>
		      <option value="0">草稿</option>
		   </select>
		</div>
	       </div>
     <div class="form-group">
    {{ Form::label('updown','置顶选择',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
		   <select style="width:100%" class="form-control" tabindex="-1" id="updown" name="updown">
		      <option value="1">置顶</option>
		      <option value="0">不置顶</option>
		   </select>
		</div>
           </div>
    {{ Form::hidden('title','',array('id'=>'title'))}}
    {{ Form::hidden('content','',array('id'=>'content'))}}

	</div>
	<div class="modal-footer">
	 <button type="submit" class="btn btn-primary" id="save">保存</button>
	 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
	</form>
     {{ Form::close()}}
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@stop

@section('scripts')
<script src="{{{ URL::asset('static/js/wysiwyg.js')}}}" type="text/javascript"></script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="{{{ URL::asset('static/js/widgets.js')}}}";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript" src="{{{ URL::asset('static/js/bootstrap.js')}}}"></script>
<script src="{{{ URL::asset('static/js/prettify.js')}}}"></script>
<script src="{{{ URL::asset('static/js/jquery.hotkeys.js')}}}"></script>
<script src="{{{ URL::asset('static/js/bootstrap-wysiwyg.js')}}}"></script>
<script src="{{{ URL::asset('static/js/select2.min.js')}}}"></script>
<script type="text/javascript">
$(function(){
    $('#save').click(function () {
        var title  = document.getElementById('titleinput').value;
        var content = $('#editor').html();
        $('#title').val(title);
        $('#content').val(content);
    });
});
$("#member").select2({
   placeholder: "请选择文章栏目"//选择框内提示信息
});
</script>

@stop


