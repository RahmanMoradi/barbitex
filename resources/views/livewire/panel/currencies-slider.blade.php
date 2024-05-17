@section('mystyle')
    <link rel="stylesheet" type="text/css"
          href="{{asset('panelAssets/app-assets/vendors/css/extensions/swiper.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('panelAssets/app-assets/css-rtl/plugins/extensions/swiper.min.css')}}">
    <style>
        .swiper-centered-slides.swiper-container .swiper-slide {
            padding: 1rem 1rem;
        }
    </style>
@overwrite
<div>
    @if (Setting::get('panelV4'))
        <section id="component-swiper-centered-slides">
            <div
                class="swiper-centered-slides0 swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-rtl">
                <div class="swiper-wrapper"
                     style="transition-duration: 0ms; transform: translate3d(-80.3675px, 0px, 0px);">
                    @foreach($currencies as $currency)
                        <div dir="rtl" class="swiper-slide"
                             style="margin-left: 30px">
                            <a href="{{route('order.create',['currency' => $currency->symbol])}}">
                                <div class="card shadow" style="">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="d-flex">
                                                <div class="">
                                                    <img src="{{$currency->iconUrl}}"
                                                         class="w-6 h-6 mt-0" height="50" alt="">
                                                </div>
                                                <div class="ml-1">
                                                    <p class=" tx-13">{{$currency->symbol}}
                                                        / {{$currency->name}}
                                                        <span class="{{$currency->percent > 0 ? 'text-success' : 'text-danger'}}">
                                                            {!! $currency->percent_image !!}
                                                            {{$currency->percent}}
                                                            %
                                                        </span>
                                                    </p>
                                                    <div class=" tx-13 text-warning">قیمت
                                                        خرید {{number_format($currency->irtPrice)}}<span
                                                            class="text-success"><i class="ion-arrow-up-c ml-1"></i>نرخ دلاری :<div
                                                                style="display: inline-flex;font-family: monospace;"> {{App\Helpers\Helper::numberFormatPrecision($currency->price,$currency->decimal)}}</div></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <section id="component-swiper-centered-slides">
            <div class="card shadow-none">
                <div class="card-header">
                    <h4 class="card-title">لیست ارزها</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div
                            class="swiper-centered-slides swiper-container p-1 swiper-container-initialized swiper-container-horizontal swiper-container-rtl">
                            <div class="swiper-wrapper"
                                 style="transition-duration: 0ms; transform: translate3d(-80.3675px, 0px, 0px);">
                                @foreach($currencies as $currency)
                                    <div dir="rtl" class="swiper-slide rounded swiper-shadow"
                                         style="margin-left: 30px;">
                                        <img src="{{asset($currency->iconUrl)}}" height="50" alt="">
                                        <div class="swiper-text pt-md-1 pt-sm-50">{{$currency->name}}</div>
                                        <div class="swiper-text pt-md-1 pt-sm-50">قیمت
                                            خرید
                                            {{number_format($currency->send_price)}}
                                        </div>
                                        <div class="swiper-text pt-md-1 pt-sm-50">قیمت
                                            فروش
                                            {{number_format($currency->receive_price)}}
                                        </div>
                                        @if(\App\Helpers\Helper::modules()['orderPlane'])
                                            <div class="swiper-text pt-md-1 pt-sm-50">
                                                <a href="{{route('order.create')}}"
                                                   class="btn btn-block btn-primary">خرید / فروش</a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide"
                                 aria-disabled="false"></div>
                            <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide"
                                 aria-disabled="false"></div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
@section('myscript')
    <script src="{{asset('panelAssets/app-assets/vendors/js/extensions/swiper.min.js')}}"></script>
    {{--    <script src="{{asset('panelAssets/app-assets/js/scripts/extensions/swiper.min.js')}}"></script>--}}
    <script>
        new Swiper(".swiper-centered-slides", {
            effect: "coverflow",
            slidesPerView: "auto",
            centeredSlides: 1,
            spaceBetween: 30,
            loop: 1,
            autoplay: {
                delay: 3000,
            },
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            navigation: {nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev"}
        })
        new Swiper(".swiper-centered-slides0", {
            slidesPerView: "3",
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 30
                },
                640: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            },
            centeredSlides: 1,
            spaceBetween: 10,
            loop: 1,
            autoplay: {
                delay: 5000,
            },
        })
    </script>
@overwrite
