@extends ('mobile.Base')

@section('title')
    {{ $article['title'] }} --  {{ Config::get('freshman.freshmanTitle')}}
@stop

@section('container')
<div class="nav">
@include('mobile.Component.nav')
</div>
<div class="passage">
    <div class="passage-main">
        <div class="passage-title">
            <h3>{{ $article['title']}}</h3>
            <div class="passage-info">
                <div class="passage-time">
                    <span>发布时间：</span>
                    <span>{{ $article['created_at'] }}</span>
                </div>
                <div class="passage-source">
                    <span>来源：</span>
                    <span{{ $article['source'] }}</span>
                </div>
            </div>
        </div>
        <div class="passage-body">
            {{ $article['content'] }}
        </div>
        <div class="passage-turning">
            <ul class="turning-list">
                <li class="turning-item">
                    @if(isset($lastArticle['id']))
                    <a href="{{{ URL::route('FrontendShowArticle',array($headerChoose,$lastArticle['id']))}}}">上一篇：{{{ $lastArticle['title']}}}</a>
                    @else
                        <a href="javascript:void();">上一篇：没有了</a>
                    @endif
                </li>
                <li class="turning-item">
                    @if(isset($nextArticle['id']))
                    <a href="{{{ URL::route('FrontendShowArticle',array($headerChoose,$nextArticle['id']))}}}">下一篇：{{{ $nextArticle['title']}}}</a>
                    @else
                        <a href="javascript:void();">下一篇：没有了</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
    <div class="passage-comment">
        <div class="passage-comment-title">
            <h3>热门评论</h3>
        </div>
        <div class="comment-main">
			<div>
			    <div class="ds-thread" data-thread-key="{{ $article['id'] }}" data-title="{{ $article['title'] }}"
					data-url="{{{ URL::route('FrontendShowArticle',array($headerChoose,$article['id']))}}} ">
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
        <div class="comment-btn"><a href="">我要评论</a></div>
    </div>
</div>
@stop
