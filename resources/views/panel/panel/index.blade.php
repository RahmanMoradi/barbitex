@extends('layouts/contentLayoutMaster')

@section('title', 'داشبورد')

@section('vendor-style')
    <!-- vednor css files -->
    <link rel="stylesheet" href="{{ asset('vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/tether-theme-arrows.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/tether.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/shepherd-theme-default.css') }}">
    <link rel="stylesheet" href="{{asset('vendors/css/forms/select/bootstrap-select.css')}}">

@endsection
@section('mystyle')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset('css/pages/dashboard-analytics.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/card-analytics.min.css') }}">
    {{--    <link rel="stylesheet" href="{{ asset('css/plugins/tour/tour.min.css') }}">--}}
@endsection

@section('content')
    <section id="dashboard-analytics">
        @if (Setting::get('adminMessage') !== null && Setting::get('adminMessage') !== '')
            <div class="modal" id="adminMessage" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">پیام مدیر</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {!! Setting::get('adminMessage') !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">متوجه شدم</button>
                        </div>
                    </div>
                </div>
            </div>
            <button id="adminMessageBtn" type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#adminMessage"
                    style="display: none">
            </button>
        @endif
        <div class="alert alert-card alert-primary w-100" role="alert">
            وضعیت : <span class="badge badge-dark">{{Auth::user()->isActive() ? 'احراز شده' : 'احراز نشده'}}</span>
            سطح : <span class="badge badge-dark">{{Auth::user()->level_fa}}</span>
        </div>
        @if(Auth::user()->two_factor_type != 'none')
            <div class="alert alert-card alert-success w-100" role="alert">
                ورود دو مرحله ای شما توسط
                <span class="badge badge-dark"> @lang(Auth::user()->two_factor_type) </span>
                فعال است
                جهت غیر فعال سازی و یا تغییر می توانید از لینک روبرو استفاده نمائید :
                <span class="badge badge-dark">
                <a href="/panel/authentication/two-factor-authentication">ورود دو مرحله ای</a>
            </span>
            </div>
        @else
            <div class="alert alert-card alert-danger w-100" role="alert">
                برای امنیت بیشتر پیشنهاد می کنیم ورود دو مرحله ای خود را فعال کنید.
                <span class="badge badge-dark">
                <a href="/panel/authentication/two-factor-authentication">ورود دو مرحله ای</a>
            </span>
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-card alert-danger w-100" role="alert">
                    {{$error}}
                </div>
            @endforeach
        @endif
        @if (Setting::get('panelV4'))
            <div class="row">
                @if (isset(Helper::modules()['tournament']) && Helper::modules()['tournament'])
                    {{--                    @livewire('panel.tournament')--}}
                @endif
                <div class="col-md-12">
                    {{--                    @livewire('panel.currencies-slider')--}}
                </div>
                <div class="col-md-12">
                    {{--                    @livewire('panel.calculator')--}}
                </div>
                {{--                <div class="col-lg-6 col-md-12 mx-auto col-sm-12">--}}
                {{--                    <div class="card">--}}
                {{--                        <div class="card-header d-flex justify-content-between pb-0">--}}
                {{--                            <h4 class="card-title">--}}
                {{--                                وضعیت موجودی کاربر--}}
                {{--                                ({{number_format(Auth::user()->balance)}} تومان)--}}
                {{--                            </h4>--}}
                {{--                            <a href="{{url('panel/wallet')}}"--}}
                {{--                               class="btn btn-outline-success btn-sm waves-effect waves-light">--}}
                {{--                                <i class="feather icon-check"></i>مشاهده--}}
                {{--                            </a>--}}
                {{--                        </div>--}}
                {{--                        <div class="card-content">--}}
                {{--                            <div class="card-body pt-0">--}}
                {{--                                <div class="row">--}}
                {{--                                    <div class="col-sm-12 col-12 justify-content-center">--}}
                {{--                                        <div class="card-body">--}}
                {{--                                            <div id="pie-chart" class="height-250"></div>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="col-lg-6 col-md-12 mx-auto col-sm-12">--}}
                {{--                    <div class="card">--}}
                {{--                        <div class="card-header d-flex justify-content-between pb-0">--}}
                {{--                            <h4 class="card-title">وضعیت سقف تراکنش امروز</h4>--}}
                {{--                            <button class="btn btn-outline-success btn-sm waves-effect waves-light"--}}
                {{--                                    data-toggle="modal"--}}
                {{--                                    data-target="#MaxBuy"><i--}}
                {{--                                    class="feather icon-check"></i> افزایش سقف خرید--}}
                {{--                            </button>--}}
                {{--                        </div>--}}
                {{--                        <div class="card-content">--}}
                {{--                            <div class="card-body pt-0">--}}
                {{--                                <div class="row">--}}
                {{--                                    <div class="col-sm-12 col-12 justify-content-center">--}}
                {{--                                        <div class="card-body">--}}
                {{--                                            <div id="pie-chart2" class="height-200"></div>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <div class="chart-info d-flex justify-content-between mt-2">--}}
                {{--                                    <div class="text-center">--}}
                {{--                                        <p class="mb-50">سقف تراکنش روزانه</p>--}}
                {{--                                        <span--}}
                {{--                                            class="font-medium-2">{{number_format(Auth::user()->max_buy)}}</span>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="text-center">--}}
                {{--                                        <p class="mb-50">جمع خرید های امروز</p>--}}
                {{--                                        <span--}}
                {{--                                            class="font-medium-2">{{number_format(Auth::user()->day_buy)}}</span>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="text-center">--}}
                {{--                                        <p class="mb-50">میزان مجاز باقیمانده</p>--}}
                {{--                                        <span--}}
                {{--                                            class="font-medium-2">{{number_format(Auth::user()->max_buy - Auth::user()->day_buy)}}</span>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
            @livewire('panel.currencies')
            <div class="modal" id="MaxBuy" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">درخواست افزایش سقف خرید</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center">
                                جهت افزایش اعتبار از طریق
                                <a href="/panel/tickets">
                                    پشتیبانی
                                </a>
                                نسبت به ارسال تیکت اقدام نمایید
                            </p>
                        </div>
                        <div class="modal-footer">
                            <a href="/panel/tickets" type="button" class="btn btn-primary">پشتیبانی</a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="hidden" id="alert_modal_btn" data-toggle="modal" data-target="#alert_modal">
            </button>
        @else
            <div class="row">
                @if (isset(Helper::modules()['tournament']) && Helper::modules()['tournament'])
                    @livewire('panel.tournament')
                @endif
                <div class="{{\App\Helpers\Helper::modules()['market'] ? 'col-md-8' : 'col-md-12'}}">
                    @livewire('panel.currencies-slider')
                </div>
                @if (\App\Helpers\Helper::modules()['market'])
                    <div class="col-md-4">
                        @livewire('panel.markets')
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-8">
                    @livewire('panel.orders')
                </div>
                <div class="col-md-4">
                    @livewire('panel.balance-chart')
                </div>
            </div>
        @endif
    </section>
@endsection

@section('vendor-script')
    <!-- vednor files -->
    <script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/tether.min.js') }}"></script>
    <script src="{{ asset('vendors/js/forms/select/bootstrap-select.js') }}"></script>

    {{--    <script src="{{ asset(mix('vendors/js/extensions/shepherd.min.js')) }}"></script>--}}
@endsection
@section('myscript-chart')
    <script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/scripts/datatables/datatable.js') }}"></script>
    <!-- Page js files -->
    <script src="{{ asset('js/scripts/pages/dashboard-analytics.js') }}"></script>
    {{--    <script src="{{asset('vendors/js/digitalbox/digitbox.min.js')}}"></script>--}}
    <script src="{{asset('vendors/js/charts/echarts/echarts.js')}}"></script>
    <script>
        // $('#price').digitbox({separator: ',', grouping: 1, truevalue: 1});
        var balance = `{!! json_encode($balance) !!}`;
        var balance = JSON.parse(balance);
        console.log(balance)
        var pieChart = echarts.init(document.getElementById('pie-chart'));
        var dataName = [];
        var dataData = [];
        for (var i = 0; balance.length > i; i++) {
            dataName.push(balance[i].currency)
            dataData[i] = {
                'name': balance[i].currency,
                'value': balance[i].balanceIrt,
            }
        }
        var pieChartoption = {
            tooltip: {
                trigger: 'item',
                //formatter: "{a} <br/>{b} : {c} ({d}%)",
                formatter: function (params) {
                    return params.data.name + '(' + params.percent + '%)' + ':<br>' +
                        String(params.data.value).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' تومان '
                },
                textStyle: {
                    fontFamily: "IRANSans,Montserrat, Helvetica, Arial, serif",
                },
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: dataName
                ,
                textStyle: {
                    fontFamily: "IRANSans,Montserrat, Helvetica, Arial, serif",
                },
            },
            series: [
                {
                    label: {
                        textStyle: {
                            fontFamily: "IRANSans,Montserrat, Helvetica, Arial, serif",
                        },
                        formatter: "{b} ({d}%)",
                    },
                    name: 'موجودی',
                    type: 'pie',
                    radius: '80%',
                    center: ['50%', '60%'],
                    color: ['#388E3C', '#1DE9B6', '#9C27B0', '#009688', '#FFC107', '#D84315', '#C2185B', '#B39DDB', '#00B0FF', '#d50000'],
                    data: dataData
                    ,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    },

                }],
        };
        pieChart.setOption(pieChartoption);

        // $('#price').digitbox({separator: ',', grouping: 1, truevalue: 1});
        var pieChart2 = echarts.init(document.getElementById('pie-chart2'));
        var max_buy = `{{Auth::user()->max_buy}}`;
        var day_buy = `{{Auth::user()->day_buy}}`;
        var pieChartoption2 = {
            tooltip: {
                trigger: 'item',
                //formatter: "{a} <br/>{b} : {c} ({d}%)",
                formatter: function (params) {
                    return params.data.name + '(' + params.percent + '%)' + ':<br>' +
                        String(params.data.value).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' تومان '
                },
                textStyle: {
                    fontFamily: "IRANSans,Montserrat, Helvetica, Arial, serif",
                },
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: [
                    'میزان خرید امروز',
                    'خرید باقیمانده'
                ],
                textStyle: {
                    fontFamily: "IRANSans,Montserrat, Helvetica, Arial, serif",
                },
            },
            series: [
                {
                    label: {
                        textStyle: {
                            fontFamily: "IRANSans,Montserrat, Helvetica, Arial, serif",
                        },
                        formatter: "{b} ({d}%)",
                    },
                    name: 'خرید باقیمانده',
                    type: 'pie',
                    radius: '50%',
                    center: ['50%', '60%'],
                    color: ['#28C76F', '#7367F0'],
                    data: [
                        {value: max_buy, name: 'خرید باقیمانده'},
                        {value: day_buy, name: 'میزان خرید امروز'}
                    ],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    },

                }],
        };
        pieChart2.setOption(pieChartoption2);

        function formMaxBuySubmit() {
            var price = $('#price').val()
            $('#subject').val(`افزایش اعتبار به مبلغ ${price}`)
            var name = `{{Auth::user()->name}}`
            var text = `اینجانب ${name} درخواست افزایش سقف خرید روزانه به مبلغ ${price} را دارم و لطفا درخواست من را بررسی و اعمال نمائید. این یک درخواست اتوماتیک است.`
            $('#message').val(text)
            $('#category_id').val(`1`)
            $('#formMaxBuy').attr('action', '/panel/ticket/store')
            $('#formMaxBuy').submit()
        }

    </script>
    <script>
        var isMessage = "{{Setting::get('adminMessage') !== null && Setting::get('adminMessage') !== ''}}";
        if (isMessage) {
            $('#adminMessageBtn').click()
        }
    </script>
@endsection
