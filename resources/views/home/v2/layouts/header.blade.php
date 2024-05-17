<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{Setting::get('title')}}</title>


    <link rel="stylesheet" type="text/css" href="/Home3/css/plugins.css">
    <link rel="stylesheet" type="text/css" href="/Home3/css/theme-styles.css">
    <link rel="stylesheet" type="text/css" href="/Home3/css/blocks.css">
    <link rel="stylesheet" type="text/css" href="/Home3/css/widgets.css">
    <link rel="stylesheet" type="text/css" href="/Home3/css/font-awesome.css">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700i,900," rel="stylesheet">


    <!--Styles for RTL-->

    <link rel="stylesheet" type="text/css" href="/Home3/css/rtl.css">
    <link rel="stylesheet" type="text/css" href="/Home3/fonts/iranyekan/css/style.css">


    <!-- Favicon and Touch Icons -->
    <link href="{{asset(Setting::get('favicon'))}}" rel="shortcut icon" type="image/png">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon" sizes="72x72">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{asset(Setting::get('favicon'))}}" rel="apple-touch-icon" sizes="144x144">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}
    @livewireStyles
</head>
<body class="crumina-grid">

<!-- Preloader -->

<!--<div id="hellopreloader">
	<div class="preloader">
		<svg width="135" height="140" fill="#fff">
			<rect width="15" height="120" y="10" rx="6">
				<animate attributeName="height" begin="0.5s" calcMode="linear" dur="1s" repeatCount="indefinite" values="120;110;100;90;80;70;60;50;40;140;120" />
				<animate attributeName="y" begin="0.5s" calcMode="linear" dur="1s" repeatCount="indefinite" values="10;15;20;25;30;35;40;45;50;0;10" />
			</rect>
			<rect width="15" height="120" x="30" y="10" rx="6">
				<animate attributeName="height" begin="0.25s" calcMode="linear" dur="1s" repeatCount="indefinite" values="120;110;100;90;80;70;60;50;40;140;120" />
				<animate attributeName="y" begin="0.25s" calcMode="linear" dur="1s" repeatCount="indefinite" values="10;15;20;25;30;35;40;45;50;0;10" />
			</rect>
			<rect width="15" height="140" x="60" rx="6">
				<animate attributeName="height" begin="0s" calcMode="linear" dur="1s" repeatCount="indefinite" values="120;110;100;90;80;70;60;50;40;140;120" />
				<animate attributeName="y" begin="0s" calcMode="linear" dur="1s" repeatCount="indefinite" values="10;15;20;25;30;35;40;45;50;0;10" />
			</rect>
			<rect width="15" height="120" x="90" y="10" rx="6">
				<animate attributeName="height" begin="0.25s" calcMode="linear" dur="1s" repeatCount="indefinite" values="120;110;100;90;80;70;60;50;40;140;120" />
				<animate attributeName="y" begin="0.25s" calcMode="linear" dur="1s" repeatCount="indefinite" values="10;15;20;25;30;35;40;45;50;0;10" />
			</rect>
			<rect width="15" height="120" x="120" y="10" rx="6">
				<animate attributeName="height" begin="0.5s" calcMode="linear" dur="1s" repeatCount="indefinite" values="120;110;100;90;80;70;60;50;40;140;120" />
				<animate attributeName="y" begin="0.5s" calcMode="linear" dur="1s" repeatCount="indefinite" values="10;15;20;25;30;35;40;45;50;0;10" />
			</rect>
		</svg>

		<div class="text">Loading ...</div>
	</div>
</div>-->

<!-- ... end Preloader -->

<!-- Header -->

<header class="header" id="site-header">
    <div class="container">
        <div class="header-content-wrapper">
            <a href="/" class="site-logo">
                <img src="{{asset(Setting::get('logo'))}}" alt="{{Setting::get('title')}}" height="50"
                     style="height: 50px">
                {{Setting::get('title')}}
            </a>

            <nav id="primary-menu" class="primary-menu">

                <!-- menu-icon-wrapper -->

                <a href='javascript:void(0)' id="menu-icon-trigger" class="menu-icon-trigger showhide">
                    <span class="mob-menu--title">منو</span>
                    <span id="menu-icon-wrapper" class="menu-icon-wrapper" style="">
						<svg width="1000px" height="1000px">
							<path id="pathD"
                                  d="M 300 400 L 700 400 C 900 400 900 750 600 850 A 400 400 0 0 1 200 200 L 800 800"></path>
							<path id="pathE" d="M 300 500 L 700 500"></path>
							<path id="pathF"
                                  d="M 700 600 L 300 600 C 100 600 100 200 400 150 A 400 380 0 1 1 200 800 L 800 200"></path>
						</svg>
					</span>
                </a>

                <ul class="primary-menu-menu">

                    <li>
                        <a href="/">خانه</a>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">رمز ارزها</a>
                        <ul class="sub-menu">
                            <li class="menu-item-has-children">
                                <a href="{{url('panel')}}">
                                    خرید و فروش
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{route('home.page.show',['page'=>'سوالات-متداول'])}}">سوالات متداول</a>
                    </li>
                    <li>
                        <a href="{{route('home.page.show',['page'=>'قوانین-و-مقررات'])}}">قوانین و مقررات</a>
                    </li>
                    <li>
                        <a href="{{url('/blog')}}">وبلاگ</a>
                    </li>
                    <li>
                        <a href="{{route('home.page.show',['page'=>'درباره-ما'])}}">درباره ما</a>
                    </li>
                    <li>
                        <a href="{{route('home.page.show',['page'=>'تماس-با-ما'])}}">تماس با ما</a>
                    </li>
                </ul>


            </nav>
            @auth
                <a href="/panel" class="btn btn-info" style="font-weight: 500">{{Auth::user()->name}}</a>
            @else
                <a href="/panel" class="btn btn-info" style="font-weight: 500">ورود/ثبت نام</a>
            @endauth

        </div>
    </div>
</header>

<!-- ... end Header -->


