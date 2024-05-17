@extends('home.layouts.master')
@section('main')
    <!-- Start main-content -->
    <div class="main-content" id="app">
        <!-- Section: slider -->
        <section class="inner-header divider parallax overlay-white-8"
                 style="{{Setting::get('homeTheme') == 'v3' ? 'background: #100e16':'background: radial-gradient(600px circle at 50% 0,#263a5d,#131314)'}}">
            <div class="container pt-100 pb-50">
                <!-- Section Content -->
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-8 col-sm-12 mt-50">
                            <h2 class="title text-white text-right">{{Setting::get('title')}}</h2>
                            <h4 class="text-right text-yellow mt-50">{{Setting::get('description')}}</h4>
                            <div class="input-group mt-60 col-md-6 col-sm-12">
                                <input type="text" class="form-control form-control-lg" placeholder="ایمیل...">
                                <a href="" class="btn btn-warning input-group-addon">
                                    ثبت نام
                                </a>
                            </div>
                            <div class="col-md-12 mt-60" style="display: flex">
                                <div class="ml-25 social-parent">
                                    <a class="social-a"
                                       href="#" style="background-image: url('/Home4/img/appStore.svg')"></a>
                                </div>
                                <div class="ml-25 social-parent">
                                    <a class="social-a"
                                       href="#" style="background-image: url('/Home4/img/googlePlay.svg')"></a>
                                </div>
                                <div class="ml-25 social-parent">
                                    <a class="social-a"
                                       href="#" style="background-image: url('/Home4/img/api.svg')"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mt-50">
                            <img src="{{asset('Home4/img/zero-fee.png')}}"
                                 style="height: 460px;width: 460px;position: absolute;top: 80px;left:15px;animation: Spotlight_fadeIn__zRp7x .3s ease-in;">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <livewire:home.slider/>

        <section id="reservation" class="divider parallax"
                 data-bg-img="" data-parallax-ratio="0.7"
                 style="background-image:background-position: 50% 121px;">
            <div class="container pt-10 pb-0">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-50">
                                <h3 class="font-28 font-weight-600 mt-0 mb-20">اطلاعات بازارها</h3>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title text-right">
                                            جدیدترین بازار ها
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <ul class="">
                                            @foreach($latestMarket as $latest)
                                                <li style="display: flex; justify-content: space-between">
                                                    <img src="{{$latest->currencyBuyer?->icon_url}}"
                                                         alt="{{$latest->symbol}}" width="50" height="50">
                                                    <div>
                                                        <p>
                                                            {{$latest->symbol}}
                                                        </p>
                                                        <p class="font-weight-900">
                                                            {{$latest->price}}
                                                        </p>
                                                    </div>
                                                    <p class="{{$latest->change_24 < 0 ? 'text-danger' : 'text-success'}} font-weight-900">
                                                        {{$latest->change_24}}
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title text-right">
                                            بیشترین نوسان مثبت
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <ul class="">
                                            @foreach($gainersMarket as $gainer)
                                                <li style="display: flex; justify-content: space-between">
                                                    <img src="{{$gainer->icon_url}}"
                                                         alt="{{$gainer->symbol}}" width="50" height="50">
                                                    <div>
                                                        <p>
                                                            {{$gainer->symbol}}
                                                        </p>
                                                        <p class="font-weight-900">
                                                            {{$gainer->price}}
                                                        </p>
                                                    </div>
                                                    <p class="{{$gainer->percent < 0 ? 'text-danger' : 'text-success'}} font-weight-900">
                                                        {{$gainer->percent}}
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title text-right">
                                            بیشترین نوسان منفی
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <ul class="">
                                            @foreach($lossMarket as $loos)
                                                <li style="display: flex; justify-content: space-between">
                                                    <img src="{{$loos->icon_url}}"
                                                         alt="{{$loos->symbol}}" width="50" height="50">
                                                    <div>
                                                        <p>
                                                            {{$loos->symbol}}
                                                        </p>
                                                        <p class="font-weight-900">
                                                            {{$loos->price}}
                                                        </p>
                                                    </div>
                                                    <p class="{{$loos->percent < 0 ? 'text-danger' : 'text-success'}} font-weight-900">
                                                        {{$loos->percent}}
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{--    services--}}
        <section class="inner-header divider parallax overlay-white-8">
            <div class="container pt-60 pb-60">
                <!-- Section Content -->
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-50">
                                <h3 class="font-28 font-weight-600 mt-0 mb-20">خدمات ما</h3>
                            </div>
                        </div>
                        <div class="col-md-12 mx-auto">
                            <div class="col-sm-6 col-md-4">
                                <div class="post icon-box p-30 bg-white bg-hover-theme-colored border-1px text-center">
                                    <div class="media-body">
                                        <a class="icon" href="#">
                                            <img src="home/images/flaticon-png/small/f7.png" alt="" width="64">
                                        </a>
                                        <h3 class="mt-0">ثبت نام</h3>
                                        <p>ثبت نام در کمتر از 1 دقیقه در وب سایت انجام میگردد.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="post icon-box p-30 bg-white bg-hover-theme-colored border-1px text-center">
                                    <div class="media-body">
                                        <a class="icon" href="#">
                                            <img src="home/images/flaticon-png/small/f8.png" alt="" width="64">
                                        </a>
                                        <h3 class="mt-0">ذخیره امن دارایی</h3>
                                        <p>شما می توانید ارزهای دیجیتال خود را در بستری امن نگهداری کنید </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="post icon-box p-30 bg-white bg-hover-theme-colored border-1px text-center">
                                    <div class="media-body">
                                        <a class="icon" href="#">
                                            <img src="home/images/flaticon-png/small/f3.png" alt="" width="64">
                                        </a>
                                        <h3 class="mt-0">تحلیل و معامله</h3>
                                        <p>توسط ابزارهای پیشرفته سایت میتوانید به تحلیل و خرید و فروش ارزها
                                            بپردازید. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="post icon-box p-30 bg-white bg-hover-theme-colored border-1px text-center">
                                    <div class="media-body">
                                        <a class="icon" href="#">
                                            <img src="home/images/map-marker.png" alt="" width="64">
                                        </a>
                                        <h3 class="mt-0">پشتیبانی آنلاین</h3>
                                        <p>در صورت نیاز به پشتیبانی در هر ساعت از شبانه روز می توانید باما در ارتباط
                                            باشید.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="post icon-box p-30 bg-white bg-hover-theme-colored border-1px text-center">
                                    <div class="media-body">
                                        <a class="icon" href="#">
                                            <img src="home/images/flaticon-png/small/f12.png" alt="" width="64">
                                        </a>
                                        <h3 class="mt-0">واریز و برداشت</h3>
                                        <p>واریز و برداشت ارزهای دیجتال و ریال تنها با چند کلیک.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="post icon-box p-30 bg-white bg-hover-theme-colored border-1px text-center">
                                    <div class="media-body">
                                        <a class="icon" href="#">
                                            <img src="home/images/flaticon-png/small/f2.png" alt="" width="64">
                                        </a>
                                        <h3 class="mt-0">بازارها</h3>
                                        <p>تنوع بازارهای جفت ارزها جهت انتخاب بهتر در خرید و فروش و معامله.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="reservation" class="divider parallax"
                 data-bg-img="" data-parallax-ratio="0.7"
                 style="background-image:background-position: 50% 121px;">
            <div class="container pt-10 pb-0">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="mt-50">
                                <h3 class="font-28 font-weight-600 mt-0 mb-20">معاملات آنلان</h3>
                                <div class="diamond-line-left-theme-colored2"></div>
                                <p class="mt-15 mb-30">معاملات آنلاین و 24 ساعته خود را سریع و حرفه ای ارسال کنید</p>
                                <a href="/panel" class="btn btn-block btn-warning mt-20 col-md-8 mx-auto">شروع
                                    معامله</a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <img src="/home/images/photos/p4.png" class="img-fullwidth" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- end main-content -->
@endsection
