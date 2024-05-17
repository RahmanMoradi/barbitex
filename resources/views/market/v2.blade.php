@extends('market.layouts.master')
@section('css')
    <style>
        body {
            font-family: "iranyekan" !important;
        }

        tbody > tr {
            font-family: "iranyekan" !important;
        }

        .horizontal-menu.navbar-floating:not(.blank-page) .app-content {
            padding-top: 3.75rem;
        }

        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
            padding-left: 5px;
            padding-right: 5px;
        }

        .card {
            margin-bottom: 5px;
        }

        body.dark-layout .table {
            background-color: transparent !important;
        }

        body.dark-layout .table thead tr th {
            background-color: transparent !important;
        }

        body.dark-layout .card .card-footer, body.dark-layout .card .card-header {
            padding-bottom: 10px;
            background-color: rgb(24 35 51);
            border-bottom: 2px solid rgb(19, 27, 38);
        }

        body.dark-layout .card, body.dark-layout .card .card-header .heading-elements.visible ul li, body.dark-layout .card .heading-elements.visible .list-inline {
            background-color: rgb(24 35 51);
        }

        body.dark-layout, body.dark-layout pre {
            background-color: rgb(19 27 38);
        }

        body.dark-layout .custom-file-label, body.dark-layout input.form-control, body.dark-layout textarea.form-control {
            background-color: rgb(31, 50, 80);
        }

        body.dark-layout .nicescroll-cursors {
            background-color: rgb(31 50 79) !important;
            border: 0 !important;
        }

        body.dark-layout .nav .nav-item .nav-link, body.dark-layout .nav .nav-item .nav-link.active, body.dark-layout .nav-tabs .nav-item .nav-link, body.dark-layout .nav-tabs .nav-item .nav-link.active, body.dark-layout .nav-tabs.nav-justified .nav-item .nav-link, body.dark-layout .nav-tabs.nav-justified .nav-item .nav-link.active, body.dark-layout .nav-tabs.nav-justified ~ .tab-content .tab-pane, body.dark-layout .nav-tabs ~ .tab-content .tab-pane, body.dark-layout .nav-vertical .nav.nav-tabs.nav-left ~ .tab-content .tab-pane, body.dark-layout .nav-vertical .nav.nav-tabs.nav-right ~ .tab-content .tab-pane, body.dark-layout .nav ~ .tab-content .tab-pane {
            background-color: #1f3250;
        }

        body.dark-layout textarea:focus, input:focus {
            border: none;
            border-bottom: 2px solid #1c468b !important;
        }

        .badge.badge-light-success {
            background-color: #dfffee !important;
        }

        body.dark-layout .badge.badge-light-success {
            background-color: #495950 !important;
        }

        @media (max-width: 1199.98px) {
            body.dark-layout .header-navbar {
                background-color: #131b26 !important;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
@endsection
@section('main')
    <div id="app">
        <div class="row d-none d-md-flex">
            <div class="col-md-3 col-sm-12">
                <div>
                    <buyer :market="{{$market}}" channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"/>
                </div>
                <div>
                    <seller :market="{{$market}}" channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"/>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div>
                    <chart :market="{{$market}}" channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"/>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <livewire:market.trading-view market="{{$market->market}}" symbol="{{$market->symbol}}"/>
                    </div>
                </div>
                @if (isset(\App\Helpers\Helper::modules()['api_version']) && \App\Helpers\Helper::modules()['api_version'] == 2)
                    <livewire:market.v2.order :market="$market" :key="'market-order'.Auth::id()"/>
                @else
                    <livewire:market.order :market="$market" :key="'market-order'.Auth::id()"/>
                @endif

            </div>
            <div class="col-md-3 col-sm-12">
                <div>
                    <markets :market="{{$market}}" :markets="{{$markets}}"
                             channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"/>
                </div>
                <div>
                    <last-order :market="{{$market}}" channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"/>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <livewire:market.active-order :market="$market" :key="'active-order'.Auth::id()"/>
            </div>
            <div class="col-md-6 col-sm-12">
                <livewire:market.my-orders :market="$market" :key="'my-order'.Auth::id()"/>
            </div>
        </div>
        <div class="d-md-none">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="marketTabs" role="tablist">
                <li class="flex-sm-fill nav-item" role="presentation">
                    <button class="nav-link active" id="chartLink" data-bs-toggle="tab" data-toggle="tab"
                            data-bs-target="#chart" data-target="#chart" type="button" role="tab" aria-controls="chart"
                            aria-selected="true">خرید و فروش
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="orderBookLink" data-bs-toggle="tab" data-toggle="tab"
                            data-bs-target="#orderBook" data-target="#orderBook" type="button" role="tab"
                            aria-controls="orderBook" aria-selected="false">
                        سفارشات
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="lastOrdersLink" data-bs-toggle="tab" data-toggle="tab"
                            data-bs-target="#lastOrders" data-target="#lastOrders" type="button" role="tab"
                            aria-controls="lastOrders"
                            aria-selected="false">آخرین معاملات
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="marketsLink" data-bs-toggle="tab" data-toggle="tab"
                            data-bs-target="#marketsList" data-target="#marketsList" type="button" role="tab"
                            aria-controls="markets"
                            aria-selected="false"> بازارها
                    </button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="chart" role="tabpanel" aria-labelledby="chartLink">
                    <div>
                        <chart :market="{{$market}}" channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"/>
                    </div>
                    <div class="card">
                        <div class="card-body p-0">
                            <livewire:market.trading-view market="{{$market->market}}" symbol="{{$market->symbol}}"/>
                        </div>
                    </div>
                    <livewire:market.order :market="$market" :key="'market-order'.Auth::id()"/>
                </div>
                <div class="tab-pane" id="orderBook" role="tabpanel" aria-labelledby="orderBookLink">
                    <div>
                        <buyer :market="{{$market}}" channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"/>
                    </div>
                    <div>
                        <seller :market="{{$market}}" channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"/>
                    </div>
                </div>
                <div class="tab-pane" id="lastOrders" role="tabpanel" aria-labelledby="lastOrdersLink">
                    <div>
                        <last-order :market="{{$market}}"
                                    channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"/>
                    </div>
                </div>
                <div class="tab-pane" id="marketsList" role="tabpanel" aria-labelledby="marketsLink">
                    <div>
                        <markets :market="{{$market}}" :markets="{{$markets}}"
                                 channelprefix="{{\App\Helpers\Helper::getBroadcasterPrefix()}}"/>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs" id="ordersTab" role="tablist">
                <li class="flex-sm-fill nav-item" role="presentation">
                    <button class="nav-link active" id="myOrderOpenLink" data-bs-toggle="tab" data-toggle="tab"
                            data-bs-target="#myOrderOpen" data-target="#myOrderOpen" type="button" role="tab"
                            aria-controls="chart"
                            aria-selected="true">معاملات باز
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="myOrdersLink" data-bs-toggle="tab" data-toggle="tab"
                            data-bs-target="#myOrders" data-target="#myOrders" type="button" role="tab"
                            aria-controls="myOrders" aria-selected="false">
                        آخرین معاملات
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="myOrderOpen" role="tabpanel" aria-labelledby="chartLink">
                    <livewire:market.active-order :market="$market" :key="'active-order'.Auth::id()"/>
                </div>
                <div class="tab-pane" id="myOrders" role="tabpanel" aria-labelledby="orderBookLink">
                    <livewire:market.my-orders :market="$market" :key="'my-order'.Auth::id()"/>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/scripts/datatables/datatable.js') }}"></script>
    <script>
        $("body").niceScroll({
            cursorwidth: "10px"
        });
    </script>
    <script>
        window.addEventListener('message', function (e) {
            if (e.data[2] === 'sell' || e.data[2] === 'buy') {
                Livewire.emit('setAmountFromBook', e.data[1], e.data[0], e.data[2])
            }
        });
    </script>
@endsection
