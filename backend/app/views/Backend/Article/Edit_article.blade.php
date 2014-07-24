@extends('Backend.Back_nav')

@section('title')
新生网--文章撰写
@stop

@section('styles')
<script type="text/javascript" src="{{{ URL::asset('static/js/jquery.js')}}}"></script>
<script type="text/javascript" src="{{{ URL::asset('static/ckeditor/ckeditor.js')}}}"></script>
<script type="text/javascript" src="{{{ URL::asset('static/ckfinder/ckfinder.js')}}}"></script>
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
    <input type="text" placeholder="文章标题" class="form-control" id="titleinput" value="@if(isset($article['title'])){{$article['title']}}@endif" requried><p></p>
    <textarea id="ckeditor" class="ckeditor" cols="80" rows="10">
        @if(isset($article['content']))
        {{$article['content']}}
        @endif
    </textarea>
	<script type="text/javascript">
        CKEDITOR.replace( 'ckeditor',
        {
            filebrowserBrowseUrl : "{{{ URL::asset('static/ckfinder/ckfinder.html')}}}",
            filebrowserImageBrowseUrl : "{{{ URL::asset('static/ckfinder/ckfinder.html?Type=Images')}}}",
            filebrowserFlashBrowseUrl : "{{{ URL::asset('static/ckfinder/ckfinder.html?Type=Flash')}}}",
            filebrowserUploadUrl : "{{{ URL::asset('static/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files')}}}",
            filebrowserImageUploadUrl : "{{{ URL::asset('static/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images')}}}",
            filebrowserFlashUploadUrl : "{{{ URL::asset('static/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash')}}}"
        });

	</script>
  </div>


<div class="modal fade" id="save_myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	  <h3 class="modal-title" id="myModalLabel">文章发布</h3>
    </div>
    @if(isset($article))
    {{ Form::open(array('route' => array('BackendUpdateArticle',$article['id']),
                        'method' => 'post',
                        'class' => 'form-horizontal'
                ))}}
    @else
    {{ Form::open(array('route' => 'BackendSaveArticle',
                        'method' => 'post',
                        'class' => 'form-horizontal'
                ))}}
    @endif
	<div class="modal-body">
    <div class="form-group">
    {{ Form::label('member','文章栏目',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
		   <select name="catagories[]" id="member" multiple="multiple" style="width:100%" class="populate placeholder select2-offscreen" tabindex="-1" required>
            @if(isset($catagories))
            @foreach($catagories as $catagory)
            <option value="{{ $catagory['id']}}"
                @if(isset($selected_catagories))
                @foreach($selected_catagories as $selected_catagory)
                @if($catagory['id'] == $selected_catagory['id'])
                    selected
                @endif
                @endforeach
                @endif
            >{{$catagory['catagory']}}</option>
            @endforeach
            @endif
		   </select>
		</div>
	</div>
    <div class="form-group">
    {{ Form::label('member2','文章校区',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
		   <select name="schoolparts[]" id="member2" multiple="multiple" style="width:100%" class="populate placeholder select2-offscreen" tabindex="-1" required>
            @if(isset($schoolparts))
            @foreach($schoolparts as $schoolpart)
            <option value="{{ $schoolpart['id']}}"
                @if(isset($selected_schoolparts))
                @foreach($selected_schoolparts as $selected_schoolpart)
                @if($schoolpart['id'] == $selected_schoolpart['id'])
                    selected
                @endif
                @endforeach
                @endif
            >{{$schoolpart['schoolpart']}}</option>
            @endforeach
            @endif
		   </select>
		</div>
	</div>
    <div class="form-group">
    {{ Form::label('source','文章来源',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
                <input id="source" type="text" name="source" class="form-control"
                    value="@if(isset($article['source'])) {{ $article['source'] }} @else {{ Config::get('freshman.InitArticleSource')}} @endif" required>
		</div>
	</div>
    <div class="form-group">
    {{ Form::label('select','文章状态',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
		   <select style="width:100%" class="form-control" tabindex="-1" id="select" name="active">
		      <option value="1"@if(isset($article) && $article['active'] == '1')selected @endif>发布</option>
		      <option value="0"@if(isset($article) && $article['active'] == '0')selected @endif>草稿</option>
		   </select>
		</div>
	       </div>
     <div class="form-group">
    {{ Form::label('updown','置顶选择',array('class'=> 'col-sm-2 control-label'))}}
		<div class="col-sm-10">
		   <select style="width:100%" class="form-control" tabindex="-1" id="updown" name="updown">
		      <option value="1"@if(isset($article['updown']) && $article['updown'] == '1')selected @endif>置顶</option>
		      <option value="0"@if(isset($article['updown']) && $article['updown'] == '0')selected @endif>不置顶</option>
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
<script type="text/javascript" src="{{{ URL::asset('static/js/bootstrap.js')}}}"></script>
<script src="{{{ URL::asset('static/js/prettify.js')}}}"></script>
<script src="{{{ URL::asset('static/js/select2.min.js')}}}"></script>
<script type="text/javascript">
$(function(){
    $('#save').click(function () {
        var title  = document.getElementById('titleinput').value;
        var content = CKEDITOR.instances.ckeditor.getData();
        $('#title').val(title);
        $('#content').val(content);
    });
});
$("#member").select2({
   placeholder: "请选择文章栏目"//选择框内提示信息
});
$("#member2").select2({
    placeholder: "请选择文章分校区"
});
</script>
<script language="JavaScript">
                                                   $(document).ready(function() {
      /* Our ckeck-variable which tells us if we need to warn the user before leave or not
      initialized with 'false' so the don't bother the user when we don't have to. */
      var warn_on_leave = false;

      /* Here we check if the user has made any 'changes' actually we just check if he has pressed a key in ckeditor.
      'cause you have to do that it's a proper solution.
      This Code is NOT written in jquery, 'cause I haven't found a proper way to combine jQuery and CKEditor eventhandling
      The first line is an event-listener which is called everytime we change our focus (i.e. click in our ckeditor, a link, etc)
      The second 'CKEDITOR.currentInstance' is a method which returns our currently focused element. Here we listen if the user presses a key.
      The 'try...catch' Block is needed so we don't produce an error when our focus is 'null'. */
      CKEDITOR.on('currentInstance', function() {
          try {
              CKEDITOR.currentInstance.on('key', function() {
                  warn_on_leave = true;
              });
          } catch (err) { }
      });


      // We don't want to annoy the user with a popup, when he's about to save his/her changes
      $(document.activeElement).submit(function() {
          warn_on_leave = false;
      });

      // Finally we check if we need to show our popup or not
      $(window).bind('beforeunload', function() {
          if(warn_on_leave) {
              return 'Achtung! Es wurde nicht gespeichert! Alle Eingaben gehen verloren!';
          }
      });
  });
</script>

@stop


