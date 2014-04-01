@extends('Backend.Back_nav')

@section('title')
文章管理--freshmen
@stop

@section('Frame_part')

   <div class="container">
    <div class="tab-content">
      <div class="tab-pane active" id="home">
         <div class="row"><div class="col-md-11"><h1>文章</h1></div>
                  <div class="col-md-1"><h1><a href="{{{ URL::route('BackendShowEditArtical')}}}"><i class=" icon-edit"></i></a><h1></div>
         </div>
        <div class="panel panel-primary">
            <!-- Default panel contents -->
        <div class="panel-heading"></div>
          <!-- Table -->
          <table class="table">
            <thead>
              <tr>
            <th>状态 | 文章名</th>
            <th>作者</th>
            <th>分类</th>
            <th>浏览数</th>
            <th>发表日期</th>
            <th>操作</th>
              </tr>
            </thead>
            <tbody>
        @if(!empty($articals))
	    @foreach($articals as $artical)
	     <tr>
        <td><a href="{{{ URL::route('BackendActiveArtical',$artical['id'])}}}">
            @if($artical['active'] == '0')
            <span class="glyphicon glyphicon-exclamation-sign"></span>
            @else
            <span class="glyphicon glyphicon-ok"></span>
            </a>
            @endif
             <a href="">{{ $artical['title'] }}</a></td>
		<td>{{ $artical['user'] }}</td>
		<td>@foreach($artical['catagories'] as $catagory)
			<span class="label label-success">{{ $catagory['catagory'] }}</span>
		    @endforeach
		</td>
        <td>{{ $artical['see']}}</td>
		<td>{{ $artical['created_at'] }}</td>
        <td><a href=""><span class="glyphicon glyphicon-pencil"></span></a> |
            <a href="{{{ URL::route('BackendRemoveArtical',$artical['id'])}}}" onclick="return confirm('亲～～，你确定要删除么？')"><span class="glyphicon glyphicon-trash"></span></a> |
            <a href="{{{ URL::route('BackendUpdownArtical',$artical['id'])}}}" title="置顶">
            @if($artical['updown']=='0')
                <span class="glyphicon glyphicon-thumbs-down"></span>
            @else<span class="glyphicon glyphicon-thumbs-up"></a></td>
            @endif
	     </tr>
	   @endforeach
       @endif

            </tbody>
          </table>
           </div>
      </div>
	</div>
@stop
