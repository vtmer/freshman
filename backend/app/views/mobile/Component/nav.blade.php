<div class="navbar-nav">
    <ul class="nav-list">
        <li class="nav-item @if($headerChoose == Config::get('freshman.chooseIndex')) active @endif "><a href="{{{ URL::route('FrontendIndex')}}}">首页</a></li>
        @for($i = 0; $i < count($catagories) - 1; $i++)
        <li class="nav-item @if($headerChoose == $catagories[$i]['id']) active @endif">
            <a href="{{{ URL::route('FrontendListByCatagoryId',$catagories[$i]['id']) }}}">{{ $catagories[$i]['catagory']}}</a>
        </li>
        @endfor
    </ul>
</div>
