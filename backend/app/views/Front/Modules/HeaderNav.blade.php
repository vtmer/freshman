<div class="logo">
<div class="logoWrapper">
<a href="{{{ URL::route('FrontendIndex')}}}" class="homelink" title="首页"></a>
<ul class="nav">
    <li class="default"><a href="{{{ URL::route('FrontendIndex')}}}" class="controlSpace">首页</a></li>
    @foreach($catagories as $catagory)
    <li><a href="{{{ URL::route('FrontendListByCatagoryId',$catagory['id']) }}}">{{ $catagory['catagory']}}</a></li>
    @endforeach
    <li class="special_li"><a class="special_a" href="{{{ URL::route('FrontendIndexBySchoolPart',$schoolParts[0]['id'])}}}">{{ $schoolParts[0]['schoolpart']}}</a>
        <ul class="special_down">
            <li><a href="{{{ URL::route('FrontendIndexBySchoolPart',$schoolParts[0]['id'])}}}">{{ $schoolParts[1]['schoolpart'] }}</a></li>
            <li><a href="{{{ URL::route('FrontendIndexBySchoolPart',$schoolParts[0]['id'])}}}">{{ $schoolParts[2]['schoolpart'] }}</a></li>
        </ul>
    </li>
</ul>
</div>
<div class="line"></div>
</div>
