@extends ('Front.Template.Front')

@section('title')
新生专题网--你的广工指南
@stop

@section('style')
@stop

@section('container')
<div class="header">
        @include('Front.Modules.HeaderNav')
        <div class="banner">
            <div class="left_banner">
                <p class="odd">2014.6.8高考</p>
                <p class="even">2014.6月末 填报志愿</p>
                <p class="odd">2014.7月中旬 收到录取通知书</p>
                <p class="even">2014.9.1 我们在广工大等你</p>
            </div>
            <div class="right_banner">
                <div>
                    <a href="{{{ URL::route('FrontendListByCatagoryId',$newestInformation['id'])}}}">{{ $newestInformation['catagory']}}</a>
                    <span><a href="">HOT NEWS</a></span>
                    <span class="special_more"><a href="{{{ URL::route('FrontendListByCatagoryId',$newestInformation['id'])}}}">MORE</a></span>
                </div>

                {{--*/ $iconNumber = Config::get('freshman.initIconNumber') /*--}}
                @foreach ($newestInformation['articles'] as $article)
                    <p>
                        <a href="{{{ URL::route('FrontendShowArticle',array($newestInformation['id'],$article['id']))}}}">{{ $article['title']}}</a>
                    @if($iconNumber == Config::get('freshman.iconOne'))           <span class="icon_one">1</span>
                    @elseif ($iconNumber == Config::get('freshman.iconTwo'))      <span class="icon_two">2</span>
                    @elseif ($iconNumber == Config::get('freshman.iconThree'))    <span class="icon_three">3</span>
                    @endif
                        <span class="date1">发布时间:{{ $article['created_at']}}</span>
                    </p>
                {{--*/ if($iconNumber == Config::get('freshman.initShowArticleNumber')) break /*--}}
                {{--*/ $iconNumber++; /*--}}
                @endforeach

            </div>
            <div class="bo_banner">
                <img class="scroll" id="goBottom" src="{{{ URL::asset('static/images/scroll.png') }}} ">
                <img class="dot" src="{{{ URL::asset('static/images/dot_red.png') }}} ">
                <img class="dot" src="{{{ URL::asset('static/images/dot.png') }}} ">
                <img class="dot" src="{{{ URL::asset('static/images/dot.png') }}} ">
            </div>
        </div>
        <ul class="gallery">
                <li><img src="{{{ URL::asset('static/images/album_one.jpg') }}} "></li>
                <li><img src="{{{ URL::asset('static/images/album_two.jpg') }}} "></li>
                <li><img src="{{{ URL::asset('static/images/album_three.jpg') }}} "></li>
        </ul>

        </div>

    </div>
    <div class="mainmenu">
		<div class="mainmenu_left_menu">
		    <a href="{{{ URL::route('FrontendListByCatagoryId',$catagoriesIndex[0]['id'])}}}" class="mainmenu_title">{{ $catagoriesIndex[0]['catagory']}}</a>
			<div>
				<ol>
                {{--*/ $iconNumber = Config::get('freshman.initIconNumber') /*--}}
                @foreach ($catagoriesIndex[0]['articles'] as $article)
                    <li>
                    @if($iconNumber == Config::get('freshman.iconOne')) <span class="first">1</span>
                    @elseif ($iconNumber == Config::get('freshman.iconTwo')) <span class="second">2</span>
                    @elseif ($iconNumber == Config::get('freshman.iconThree')) <span class="third">3</span>
					@else <span>&nbsp;</span>
                    @endif
                        <a href="{{{ URL::route('FrontendShowArticle',array($catagoriesIndex[0]['id'],$article['id']))}}}">&nbsp;&nbsp;{{ $article['title']}}</a>
                    </li>
                {{--*/ if($iconNumber == Config::get('freshman.initShowArticleNumber')) break /*--}}
                {{--*/ $iconNumber++; /*--}}
                @endforeach
				</ol>
			</div>
        </div>
		<div class="mainmenu_center_menu">
		    <a href="{{{ URL::route('FrontendListByCatagoryId',$catagoriesIndex[1]['id'])}}}" class="mainmenu_title">{{ $catagoriesIndex[1]['catagory']}}</a>
			<div>
				<ol>
                {{--*/ $iconNumber = Config::get('freshman.initIconNumber') /*--}}
                @foreach ($catagoriesIndex[1]['articles'] as $article)
                    <li>
                    @if($iconNumber == Config::get('freshman.iconOne')) <span class="first">1</span>
                    @elseif ($iconNumber == Config::get('freshman.iconTwo')) <span class="second">2</span>
                    @elseif ($iconNumber == Config::get('freshman.iconThree')) <span class="third">3</span>
					@else <span>&nbsp;</span>
                    @endif
                        <a href="{{{ URL::route('FrontendShowArticle',array($catagoriesIndex[1]['id'],$article['id']))}}}">&nbsp;&nbsp;{{ $article['title']}}</a>
                    </li>
                {{--*/ if($iconNumber == Config::get('freshman.initShowArticleNumber')) break /*--}}
                {{--*/ $iconNumber++; /*--}}
                @endforeach
				</ol>
			</div>
        </div>
		<div class="mainmenu_right_menu">
		    <a href="{{{ URL::route('FrontendListByCatagoryId',$catagoriesIndex[2]['id'])}}}" class="mainmenu_title">{{ $catagoriesIndex[2]['catagory']}}</a>
			<div>
				<ol>
                {{--*/ $iconNumber = Config::get('freshman.initIconNumber') /*--}}
                @foreach ($catagoriesIndex[2]['articles'] as $article)
                    <li>
                    @if($iconNumber == Config::get('freshman.iconOne')) <span class="first">1</span>
                    @elseif ($iconNumber == Config::get('freshman.iconTwo')) <span class="second">2</span>
                    @elseif ($iconNumber == Config::get('freshman.iconThree')) <span class="third">3</span>
					@else <span>&nbsp;</span>
                    @endif
                        <a href="{{{ URL::route('FrontendShowArticle',array($catagoriesIndex[2]['id'],$article['id']))}}}">&nbsp;&nbsp;{{ $article['title']}}</a>
                    </li>
                {{--*/ if($iconNumber == Config::get('freshman.initShowArticleNumber')) break /*--}}
                {{--*/ $iconNumber++; /*--}}
                @endforeach
				</ol>
			</div>
        </div>
    </div>
    <div class="photo">
        <a href=""><img class="photo_download" src="{{{ URL::asset('static/images/13.png') }}} " alt=""></a>
    </div>
    <div class="picture">
     <div class="picture1">
       <img class="gray_pic" src="{{{ URL::asset('static/images/photoOne.jpg') }}} " >
       <img class="gray_pic" src="{{{ URL::asset('static/images/photoTwo.jpg') }}} " >
       <img class="gray_pic" src="{{{ URL::asset('static/images/photoThree.jpg') }}} " >
     </div>
     <div class="picture2">
       <img class="gray_pic" src="{{{ URL::asset('static/images/photoOne.jpg') }}} " >
       <img class="gray_pic" src="{{{ URL::asset('static/images/photoTwo.jpg') }}} " >
       <img class="gray_pic" src="{{{ URL::asset('static/images/photoThree.jpg') }}} " >
     </div>
     <div class="picture3">
       <img class="gray_pic" src="{{{ URL::asset('static/images/photoOne.jpg') }}} " >
       <img class="gray_pic" src="{{{ URL::asset('static/images/photoTwo.jpg') }}} " >
       <img class="gray_pic" src="{{{ URL::asset('static/images/photoThree.jpg') }}} " >
       </div>
    </div>
    <br>
    @include('Front.Modules.Footer')
@stop

@section('scripts') @parent
<script type="text/javascript" src="{{{ URL::asset('static/js/index.js')}}}"></script>
@stop
