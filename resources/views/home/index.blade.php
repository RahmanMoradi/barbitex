@extends('home.layouts.master')
@section('main')
    <!-- Start main-content -->
    <div class="main-content" id="app">
        <!-- Section: slider -->
        <section class="inner-header divider parallax overlay-white-8"
                 style="background: radial-gradient(600px circle at 50% 0,#263a5d,#131314)">
            <div class="container pt-100 pb-50">
                <!-- Section Content -->
                <div class="section-content">
                    <div class="row">
                        <div class="col-8 mx-auto text-center">
                            <h2 class="title text-white">{{Setting::get('title')}}</h2>
                            <p>{{Setting::get('description')}}</p>
                        </div>
                    </div>
                    <livewire:home.slider/>
                </div>
            </div>
            @if ($isMarket)
                <currency-slide :markets="{{$marketsHome}}"
                                :ismarket="{{$isMarket}}"
                                channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"
                                marketnamefa="{{Setting::get('marketNameFa')}}"></currency-slide>
            @else
                <livewire:home.markets/>
            @endif

        </section>
        @if (Setting::get('homeCalculator'))
            <livewire:home.calculator/>
        @endif
        @if ($isMarket)
            <currency-table :markets="{{$marketsTable}}"
                            :ismarket="{{$isMarket}}"
                            channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"
                            marketnamefa="{{Setting::get('marketNameFa')}}"
                            usdtsell="{{Setting::get('dollar_sell_pay')}}"
                            sellpercent="{{Setting::get('currency_uy_pay_percent')}}"
                            usdtbuy="{{Setting::get('dollar_buy_pay')}}"
                            buypercent="{{Setting::get('currency_buy_pay_percent')}}"
                            homechart="{{Setting::get('homeChart')}}"></currency-table>
        @else
            <livewire:home.markets-table/>
        @endif
        {{--    services--}}
        <section class="inner-header divider parallax overlay-white-8">
            <div class="container pt-60 pb-60">
                <!-- Section Content -->
                <div class="section-content">
                    <div class="row">
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
