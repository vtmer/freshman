@extends ('mobile.Base')

@section('container')
<div class="nav">
    @include('mobile.Component.nav')
    <div class="carousel">
        <div class="carousel-main oneByOne1">
        <div class="carousel-photo-list" id="onebyone_slider">
            <div class="carousel-photo-item oneByOne_item">
                <a href="">
                    <img src="{{{ URL::asset('static/images/album_one.jpg') }}}" alt="" />
                </a>
            </div>
            <div class="carousel-photo-item oneByOne_item">
                <a href="">
                    <img src="{{{ URL::asset('static/images/album_two.jpg') }}}" alt="" />
                </a>
            </div>
            <div class="carousel-photo-item oneByOne_item">
                <a href="">
                    <img src="{{{ URL::asset('static/images/album_three.jpg') }}}" alt="" />
                </a>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="recent-news">
    <div class="recent-news-title">
        <h3><a href="{{{ URL::route('FrontendListByCatagoryId',$newestInformation['id'])}}}">{{ $newestInformation['catagory']}}</a></h3>
    </div>
    @foreach ($newestInformation['articles'] as $article)
    <div class="recent-news-list">
        <div class="recent-news-item">
            <div class="news-item-title">
                <h4><a href="{{{ URL::route('FrontendShowArticle',array($newestInformation['id'],$article['id']))}}}">{{ $article['title'] }}</a></h4>
            </div>
            <div class="news-item-main">
                <p class="news-item-body"><a href="{{{ URL::route('FrontendShowArticle',array($newestInformation['id'],$article['id']))}}}">{{ strFilter::filterHtmlLimit($article['content'],Config::get('freshman.substrLength')) }}</a></p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@stop
