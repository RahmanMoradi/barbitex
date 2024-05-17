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
                    @livewire('panel.tournament')
                @endif
                <div class="col-md-12">
                    @livewire('panel.currencies-slider')
                </div>
                <div class="col-md-12">
                    @livewire('panel.calculator')
                </div>
                <div class="col-lg-6 col-md-12 mx-auto col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h4 class="card-title">
                                وضعیت موجودی کاربر
                                ({{number_format(Auth::user()->balance)}} تومان)
                            </h4>
                            <a href="{{url('panel/wallet')}}"
                               class="btn btn-outline-success btn-sm waves-effect waves-light">
                                <i class="feather icon-check"></i>مشاهده
                            </a>
                        </div>
                        <div class="card-content">
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-12 col-12 justify-content-center">
                                        <div class="card-body">
                                            <div id="pie-chart" class="height-250"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mx-auto col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-0">
                            <h4 class="card-title">وضعیت سقف تراکنش امروز</h4>
                            <button class="btn btn-outline-success btn-sm waves-effect waves-light"
                                    data-toggle="modal"
                                    data-target="#MaxBuy"><i
                                    class="feather icon-check"></i> افزایش سقف خرید
                            </button>
                        </div>
                        <div class="card-content">
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-12 col-12 justify-content-center">
                                        <div class="card-body">
                                            <div id="pie-chart2" class="height-200"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chart-info d-flex justify-content-between mt-2">
                                    <div class="text-center">
                                        <p class="mb-50">سقف تراکنش روزانه</p>
                                        <span
                                            class="font-medium-2">{{number_format(Auth::user()->max_buy)}}</span>
                                    </div>
                                    <div class="text-center">
                                        <p class="mb-50">جمع خرید های امروز</p>
                                        <span
                                            class="font-medium-2">{{number_format(Auth::user()->day_buy)}}</span>
                                    </div>
                                    <div class="text-center">
                                        <p class="mb-50">میزان مجاز باقیمانده</p>
                                        <span
                                            class="font-medium-2">{{number_format(Auth::user()->max_buy - Auth::user()->day_buy)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body p-0 p-md-1 text-center">
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered table-hover-animation col-md-12 mx-auto zero-configuration">
                                        <thead>
                                        <tr>
                                            <td>ارز</td>
                                            <td>نام ارز</td>
                                            <td>قیمت خرید از ما</td>
                                            <td>قیمت فروش به ما</td>
                                            {{--                                        <td>موجودی</td>--}}
                                            <td>عملیات</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($currencies as $currency)
                                            <tr>
                                                <td>
                                                    <img src="{{asset($currency->icon_url)}}"
                                                         class="img-fluid" width="40px">
                                                </td>
                                                <td>
                                                    {{$currency->enname}}
                                                    {{$currency->name}}
                                                    ({{$currency->symbol}})
                                                    @if ($currency->network)
                                                        <span class="badge badge-info">{{$currency->network}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                <span id=""
                                                      style="">{{number_format($currency->send_price,$currency->decimal)}}</span>
                                                </td>
                                                <td>
                                                <span id=""
                                                      style="">{{number_format($currency->receive_price,$currency->decimal)}}</span>
                                                </td>
                                                {{--                                            <td>--}}
                                                {{--                                                <span id=""--}}
                                                {{--                                                      style="">{{number_format($currency->count,$currency->decimal)}}</span>--}}
                                                {{--                                            </td>--}}
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{url("panel/order/create?currency=$currency->symbol")}}"
                                                           class="btn btn-success">خرید</a>
                                                        <a href="{{url("panel/order/create?currency=$currency->symbol")}}"
                                                           class="btn btn-danger"> فروش</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
@endsection
