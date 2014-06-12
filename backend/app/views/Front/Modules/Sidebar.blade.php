<div class="sidebar">
    <? $cataNum = $_ENV['INIT_CATA_NUM_INDEX'] ?>
    @foreach($catagoriesList as $catagory)
    @if( $cataNum != $_ENV['NEWEST_INFORMATION_INDEX'] && $catagory['id'] !== $chooseCatagoryId)
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
    <? $cataNum++ ?>
    @endforeach

    @if($catagoriesList[$_ENV['NEWEST_INFORMATION_INDEX']]['id'] !== $chooseCatagoryId)
			<div class="form_box">
				<h1>
                    {{ $catagoriesList[$_ENV['NEWEST_INFORMATION_INDEX']]['catagory']}}&nbsp;HOT&nbsp;NEWS<span  class="special_more">
                    <a href="{{{ URL::route('FrontendListByCatagoryId',$catagoriesList[$_ENV['NEWEST_INFORMATION_INDEX']]['id'])}}}">MORE</a></span>
				</h1>
				<ul class="list_box">
                    <? $iconNumber = $_ENV['INIT_ICON_NUMBER'] ?>
                    @foreach($catagoriesList[$_ENV['NEWEST_INFORMATION_INDEX']]['articles'] as $article)
                    @if($iconNumber == $_ENV['ICON_ONE'])<li id="list_boxFirst"><span class="first">1</span>
                    @elseif($iconNumber == $_ENV['ICON_TWO'])<li><span class="second">2</span>
                    @elseif($iconNumber == $_ENV['ICON_THREE'])<li><span class="third">3</span>
                    @else <li><span>&nbsp;</span>
                    @endif
                        <a href="{{{ URL::route('FrontendShowArticle',array($catagories[$_ENV['NEWEST_INFORMATION_INDEX']]['id'],$article['id']))}}}">{{ $article['title']}}</a>
						<p>发布时间：{{ $article['created_at']}}</p>
					</li>
                    <? $iconNumber++ ?>
                    @endforeach
				</ul>
			</div>
        @endif
		</div>

