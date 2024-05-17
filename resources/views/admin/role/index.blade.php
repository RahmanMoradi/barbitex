@extends('layouts/contentLayoutMaster')

@section('title', trans('role management'))

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
                        <h4 class="card-title">
                            <a href="{{route('admin.roles.create')}}" class="btn btn-primary">
                                <i class="feather icon-plus"></i>
                                @lang('add a role')
                            </a>
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table class="table table-hover text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('role name')</th>
                                        <th>@lang('role description')</th>
                                        <th>@lang('permission')</th>
                                        <th>@lang('action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$role->name}}</td>
                                            <td>{{$role->label}}</td>
                                            <td>
                                                @foreach($role->permissions as $permission)
                                                    <span class="badge badge-primary">{{$permission->label}}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{route('admin.roles.edit', $role)}}"
                                                       class="btn btn-sm btn-warning">ویرایش</a>
                                                    <a href="" class="btn btn-sm btn-danger"
                                                       onclick="event.preventDefault(); confirm('آیا مطمئن هستید؟') ? $('#delete-form-{{$role->id}}').submit() : ''">حذف</a>
                                                </div>
                                                <form action="{{route('admin.roles.destroy', $role)}}" method="POST"
                                                      id="delete-form-{{$role->id}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('role name')</th>
                                        <th>@lang('role description')</th>
                                        <th>@lang('permission')</th>
                                        <th>@lang('action')</th>
                                    </tr>
                                    </tfoot>
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
@endsection
