@extends('layouts/contentLayoutMaster')

@section('title', trans('dashboard'))

@section('vendor-style')
    <!-- vednor css files -->
    <link rel="stylesheet" href="{{ asset('vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/tether-theme-arrows.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/tether.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/shepherd-theme-default.css') }}">
@endsection
@section('mystyle')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset('css/pages/dashboard-analytics.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/card-analytics.min.css') }}">
    {{--    <link rel="stylesheet" href="{{ asset('css/plugins/tour/tour.min.css') }}">--}}
@endsection

@section('content')
    <section id="dashboard-analytics">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card card-icon mb-2">
                            <div class="card-body text-center">
                                <i class="feather icon-users icon-opacity warning font-large-2"></i>
                                <p class="text-muted mt-2 mb-1">@lang('number of users')</p>
                                <p dir="ltr" class="text-warning text-17 line-height-1 m-0">{{$userCount}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card card-icon mb-2">
                            <div class="card-body text-center pb-1">
                                <i class="feather icon-list icon-opacity primary font-large-2"></i>
                                <p class="text-muted mt-2 mb-1">@lang('number of orders')</p>
                                <p class="text-primary text-17 line-height-1 m-0">{{$orderCount}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <di class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card card-icon mb-2">
                            <div class="card-body text-center">
                                <i class="feather icon-dollar-sign icon-opacity danger font-large-2"></i>
                                <p class="text-muted mt-2 mb-1">@lang('number of markets')</p>
                                <p dir="ltr"
                                   class="text-danger text-17 line-height-1 m-0">{{$marketCount}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card card-icon mb-2 ">
                            <div class="card-body text-center">
                                <i class="feather icon-message-circle icon-opacity info font-large-2"></i>
                                <p class="text-muted mt-2 mb-1">@lang('number of messages')</p>
                                <p class="text-info line-height-1 m-0">{{$ticketCount}}</p>
                            </div>
                        </div>
                    </div>
                    @if(\App\Helpers\Helper::modules()['vip'])
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card card-icon mb-2 ">
                                <div class="card-body text-center">
                                    <i class="feather icon-star icon-opacity warning font-large-2"></i>
                                    <p class="text-muted mt-2 mb-1">@lang('number of vip users')</p>
                                    <p class="text-warning line-height-1 m-0">{{$vipUser}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card card-icon mb-2 ">
                                <div class="card-body text-center">
                                    <i class="feather icon-star icon-opacity warning font-large-2"></i>
                                    <p class="text-muted mt-2 mb-1">@lang('earn vip sales today')</p>
                                    <p class="text-warning line-height-1 m-0">{{number_format(-$vipIncomeDay)}}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </di>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <livewire:admin.markets/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <livewire:admin.orders/>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <livewire:admin.wallet.wage/>
            </div>
        </div>
    </section>

@endsection

@section('vendor-script')
    <!-- vednor files -->
    <script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/tether.min.js') }}"></script>
    {{--    <script src="{{ asset('vendors/js/extensions/shepherd.min.js') }}"></script>--}}
@endsection
@section('myscript')
    <!-- Page js files -->
    <script src="{{ asset('js/scripts/pages/dashboard-analytics.js') }}"></script>
@endsection
