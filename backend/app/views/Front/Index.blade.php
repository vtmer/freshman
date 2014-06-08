@extends ('Front.Template.Front')

@section('title')
广工大新生网--你的广工指南
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
            <?php $i = 1; ?>
            @foreach ($catagoriesIndex as $catagory)
            @if($i == 4)
                <div>
                    <a href="{{{ URL::route('FrontendListByCatagoryId',$catagory['id'])}}}">{{ $catagory['catagory']}}</a>
                    <span><a href="">HOT NEWS</a></span>
                    <span class="special_more"><a href="{{{ URL::route('FrontendListByCatagoryId',$catagory['id'])}}}">MORE</a></span>
                </div>
                <?php $j = 1; ?>
                @foreach ($catagory['articles'] as $article)
                    <p>
                        <a href="{{{ URL::route('FrontendShowArticle',array($catagory['id'],$article['id']))}}}">{{ $article['title']}}</a>
                    @if($j == 1) <span class="icon_one">1</span>
                    @elseif ($j == 2) <span class="icon_two">2</span>
                    @elseif ($j == 3) <span class="icon_three">3</span>
                    @endif
                        <span class="date1"><a href="">发布时间:{{ $article['created_at']}}</a></span>
                    </p>
                <?php $j++; ?>
                @endforeach
            @endif
            <?php $i++; ?>
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
			<?php $i = 1; ?>
            @foreach ($catagoriesIndex as $catagory)
            @if($i !== 4)
				@if ($i == 1) <div class="mainmenu_left_menu">
				@elseif ($i == 2) <div class="mainmenu_center_menu">
				@else <div class="mainmenu_right_menu">
				@endif
		        	<a href="{{{ URL::route('FrontendListByCatagoryId',$catagory['id'])}}}" class="mainmenu_title">{{ $catagory['catagory']}}</a>
		        <?php $j = 1; ?>
				<div>
				<ol>
                @foreach ($catagory['articles'] as $article)
                    <li>
                    @if($j == 1) <span class="first">1</span>
                    @elseif ($j == 2) <span class="second">2</span>
                    @elseif ($j == 3) <span class="third">3</span>
					@else <span>&nbsp;</span>
                    @endif
                        <a href="{{{ URL::route('FrontendShowArticle',array($catagory['id'],$article['id']))}}}">&nbsp;&nbsp;{{ $article['title']}}</a>
                    </li>
                <?php $j++; ?>
                @endforeach
				</ol>
				</div>
            @endif
            <?php $i++; ?>
            </div>
            @endforeach
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
