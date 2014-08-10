@extends('Backend.Back_nav')

@section('title')
用户反馈--freshmen
@stop

@section('Frame_part')
   <div class="container">
    <div class="tab-content">
      <div class="tab-pane active" id="home">
        {{ Form::open(array('route' => 'BackendDeleteSuggest',
                            'method' => 'post'
                            ))}}
         <div class="row">
            <div class="col-md-10"><h1>用户反馈</h1></div>
            <div class="col-md-2">
                <p></p>
                <button class="btn btn-lg" type="submit" name="submit" onclick="return confirm('亲～，你确定要删除?')">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
                <button type="button" class="btn btn-lg" onclick="select()">反选</button>
            </div>
         </div>
        @foreach($suggests as $suggest)
        <div class="panel panel-default">
            <div class="panel-heading">
                <span><input type="checkbox" name="ids[]" value="{{{ $suggest->id }}}"></span>
                <span>姓名：{{{ $suggest->name }}} </span>
                <span>邮箱：{{{ $suggest->email }}} </span>
                <span>反馈时间：{{{ $suggest->created_at }}} </span>
            </div>
            <div class="panel-body">
                反馈：{{{ $suggest->suggest }}}
            </div>
        </div>
        @endforeach
        {{ Form::close() }}
      </div>
	</div>
	</div>
@stop

@section('scripts') @parent
<script>
    function select() {
        var el = document.getElementsByTagName('input');
        var len = el.length;
        for(var i = 0; i < len; i++) {
            if((el[i].type == "checkbox")) {
                el[i].checked = !el[i].checked;
            }
        }
    }
</script>
@stop
