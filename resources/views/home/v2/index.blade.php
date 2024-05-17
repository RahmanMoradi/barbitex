@extends('home.v2.layouts.master')
@section('main')
    <div class="main-content-wrapper">
        <section data-settings="particles-1"
                 class="main-section crumina-flying-balls particles-js bg-1 medium-padding120 responsive-align-center">
            <div class="container">
                <div class="row">

                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <header class="crumina-module crumina-heading heading--h1 heading--with-decoration">
                            <h1 style="direction: ltr; float: none"
                                class="heading-title f-size-0 weight-normal no-margin">با
                                <span style="direction: ltr; float: none" class="weight-bold"> تاج کوین</span></h1><br>
                            <h2 style="direction: ltr; float: none" class="c-primary">در دنیای رمز ارزها پادشاهی کن</h2>
                        </header>
                        <br>
                        <br>
                        <a data-scroll href="/panel" style="direction: ltr"
                           class="btn btn--large btn--transparent btn--secondary">شروع</a>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <img class="responsive-width-50" src="/Home3/img/main.png" alt="image">
                    </div>
                </div>
            </div>
        </section>

        {{--        <section>--}}
        {{--            <div class="container">--}}
        {{--                <div class="row medium-padding80">--}}
        {{--                    <div id="details" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
        {{--                        <div class="crumina-module crumina-module-slider crumina-slider--info-boxes">--}}
        {{--                            <div class="swiper-btn-wrap">--}}
        {{--                                <div class="swiper-btn-next">--}}
        {{--                                    <svg class="woox-icon icon-line-arrow-right">--}}
        {{--                                        <use xlink:href="#icon-line-arrow-right"></use>--}}
        {{--                                    </svg>--}}
        {{--                                </div>--}}

        {{--                                <div class="swiper-btn-prev">--}}
        {{--                                    <svg class="woox-icon icon-line-arrow-left">--}}
        {{--                                        <use xlink:href="#icon-line-arrow-left"></use>--}}
        {{--                                    </svg>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="swiper-container auto-height" data-show-items="5" data-prev-next="1">--}}
        {{--                                <div class="swiper-wrapper">--}}
        {{--                                    @foreach($marketsHome as $market)--}}
        {{--                                        <div class="swiper-slide">--}}
        {{--                                            <div class="crumina-module crumina-info-box info-box--style2">--}}
        {{--                                                <div class="info-box-thumb">--}}
        {{--                                                    <img src="{{optional($market->currencyBuyer)->iconUrl}}" height="150">--}}
        {{--                                                </div>--}}
        {{--                                                <div class="info-box-content">--}}
        {{--                                                    <h5 class="info-box-title">{{strtoupper($market->symbol)}}</h5>--}}
        {{--                                                    <ul class="pricing-tables-position pricing-tables-position--inline">--}}
        {{--                                                        <li class="position-item">--}}
        {{--                                                            <div class="currency-details-item">--}}
        {{--                                                                <h6 class="title">قیمت: </h6>--}}
        {{--                                                                <h6 class="value">--}}
        {{--                                                                    ${{\App\Helpers\Helper::numberFormatPrecision(optional($market->currencyBuyer)->price,$market->decimal_trade)}}--}}
        {{--                                                                </h6>--}}
        {{--                                                            </div>--}}
        {{--                                                        </li>--}}
        {{--                                                        <li class="position-item">--}}
        {{--                                                            <div class="currency-details-item">--}}
        {{--                                                                <h6 class="title">قیمت / تومان: </h6>--}}
        {{--                                                                <br>--}}
        {{--                                                                <h6 class="value">{{number_format(optional($market->currencyBuyer)->irt_price)}}</h6>--}}
        {{--                                                            </div>--}}
        {{--                                                        </li>--}}
        {{--                                                    </ul>--}}
        {{--                                                    <div--}}
        {{--                                                        class="{{optional($market->currencyBuyer)->percent > 0 ? 'growth' : 'drop'}}">{{optional($market->currencyBuyer)->percent}}--}}
        {{--                                                        %--}}
        {{--                                                    </div>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    @endforeach--}}
        {{--                                </div>--}}
        {{--                            </div>--}}

        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </section>--}}

        <section class="medium-padding100">
            <div class="container">
                <div id="started" class="row align-center">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="crumina-module crumina-module-slider pagination-bottom-center">
                            <div class="swiper-container" data-show-items="3" data-prev-next="1">
                                <div class="swiper-wrapper">
                                    @foreach($posts as $article)
                                        <div class="swiper-slide">
                                            <a href="{{url('blog',['slug' => $article->slug])}}">
                                                <div class="crumina-module crumina-pricing-table pricing-table--small">
                                                    <div class="pricing-thumb">
                                                        <img src="{{$article->image_url}}"
                                                             class="woox-icon" alt="{{$article->title}}"
                                                             title="{{$article->title}}"
                                                             style="border-radius: 0;height: 180px;width: 100%">
                                                    </div>
                                                    <h5 class="pricing-title">{{\Illuminate\Support\Str::limit($article->title,25)}}</h5>
                                                    <div class="price">
                                                        <div class="price-sup-title">{{$article->created_at_fa}}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                            <!-- If we need pagination -->
                            <div
                                class="swiper-pagination pagination-swiper-unique-id-1 swiper-pagination-clickable swiper-pagination-bullets">
                                <span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0"
                                      role="button" aria-label="Go to slide 1"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @livewire('home2.markets-table')

        <section class="medium-padding120 responsive-align-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt30">
                        <img class="responsive-width-50" src="/Home3/img/phone.png" alt="phone">
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <header class="crumina-module crumina-heading heading--h2 heading--with-decoration">
                            <div class="heading-sup-title">اپلیکیشن {{Setting::get('title')}}</div>
                            <h2 class="heading-title weight-normal">خرید و فروش و کیف پول
                                <span class="weight-bold">ارز دیجیتال</span></h2>
                        </header>

                        <p>
                            از طریق لینک های زیر اپلیکیشن ما را دانلود کنید
                        </p>

                        <div class="btn-market-wrap mt60">
                            <a href="#" class="btn btn--market btn--apple btn--with-icon btn--icon-left"
                               style="font-weight: 500">
                                <svg class="woox-icon icon-apple">
                                    <use xlink:href="#icon-apple"></use>
                                </svg>
                                <div class="text">
                                    <span class="sup-title">دانلود از</span>
                                    <span class="title">اپل استور</span>
                                </div>
                            </a>

                            <a href="https://tajcoin.org/uploads/application/tajcoin.apk"
                               class="btn btn--market btn--google btn--with-icon btn--icon-left"
                               style="font-weight: 500">
                                <svg class="woox-icon icon-if-59-play-843782">
                                    <use xlink:href="#icon-if-59-play-843782"></use>
                                </svg>
                                <div class="text">
                                    <span class="sup-title">دانلود از</span>
                                    <span class="title">گوگل پلی</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="medium-padding120 responsive-align-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt30">
                        <img class="responsive-width-50" src="/Home3/img/pc.png" alt="phone">
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <header class="crumina-module crumina-heading heading--h2 heading--with-decoration">
                            <h2 class="heading-title weight-normal">دسترسی آسان به
                                <span class="weight-bold">آنالیز بازار و قیمت ها</span></h2>
                            <div class="heading-text">
                                تاج کوین کامل ترین و اولین پلتفرم معاملاتی رمز ارز هاست که امکان خرید و فروش بیش از 500
                                رمز ارز،سرعت لیست شدن رمز ارز های مدنظر کاربران ،کیف پول اختصاصی،امکان ثبت سفارش،پرتفوی
                                لحظه ای و کلی امکانات دیگر را دارا میباشد
                            </div>
                        </header>
                        <div class="btn-market-wrap mt60">

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-dotted-map">
            <div class="container">
                <div class="row medium-padding300 align-center">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img class="primary-dots mb30" src="/Home3/img/dots.png" alt="dots">

                        <header class="crumina-module crumina-heading heading--h2 heading--with-decoration">
                            <h2 class="heading-title weight-normal">زندگی در
                                <span class="weight-bold">دنیای دیجیتال</span></h2>
                            <div class="heading-text">فناوری بلاکچین</div>
                        </header>

                        <div class="counters">
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="crumina-module crumina-counter-item">
                                    <div class="counter-numbers counter">
                                        <span data-speed="2000" data-refresh-interval="3" data-to="6386"
                                              data-from="2"></span>
                                    </div>
                                    <h4 class="counter-title">ارزش مارکت</h4>
                                    <p class="counter-text">ارزش معاملات روز</p>
                                    <div class="counter-line"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="crumina-module crumina-counter-item">
                                    <div class="counter-numbers counter">
                                        <div class="units">+</div>
                                        <span data-speed="2000" data-refresh-interval="3" data-to="500"
                                              data-from="2">500</span>

                                    </div>
                                    <h4 class="counter-title">تعداد ارزها</h4>
                                    <p class="counter-text">تعداد ارزهای ثبت شده در سایت</p>
                                    <div class="counter-line"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="crumina-module crumina-counter-item">
                                    <div class="counter-numbers counter">
                                        <span data-speed="2000" data-refresh-interval="3" data-to="8327"
                                              data-from="2"></span>
                                        <div class="units"></div>
                                    </div>
                                    <h4 class="counter-title">مشتریان</h4>
                                    <p class="counter-text">تعداد کاربران ثبت نام شده</p>
                                    <div class="counter-line"></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="crumina-module crumina-counter-item">
                                    <div class="counter-numbers counter">
                                        <span data-speed="2000" data-refresh-interval="3" data-to="2000"
                                              data-from="2"></span>
                                        <div class="units">+</div>
                                    </div>
                                    <h4 class="counter-title">تراکنش ها</h4>
                                    <p class="counter-text">میانگین تعداد تراکنش های کاربران</p>
                                    <div class="counter-line"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
