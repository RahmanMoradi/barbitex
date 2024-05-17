<!DOCTYPE html>
<html dir="ltr" lang="fa">
<head>

    <!-- Meta Tags -->
    {{--    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>--}}
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="{{Setting::get('meta_description')}}"/>
    <meta name="keywords"
          content="{{Setting::get('meta_key')}}"/>
    <meta name="author" content="webazin.net"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- عنوان صفحه -->
    <title>{{Setting::get('title')}}</title>

    <!-- Favicon and Touch Icons -->
    <link href="{{asset(Setting::get('favicon'))}}" rel="shortcut icon" type="image/png">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon" sizes="72x72">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon" sizes="144x144">

    <!-- Stylesheet -->
    <link href="/home/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/home/css/bootstrap-rtl.min.css" rel="stylesheet"/>
    <link href="/home/css/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <link href="/home/css/animate.css" rel="stylesheet" type="text/css">
    <link href="/home/css/css-plugin-collections.css" rel="stylesheet"/>
    <!-- CSS | menuzord megamenu skins -->
    <link href="/home/css/menuzord-megamenu-rtl.css" rel="stylesheet"/>
    <link id="menuzord-menu-skins" href="/home/css/menuzord-skins/menuzord-boxed.css" rel="stylesheet"/>
    <!-- CSS | Main style file -->
    <link href="/home/css/style-main-rtl.css" rel="stylesheet" type="text/css">
    <!-- CSS | Preloader Styles -->
    <link href="/home/css/preloader.css" rel="stylesheet" type="text/css">
    <!-- CSS | Custom Margin Padding Collection -->
    <link href="/home/css/custom-bootstrap-margin-padding.css" rel="stylesheet" type="text/css">
    <!-- CSS | Responsive media queries -->
    <link href="/home/css/responsive.css" rel="stylesheet" type="text/css">
    <!-- CSS | Style css. This is the file where you can place your own custom css code. Just uncomment it and use it. -->
    <!-- <link href="/home/css/style.css" rel="stylesheet" type="text/css"> -->

    <!-- Revolution Slider 5.x CSS settings -->
    <link href="/home/js/revolution-slider/css/settings.css" rel="stylesheet" type="text/css"/>
    <link href="/home/js/revolution-slider/css/layers.css" rel="stylesheet" type="text/css"/>
    <link href="/home/js/revolution-slider/css/navigation.css" rel="stylesheet" type="text/css"/>

    <!-- CSS | Theme Color -->
    <link href="/home/css/colors/theme-skin-color-set2.css" rel="stylesheet" type="text/css">

    <!-- external javascripts -->
    <script src="/home/js/jquery-2.2.4.min.js"></script>
    <script src="/home/js/jquery-ui.min.js"></script>
    <script src="/home/js/bootstrap.min.js"></script>
    <!-- JS | jquery plugin collection for this theme -->
    <script src="/home/js/jquery-plugin-collection.js"></script>

    <!-- Revolution Slider 5.x SCRIPTS -->
    <script src="/home/js/revolution-slider/js/jquery.themepunch.tools.min.js"></script>
    <script src="/home/js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    @livewireStyles
    <![endif]-->
    {{--    TODO SEO TOOLS--}}
    {!! Setting::get('script') !!}
</head>
<body class="rtl">
<div id="wrapper">
    <!-- preloader -->
{{--    <div id="preloader">--}}
{{--        <div id="spinner">--}}
{{--            <div class="preloader-dot-loading">--}}
{{--                <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div id="disable-preloader" class="btn btn-default btn-sm">Disable Preloader</div>--}}
{{--    </div>--}}

<!-- Header -->
    <header id="header" class="header header-floating {{Setting::get('homeTheme') == 'v3' ? 'bg-black':''}}">
        <div class="header-nav navbar-sticky navbar-sticky-animated">
            <div class="header-nav-wrapper">
                <div class="container">
                    <nav id="menuzord-right" class="menuzord blue no-bg">
                        <a class="menuzord-brand switchable-logo pull-left flip mb-15" href="/">
                            <img class="logo-default" src="{{asset(Setting::get('logo'))}}" alt="">
                            <img class="logo-scrolled-to-fixed" src="{{asset(Setting::get('logo'))}}" alt="">
                        </a>
                        <ul class="menuzord-menu">
                            <li>
                                <a href="#"> بازار ها</a>
                                <ul class="dropdown">
                                    @if(\App\Helpers\Helper::modules()['orderPlane'])
                                        <li><a href="/panel/order/create">بازار ساده</a></li>
                                    @endif
                                    <li><a href="/market">بازار حرفه ای</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{route('home.page.show',['page' => 'راهنمای-استفاده'])}}">راهنمای استفاده</a>
                            </li>
                            <li>
                                <a href="{{route('home.page.show',['page' => 'کارمزد'])}}">کارمزد</a>
                            </li>
                            <li>
                                <a href="{{route('home.page.show',['page' => 'سوالات-متداول'])}}">سوالات متداول</a>
                            </li>
                            <li>
                                <a href="{{route('home.page.show',['page' => 'قوانین-و-مقررات'])}}">قوانین</a>
                            </li>
                            @if (\App\Helpers\Helper::modules()['application'])
                                <li>
                                    <a href="{{route('home.page.show',['page' => 'دانلود-اپلیکیشن'])}}">دانلود اپ</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{route('home.blog')}}">وبلاگ</a>
                            </li>
                            <li>
                                <a href="{{route('home.page.show',['page' => 'درباره-ما'])}}">درباره ما</a>
                            </li>
                            <li>
                                <a href="{{route('home.page.show',['page' => 'تماس-با-ما'])}}">تماس با ما</a>
                            </li>
                            <li>
                                @guest()
                                    <a href="/panel" class="btn btn-info">ورود/ثبت نام</a>
                                @else
                                    <a href="/panel" class="btn btn-info">پنل کاربری</a>
                                @endguest
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
