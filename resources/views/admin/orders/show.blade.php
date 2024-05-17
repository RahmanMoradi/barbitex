@extends('layouts/contentLayoutMaster')

@section('title', trans('order information'))

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
                        <div class="card-body p-0 p-md-1 table-responsive">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="title">@lang('order information')</h3>
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th>@lang('id')</th>
                                            <td>{{$order->id}}</td>
                                        </tr>
                                        <tr>
                                            <th>نوع معامله</th>
                                            @if ($order->type == 1)
                                                <td>@lang('buy')
                                                    <span
                                                        class="badge badge-info">{{$model == 'digital' ? $order->dollar : $order->qty}}</span>
                                                    @lang('unit')
                                                    <span class="badge badge-info">
                                                    <img src="{{optional($order->currency)->icon_url}}" height="15">
                                                    {{optional($order->currency)->symbol}}
                                                </span>
                                                    @lang('by') {{optional($order->user)->name}}
                                                </td>
                                            @else
                                                <td>@lang('sell')
                                                    <span
                                                        class="badge badge-info">{{$model == 'digital' ? $order->dollar : $order->qty}}</span>
                                                    @lang('unit')
                                                    <span class="badge badge-info">
                                                    <img src="{{optional($order->currency)->icon_url}}" height="15">
                                                    {{optional($order->currency)->symbol}}
                                                </span>
                                                    @lang('by') {{optional($order->user)->name}}
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>@lang('status')</th>
                                            <td>
                                                @if($order->type == 'buy')
                                                    {!! $order->status_pay !!}
                                                @endif
                                                {!! $order->status_fa!!}
                                            </td>
                                        </tr>
                                        <tr>
                                                <th>@lang('price')</th>
                                            <td>{{Helper::numberFormatPrecision($order->price)}} تومان</td>
                                        </tr>
                                        @if($model == 'crypto')
                                            <tr>
                                                <th>@lang('transaction id')</th>
                                                <td>
                                                    {{optional($order->more)->txid}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>@lang('user description')</th>
                                                <td>
                                                    {{$order->body}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>@lang('admin description')</th>
                                                <td>
                                                    <form action="{{url('/wa-admin/order/adminbody',['id'=>$order->id])}}"
                                                          method="post"
                                                          onsubmit="return confirm(@lang('are you sure you want to do this')">
                                                        @csrf
                                                        <fieldset class="form-group">
                                                        <textarea class="form-control editor" id="editor" name="admin_body">
                                                         {{optional($order->more)->admin_body}}
                                                        </textarea>
                                                        </fieldset>
                                                        <input type="submit" class="btn btn-outline-success"
                                                               value="@lang('submit')">
                                                    </form>
                                                </td>
                                            </tr>
                                        @else
                                            @if(optional($order->currency)->symbol == 'PSV')
                                                <tr>
                                                    <th>@lang('voucher code')</th>
                                                    <td>
                                                        {{$order->vouchercode}}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(optional($order->currency)->symbol == 'PM')
                                                <tr>
                                                    <th>@lang('user account')</th>
                                                    <td>
                                                        {{$order->account}}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(optional($order->currency)->symbol == 'PMV')
                                                <tr>
                                                    <th>@lang('voucher code')</th>
                                                    <td>
                                                        {{$order->e_voucher}}
                                                    </td>
                                                    <th>@lang('active code')</th>
                                                    <td>
                                                        {{$order->activation_code}}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(optional($order->currency)->symbol == 'WM')
                                                <tr>
                                                    <th>@lang('wallet')</th>
                                                    <td>
                                                        {{$order->purse}}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(optional($order->currency)->symbol == 'Skrill')
                                                <tr>
                                                    <th>@lang('email')</th>
                                                    <td>
                                                        {{$order->email}}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(optional($order->currency)->symbol == 'Paypal')
                                                <tr>
                                                    <th>@lang('email')</th>
                                                    <td>
                                                        {{$order->email}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                        <tr>
                                            <th>@lang('created at')</th>
                                            <td>{{$order->created_at_fa}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('vendor-script')
@endsection
@section('myscript')
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/translations/fa.js"></script>

    <script>
        var allEditors = document.querySelectorAll('.editor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor
                .create(allEditors[i], {
                    language: 'fa'
                })
                .then(editor => {
                    editor.ui.view.editable.element.style.height = '150px';
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
@endsection
