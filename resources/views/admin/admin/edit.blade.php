@extends('layouts/contentLayoutMaster')

@section('title', trans('edit admin'))

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
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row p-2">
                                <div class="col-8 mx-auto">
                                    <form action="{{route('admin.admin.update',['admin' => $admin])}}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <fieldset class="form-label-group form-group">
                                            <input name="name" type="text" class="form-control"
                                                   id="name" value="{{$admin->name}}">
                                            <label for="name">@lang('full name')</label>
                                        </fieldset>
                                        <fieldset class="form-label-group form-group">
                                            <input type="text" class="form-control" id="mobile" name="mobile"
                                                   value="{{$admin->mobile}}">
                                            <label for="mobile">@lang('mobile')</label>
                                        </fieldset>

                                        <fieldset class="form-label-group form-group">
                                            <input name="email" type="text" class="form-control"
                                                   id="email" value="{{$admin->email}}">
                                            <label for="email">@lang('email')</label>
                                        </fieldset>
                                        <fieldset class="form-group">
                                            <label class="" for="label">@lang('select role')</label>
                                            <select class="form-control" name="role_id"
                                                    title="@lang('select lang')">
                                                <option value="">@lang('select')</option>
                                                @foreach($roles as $role)
                                                    <option
                                                        value="{{$role->id}}" {{ in_array(trim($role->id) , $admin->roles->pluck('id')->toArray()) ? 'selected' : ''  }}>{{$role->label}}
                                                        - {{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>

                                        <fieldset class="form-group ">
                                            <label for="is_sms_login">@lang('two-step login with sms')</label>
                                            <select class="form-control" name="is_sms_login" id="is_sms_login">
                                                <option {{$admin->is_sms_login == 1 ? 'selected':''}} value="1">
                                                    @lang('active')
                                                </option>
                                                <option {{$admin->is_sms_login == 0 ? 'selected':''}} value="0">غیر
                                                    @lang('inactive')
                                                </option>
                                            </select>
                                        </fieldset>

                                        <input type="submit" class="btn btn-outline-primary" value="@lang('submit')">
                                    </form>
                                    <hr>
                                    <form action="{{route('admin.admin.update.password',['admin' => $admin])}}"
                                          method="post">
                                        <input type="hidden" name="admin_id" value="{{$admin->id}}">
                                        @csrf
                                        <div class="col-12 mt-2">
                                            <fieldset class="form-label-group form-group">
                                                <input name="password" type="password" class="form-control"
                                                       id="password">
                                                <label for="password">@lang('password')</label>
                                            </fieldset>

                                            <fieldset class="form-label-group form-group">
                                                <input name="password_confirmation" type="password" class="form-control"
                                                       id="password_confirmation">
                                                <label for="password_confirmation">@lang('repeat the password')</label>
                                            </fieldset>
                                        </div>
                                        <input type="submit" class="btn btn-outline-success" value="@lang('change password')">
                                    </form>
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
    <!-- vednor files -->
    <script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/tether.min.js') }}"></script>
    {{--    <script src="{{ asset('vendors/js/extensions/shepherd.min.js') }}"></script>--}}
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

        function submitForm(action, id) {
            console.log(11)
            $('#action').val(action)
            $('#card_id').val(id)
            $('#formCardStatus').submit()
        }
    </script>
@endsection
