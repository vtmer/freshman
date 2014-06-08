<div class="sidebar">
    <?php $j =1 ?>
    @foreach($catagoriesList as $catagory)
    @if( $j != 4)
	@if($catagory['id'] !== $chooseCatagoryId)
			<div class="form">
				<h1 class="title">
					{{ $catagory['catagory'] }}
					<span  class="special_more" ><a href="{{{ URL::route('FrontendListByCatagoryId',$catagory['id']) }}}">MORE</a></span>
				</h1>
					<ul class="list_box">
                    @if(isset($catagory['articles'][0]))
                    <li><span class="first">1</span>
							<a href="{{{ URL::route('FrontendShowArticle',array($catagory['id'],$catagory['articles'][0]['id']))}}}">{{ $catagory['articles'][0]['title'] }}</a>
						  </li>
                    @endif
                    @if(isset($catagory['articles'][1]))
					<li><span class="second">2</span>
							<a href="{{{ URL::route('FrontendShowArticle',array($catagory['id'],$catagory['articles'][1]['id']))}}}">{{ $catagory['articles'][1]['title'] }}</a>
						  </li>
                    @endif
                    @if(isset($catagory['articles'][2]))
					<li><span class="third">3</span>
							<a href="{{{ URL::route('FrontendShowArticle',array($catagory['id'],$catagory['articles'][2]['id']))}}}">{{ $catagory['articles'][2]['title'] }}</a>
						  </li>
                    @endif
                    @if(isset($catagory['articles'][3]))
					<li id="lineNone"><span>&nbsp;</span>
							<a href="{{{ URL::route('FrontendShowArticle',array($catagory['id'],$catagory['articles'][3]['id']))}}}">{{ $catagory['articles'][3]['title'] }}</a>
						  </li>
                    @endif
					</ul>
			</div>
            <br />
	@endif
    @endif
    <?php $j++; ?>
    @endforeach

    @if($catagoriesList[3]['id'] !== $chooseCatagoryId)
			<div class="form_box">
				<h1>
                    {{ $catagoriesList[3]['catagory']}}&nbsp;HOT&nbsp;NEWS<span  class="special_more">
                            <a href="{{{ URL::route('FrontendListByCatagoryId',$catagoriesList[3]['id'])}}}">MORE</a></span>
				</h1>
				<ul class="list_box">
                    <?php $i = 1; ?>
                    @foreach($catagoriesList[3]['articles'] as $article)
                    @if($i == 1)<li id="list_boxFirst"><span class="first">1</span>
                    @elseif($i == 2)<li><span class="second">2</span>
                    @elseif($i == 3)<li><span class="third">3</span>
                    @else <li><span>&nbsp;</span>
                    @endif
						<a href="{{{ URL::route('FrontendShowArticle',array($catagories[3]['id'],$article['id']))}}}">{{ $article['title']}}</a>
						<p>发布时间：{{ $article['created_at']}}</p>
					</li>
                    <?php $i++; ?>
                    @endforeach
				</ul>
			</div>
        @endif
		</div>

