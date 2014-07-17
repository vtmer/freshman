@extends('Front.Template.Front')

@section('title')
        {{ $article['title']}} -- 广工大新生网
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
                    {{ $currentCatagory['catagory']}}
			</p>
			<div class="contain_passage">
				 <div class="contain_passage_header">
                	<h1>{{ $article['title']}}</h1>
                	<p class="contain_p">
                		发布时间：{{ $article['created_at'] }}&nbsp;&nbsp;&nbsp;&nbsp;来源：广东工业大学校团委新媒体
                	</p>
                </div>
                <p>
                    {{ $article['content']}}
                </p><br />
                <div class="bshare-custom">分享到：
                    <a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a>
                    <a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a>
                    <a title="分享到网易微博" class="bshare-neteasemb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a>
                    <span class="BSHARE_COUNT bshare-share-count">0</span>
                </div>
                <script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=771c5856-d516-4aff-a0eb-6f7b3680c20c&amp;pophcol=3&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
                <p class="nav1">
                	<span class="relative">
                		&nbsp;
                	</span>
                	相关文章
                </p>
                <ul class="list">
                @foreach($catagoriesList as $catagory)
                @if($catagory['id'] == $currentCatagory['id'])
                    {{--*/  $relevance = Config::get('freshman.initRelevanceNumber'); /*--}}
                    @foreach($catagory['articles'] as $otherArticle)
                    @if($article['id'] !== $otherArticle['id'])
                    <li><a href="{{{ URL::route('FrontendShowArticle',array($currentCatagory['id'],$otherArticle['id']))}}}">{{ $otherArticle['title']}}</a></li>
                    {{--*/  $relevance++; /*--}}
                    @endif
                    {{--*/ if($relevance == Config::get('freshman.relevanceNumber')) break; /*--}}
                    @endforeach
                @endif
                @endforeach
                </ul>
			</div>
			<div>
			    <div class="ds-thread" data-thread-key="{{ $article['id'] }}" data-title="{{ $article['title'] }}"
					data-url="{{{ URL::route('FrontendShowArticle',array($currentCatagory['id'],$article['id']))}}} ">
				</div>
				<script type="text/javascript">
					var duoshuoQuery = {short_name:"freshman-vtmer"};
						(function() {
							var ds = document.createElement('script');
							ds.type = 'text/javascript';ds.async = true;
							ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
							ds.charset = 'UTF-8';
							(document.getElementsByTagName('head')[0]
							 || document.getElementsByTagName('body')[0]).appendChild(ds);
						})();
				</script>
			</div>
		</div>
    @include('Front.Modules.Sidebar')
</div>
    @include('Front.Modules.Footer')
@stop


@section('scripts') @parent
<script type="text/javascript" src="{{{ URL::asset('static/js/content.js')}}}"></script>
@stop
