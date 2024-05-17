@extends('layouts/contentLayoutMaster')

@section('title', trans('edit role'))

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
                <form action="{{route('admin.roles.update', $role)}}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body p-0 p-md-1">
                                <div class="row">
                                    <div class="col-8 mx-auto">
                                        <div class="form-group">
                                            <label for="name">@lang('role name')</label>
                                            <input name="name" type="text" class="form-control"
                                                   id="name" value="{{old('name') ? old('name') : $role->name}}" placeholder="@lang('example') : super_admin">
                                        </div>
                                        <div class="form-group">
                                            <label for="label">@lang('role description')</label>
                                            <input name="label" type="text" class="form-control"
                                                   id="label" value="{{old('label') ? old('label') : $role->label}}" placeholder="@lang('example') : @lang('super admin')">
                                        </div>

                                        <div class="form-group">
                                            <label for="icon">@lang('permission')</label>
                                            <select class="form-control" name="permission_id[]"
                                                    title="@lang('select')" multiple>
                                                @foreach($permissions as $permission)
                                                    <option value="{{$permission->id}}" {{ in_array(trim($permission->id) , $role->permissions->pluck('id')->toArray()) ? 'selected' : ''  }}>{{$permission->label}}
                                                        - {{$permission->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" class="btn btn-outline-success" value="@lang('submit')">
                        </div>
                    </div>
                </form>
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
    </script>
@endsection
