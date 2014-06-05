<div class="logo">
<div class="logoWrapper">
<a href="./" class="homelink" title="首页"></a>
<ul class="nav">
    <li class="default"><a href="" class="controlSpace">首页</a></li>
    @foreach($catagories as $catagory)
    <li><a href="">{{ $catagory['catagory']}}</a></li>
    @endforeach
    <?php $i = 1; ?>
    @foreach($schoolParts as $schoolPart)
    @if ($i == 1)
    <li class="special_li"><a class="special_a" href="{{{ URL::route('FrontendIndexBySchoolPart',$schoolPart['id'])}}}">{{ $schoolPart['schoolpart']}}</a>
    @elseif ($i == 2)
        <ul class="special_down">
            <li><a href="{{{ URL::route('FrontendIndexBySchoolPart',$schoolPart['id'])}}}">{{ $schoolPart['schoolpart'] }}</a></li>
    @else
            <li><a href="{{{ URL::route('FrontendIndexBySchoolPart',$schoolPart['id'])}}}">{{ $schoolPart['schoolpart'] }}</a></li>
    @endif
    <?php $i += 1; ?>
    @endforeach
        </ul>
    </li>
</ul>
</div>
<div class="line"></div>
</div>
