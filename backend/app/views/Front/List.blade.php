@extends('Front.Template.Front')

@section('title')
    @foreach($catagoriesList as $catagory)
        @if($catagory['id'] == $chooseCatagoryId)
        {{ $catagory['catagory']}} -- 广工大新生网
        @endif
    @endforeach
@stop

@section('styles') @parent
<link rel="stylesheet" type="text/css" href="{{{ URL::asset('static/css/style.css')}}}">
@stop

@section('container')
    @include('Front.Modules.HeaderNav')
<div class="maincontain">
		<div class="contain">
			<p class="cnav">
				<span class="nav_bg">

			    </span>
				&nbsp;&nbsp;新生专题网>
                    {{ $getCatagory['catagory']}}
			</p>
			<div class="contain_passage">
				<ul>
                    @foreach($getCatagory['articles'] as $article)
					<li>
						<h1>
							<a href="{{{ URL::route('FrontendShowArticle',array($getCatagory['id'],$article['id']))}}}">{{ $article['title']}}</a>
						</h1>
						<span class="data">
							发布于：{{ $article['created_at'] }}&nbsp;&nbsp;&nbsp;&nbsp;来源：广东工业大学校团委数字中心
						</span>
                        <p>
                            {{ mb_substr($article['content'],1,90,"UTF-8") }}.....
                        </p>
					</li>
                    @endforeach
				</ul>
			</div>
            {{ $getCatagory['articles']->links() }}
		</div>

    @include('Front.Modules.Sidebar')
	</div>
    @include('Front.Modules.Footer')
@stop


@section('scripts') @parent
<script type="text/javascript" src="{{{ URL::asset('static/js/content.js')}}}"></script>
@stop
