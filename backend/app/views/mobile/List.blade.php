@extends ('mobile.Base')

@section('title')
    {{ $getCatagory['catagory'] }} --  {{ Config::get('freshman.freshmanTitle')}}
@stop

@section('container')
<div class="nav">
@include('mobile.Component.nav')
</div>
<div class="news-list">
    <div class="news-title">
        <h3>{{ $getCatagory['catagory'] }}</h3>
    </div>
    @foreach($getCatagory['articles'] as $article)
    <div class="news-item">
        <div class="news-item-title">
            <h3><a href="{{{ URL::route('FrontendShowArticle',array($getCatagory['id'],$article['id']))}}}">{{{ $article['title']}}}</a></h3>
        </div>
        <div class="news-item-main">
            <p><a href="{{{ URL::route('FrontendShowArticle',array($getCatagory['id'],$article['id']))}}}">{{ strFilter::filterHtmlLimit($article['content'], Config::get('freshman.substrLength')) }}</a></p>
            <div class="news-item-note">
                <div class="item-note-info">
                    <span>{{ $article['source'] }}</span>
                    <span>{{ $article['created_at'] }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="loading">正在加载...</div>
@stop
