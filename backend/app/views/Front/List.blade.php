@extends('Front.Template.Front')

@section('title')
    @foreach($catagoriesList as $catagory)
        @if($catagory['id'] == $chooseCatagoryId)
        {{ $catagory['catagory']}} -- {{ Config::get('freshman.freshmanTitle')}}
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
				&nbsp;&nbsp;{{ Config::get('freshman.freshmanTitle') }}>
                    {{ $getCatagory['catagory']}}
			</p>
			<div class="contain_passage">
				<ul>
                    @foreach($getCatagory['articles'] as $article)
					<li class="list">
						<h1>
							<a href="{{{ URL::route('FrontendShowArticle',array($getCatagory['id'],$article['id']))}}}">{{ $article['title']}}</a>
						</h1>
						<p class="data">
							发布于：{{ $article['created_at'] }}&nbsp;&nbsp;&nbsp;&nbsp;来源：广东工业大学校团委新媒体
						</p>
                        <p>
                            {{ strFilter::filterHtmlLimit($article['content'],Config::get('freshman.substrLength')) }}
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
