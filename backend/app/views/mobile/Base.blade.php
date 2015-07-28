<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '广工新生专题网')</title>
    <link rel="stylesheet" href="{{{ URL::asset('static/css/m-index.css') }}}">
    <script src="{{{ URL::asset('static/js/jQuery.js') }}}"></script>
    <script src="{{{ URL::asset('static/js/jquery.plugins-min.js') }}}"></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="brand">
                <div class="logo"><img src="{{{ URL::asset('static/images/m-logo.png') }}}" alt=""></div>
                <h3 class="title">广工新生专题网</h3>
            </div>
            <div class="campus-changes">
                <ul class="campus-list">
                    <li class="campus-item active"><a href="{{{ URL::route('FrontendIndexBySchoolPart',$schoolParts[0]['id'])}}}">{{ $schoolParts[0]['schoolpart']}}<span>▼</span></a></li>
                    <li class="campus-item"><a href="{{{ URL::route('FrontendIndexBySchoolPart',$schoolParts[1]['id'])}}}">{{ $schoolParts[1]['schoolpart'] }}</a></li>
                    <li class="campus-item"><a href="{{{ URL::route('FrontendIndexBySchoolPart',$schoolParts[2]['id'])}}}">{{ $schoolParts[2]['schoolpart'] }}</a></li>
                </ul>
            </div>
        </div>
        @yield('container')
        <div class="footer">
            <div class="footer-design">版权归vtmer所有</div>
        </div>
    </div>
    <script src="{{{ URL::asset('static/js/m-index.js') }}}"></script>
    <script src="{{{ URL::asset('static/js/carousel.js') }}}"></script>
</body>
</html>
