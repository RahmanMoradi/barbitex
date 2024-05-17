@extends('layouts/contentLayoutMaster')

@section('title', 'لیست موجودی کیف پول کاربران')

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
    {{--    datatable --}}
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
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
                                @foreach($balances->groupBy('currency') as $balance)
                                    <h4>لیست موجودی {{$balance[0]->currency}}</h4>
                                    <hr>
                                    <table
                                        class="table table-bordered table-hover-animation col-md-12 mx-auto zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>کاربر</th>
                                            <th>ارز</th>
                                            <th>موجودی</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($balance as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>
                                                    <a href="{{route('admin.user.show',['user' => $item->user_id ?? 0])}}"
                                                       target="_blank">
                                                        {{optional($item->user)->name}}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{$item->currency}}
                                                </td>
                                                <td>
                                                    {{Helper::numberFormatPrecision($item->balance)}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td>جمع کل</td>
                                            <td></td>
                                            <td>{{$item->currency}}</td>
                                            <td>{{@Helper::numberFormatPrecision($balance->sum('balance'))}} {{$item->currency}}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <hr>
                                @endforeach
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
    <script src="{{ asset('js/scripts/ui/data-list-view.js') }}"></script>
@endsection
@section('myscript')
    <!-- Page js files -->
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
