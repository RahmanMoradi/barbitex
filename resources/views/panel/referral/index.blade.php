@extends('layouts/contentLayoutMaster')

@section('title', 'زیرمجموعه ها')

@section('vendor-style')
    {{-- vednor css files --}}
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
@endsection

@section('content')
    <!-- Column selectors with Export Options and print table -->
    <section id="column-selectors">
        <div class="row mb-4">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 col-lg-3 mb-5 mb-md-0">
                                <i class="feather icon-user-plus icon-opacity font-large-3 text-info"></i>
                                <h3 class="mt-1">{{$referralsCount}}</h3>
                                <span>تعداد کاربر معرفی شده</span>
                            </div>

                            <div class="col-md-3 col-lg-3 mb-5 mb-md-0">
                                <i class="feather icon-star icon-opacity font-large-3 text-warning"></i>
                                <h3 class="mt-1">{{$orders->count()}}</h3>
                                <span>تعداد کل سفارشات</span>
                            </div>
                            <div class="col-md-3 col-lg-3 mb-5 mb-md-0">
                                <i class="feather icon-flag icon-opacity font-large-3 text-success"></i>
                                <h3 class="mt-1">{{number_format($commissions)}} <span class="font-small-1">تومان</span>
                                </h3>
                                <span>مبلغ کل پورسانت</span>
                            </div>

                            <div class="col-md-3 col-lg-3 mb-5 mb-md-0">
                                <i class="feather icon-pie-chart icon-opacity font-large-3 text-danger"></i>
                                <h3 class="mt-1">{{number_format($commissionsAverage)}} <span
                                        class="font-small-1">تومان</span></h3>
                                <span>میانگین پورسانت هر سفارش</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <div class="card o-hidden">
                    <div class="card-body">
                        <div class="card-title mb-0">زیر مجموعه گیری و کسب درآمد</div>

                        <p class="mt-3">
                            با معرفی {{Setting::get('title')}} به دوستان خود از هر بار خرید دوستانتان پورسانت دریافت
                            کنید.</p>

                        <div class="row border-primary rounded">
                            <div class="col-md-12 text-primary text-center font-medium-3 p-2 text-center">
                                لینک عضویت از طریق سایت و بدون وارد کردن کد معرف:
                                <div class="m-0 cursor-pointer" data-toggle="tooltip" data-original-title="کلیک و کپی"
                                     onclick="copyToClipboard(this)">
                                    <i class="feather icon-copy"></i><span> {{url('/')}}/ref/{{Auth::id()}}</span>
                                </div>
                                <hr/>
                                کد معرف:
                                <div class="m-0 cursor-pointer" data-toggle="tooltip" data-original-title="کلیک و کپی"
                                     onclick="copyToClipboard(this)">
                                    <i class="feather icon-copy"></i><span> {{Auth::id()}}</span>
                                </div>
                            </div>
                        </div>

                        <p class="mt-1">تا این لحظه <span
                                class="font-weight-bold font-medium-2"> {{$referralsCount}} </span> نفر معرفی
                            کرده اید.
                            <a href="#" data-toggle="modal" data-target="#exampleModal"
                               class="typo_link text-info mr-2"><i class="i-File-Clipboard-File--Text"></i> لیست دوستان
                                معرفی شده</a>
                        </p>
                        <hr width="50%">
                        <h5 class="mt-4 mb-3">جدول خرید های دوستان معرفی شده توسط شما</h5>
                        <div class="table-responsive">
                            <table class="table table-striped zero-configuration">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>کاربر</th>
                                    <th>مبلغ پورسانت</th>
                                    <th>تاریخ و ساعت ثبت</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{optional($order->user)->name}}</td>
                                        <td>{{$order->price}}</td>
                                        <td>{{$order->created_at}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>کاربر</th>
                                    <th>مبلغ پورسانت</th>
                                    <th>تاریخ و ساعت ثبت</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">لیست دوستان معرفی شده</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="بستن">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-default">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">نام</th>
                                        <th class="text-center">تاریخ عضویت</th>
                                        <th>@lang('document status')</th>
                                        <th>@lang('card status')</th>
                                        <th class="text-center">تعداد خرید</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    @if ($referrals->count() == 0)
                                        <tr>
                                            <td colspan="4">تاکنون کسی را معرفی نکرده اید</td>
                                        </tr>
                                    @else
                                        @foreach($referrals as $user)
                                            <tr>
                                                <td>{{$loop->index + 1}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{!! $user->created_at_fa !!}</td>
                                                <td>{{$user->document_status_text}}</td>
                                                <td>{{$user->cardActive ? __('active') : 'deactive'}}</td>
                                                <td>{{optional($user->orders)->count()}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect waves-light"
                                    data-dismiss="modal">بستن
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Column selectors with Export Options and print table -->

@endsection
@section('vendor-script')
    {{-- vednor files --}}
    <script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
@endsection
@section('myscript')
    {{-- Page js files --}}
    <script src="{{ asset('js/scripts/datatables/datatable.js') }}"></script>
@endsection
