@extends('layouts/contentLayoutMaster')

@section('title', 'لیست درخواست های برداشت وجه')

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
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>کاربر</th>
                                        <th>مشخصات حساب</th>
                                        <th>نوع</th>
                                        <th>مبلغ</th>
                                        <th>تاریخ و ساعت ثبت</th>
                                        <th>شرح</th>
                                        <th>وضعیت</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($wallets as $wallet)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{optional($wallet->user)->name}}</td>
                                            <td>
                                                <p data-toggle="tooltip"
                                                   data-original-title="کلیک و کپی" onclick="copyToClipboard(this)">
                                                    <span>
                                                    {{optional($wallet->card)->card_number}}
                                                    </span>
                                                </p>
                                                <hr>
                                                <p data-toggle="tooltip"
                                                   data-original-title="کلیک و کپی" onclick="copyToClipboard(this)">
                                                    <span>
                                                {{optional($wallet->card)->account_number}}
                                                    </span>
                                                </p>
                                                <hr>
                                                <p data-toggle="tooltip"
                                                   data-original-title="کلیک و کپی" onclick="copyToClipboard(this)">
                                                    <span>
                                                IR{{optional($wallet->card)->sheba}}
                                                    </span>
                                                </p>
                                            </td>
                                            <td>{!! $wallet->type_fa !!}</td>
                                            <td>
                                                مبلغ درخواستی: {{number_format($wallet->price)}}
                                                <hr>
                                                موجودی کاربر : {{number_format(optional($wallet->user)->balance)}}
                                            </td>
                                            <td>{{$wallet->created_at_fa}}</td>
                                            <td>{!! $wallet->description !!}</td>
                                            <td>{!! $wallet->status_fa !!}</td>
                                            <td>
                                                <a href="{{route('admin.wallet.update',['wallet' => $wallet , 'status' => 'done'])}}"
                                                   class="btn btn-success">واریز شده</a>
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
    <script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/scripts/datatables/datatable.js') }}"></script>
@endsection
