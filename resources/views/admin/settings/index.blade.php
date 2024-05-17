@extends('layouts/contentLayoutMaster')

@section('title', trans('setting'))

@section('mystyle')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset('css/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" href="{{asset('vendors/css/dropify/dropy.css')}}">

    <style>
        .dropify-filename-inner {
            display: none
        }

        audio {
            width: 100%;
            outline: none;
        }

        .ck {
            width: 99% !important;
        }
    </style>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-3 mb-2 p-md-0 col-sm-12">
            <div class="card o-hidden">
                <div class="card-body p-md-0">
                    <div class="card-body text-center">
                        <div class="mb-2 mx-auto rounded-circle w-60">
                            <div class="avatar bg-primary m-0">
                                <div class="avatar-content" style="width: 100px; height: 100px">
                                    <img height="100" src="{{asset(Setting::get('logo'))}}"/>
                                </div>
                            </div>
                        </div>
                        <h5 class="m-0">{{Setting::get('title')}}</h5>
                        <hr>
                        <div class="list-group mt-2 text-left menu-profile">
                            <a href="{{url('wa-admin/settings?level=general')}}"
                               class="list-group-item list-group-item-action {{Request::get('level') == 'general' ? 'active' : ''}}">
                                <i class="ft-user mr-1"></i>
                                @lang('general setting')
                            </a>
                            <a href="{{url('wa-admin/settings?level=payment')}}"
                               class="list-group-item list-group-item-action {{Request::get('level') == 'payment' ? 'active' : ''}}">
                                <i class="ft-user mr-1"></i>
                                @lang('gateways setting')
                            </a>
                            <a href="{{url('wa-admin/settings?level=page')}}"
                               class="list-group-item list-group-item-action {{Request::get('level') == 'page' ? 'active' : ''}}">
                                <i class="ft-user mr-1"></i>
                                @lang('pages setting')
                            </a>
                            <a href="{{url('wa-admin/settings?level=binance')}}"
                               class="list-group-item list-group-item-action {{Request::get('level') == 'binance' ? 'active' : ''}}">
                                <i class="ft-user mr-1"></i>
                                @lang('connection setting')
                            </a>
                            <a href="{{url('wa-admin/settings?level=userLevel')}}"
                               class="list-group-item list-group-item-action {{Request::get('level') == 'userLevel' ? 'active' : ''}}">
                                <i class="ft-user mr-1"></i>
                                @lang('user level setting')
                            </a>
                            <a href="{{url('wa-admin/settings?level=server')}}"
                               class="list-group-item list-group-item-action {{Request::get('level') == 'server' ? 'active' : ''}}">
                                <i class="ft-user mr-1"></i>
                                @lang('server setting')
                            </a>
                            @if(\App\Helpers\Helper::modules()['application'])
                                <a href="{{url('wa-admin/settings?level=application')}}"
                                   class="list-group-item list-group-item-action {{Request::get('level') == 'application' ? 'active' : ''}}">
                                    <i class="ft-user mr-1"></i>
                                    @lang('application setting')
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 mb-2">

            <div class="card o-hidden">
                @if (Request::get('level') == 'general')
                    @include('admin.settings.includes.general')
                @elseif (Request::get('level') == 'page')
                    @include('admin.settings.includes.pages')
                @elseif(Request::get('level') == 'payment')
                    @include('admin.settings.includes.payment')
                @elseif(Request::get('level') == 'binance')
                    @include('admin.settings.includes.binance')
                @elseif(Request::get('level') == 'userLevel')
                    @include('admin.settings.includes.userLevel')
                @elseif(Request::get('level') == 'pwa')
                    @include('admin.settings.includes.pwa')
                @elseif(Request::get('level') == 'application')
                    @include('admin.settings.includes.application')
                @elseif(Request::get('level') == 'server')
                    @include('admin.settings.includes.server')
                @endif
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
    <!-- vednor files -->
    <script src="{{ asset('vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
@endsection
@section('myscript')
    <!-- Page js files -->

    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/translations/fa.js"></script>

    <script>
        var allEditors = document.querySelectorAll('.editor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor
                .create(allEditors[i], {
                    language: 'fa',
                    ckfinder: {
                        uploadUrl: `{{route('admin.ckeditor.upload',['_token'=>csrf_token()])}}`
                    }
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
