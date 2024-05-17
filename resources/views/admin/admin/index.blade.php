@extends('layouts/contentLayoutMaster')

@section('title', trans('admins management'))

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
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse">
                                    <h4 class="card-title">
                                        <i class="feather icon-plus"></i>
                                        @lang('create new admin')
                                    </h4>
                                </a>
                            </li>
                        </ul>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <br>
                    <div class="card-content collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form autocomplete="off" method="post" class="needs-validation mt-1" novalidate=""
                                          action="{{route('admin.admin.store')}}"
                                          style="">
                                        @csrf
                                        <div class="row col-md-7 col-12 m-md-auto ml-0 p-0">
                                            <div class="col-md-6 p-0 px-md-1 form-group">
                                                <label for="subject">@lang('full name')</label>
                                                <input type="text" class="form-control round" name="name"
                                                       id="name" placeholder="@lang('full name')" required=""
                                                       value="{{old('name')}}">
                                                <div class="invalid-feedback">@lang('please enter full name')</div>
                                            </div>
                                            <div class="col-md-6 p-0 px-md-1 form-group">
                                                <label for="category_id">@lang('role')</label>
                                                <select class="form-control round" name="role_id" id="role_id"
                                                        required="">
                                                    <option value="" disabled="" selected="">
                                                        @lang('select')
                                                    </option>
                                                    @foreach($roles as $role)
                                                        <option
                                                            value="{{$role->id}}">{{$role->label}}
                                                            - {{$role->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">@lang('please select the role')</div>
                                            </div>

                                            <div class="col-md-6 p-0 px-md-1 form-group">
                                                <label for="email">@lang('email')</label>
                                                <input type="text" class="form-control round" name="email"
                                                       id="email" placeholder="@lang('email')" required=""
                                                       value="{{old('email')}}">
                                            </div>
                                            <div class="col-md-6 p-0 px-md-1 form-group">
                                                <label for="mobile">@lang('mobile')</label>
                                                <input type="text" class="form-control round" name="mobile"
                                                       id="mobile" placeholder="@lang('mobile')" required=""
                                                       value="{{old('mobile')}}">
                                            </div>
                                            <div class="col-md-12 p-0 px-md-1 form-group">
                                                <label for="password">@lang('password')</label>
                                                <input type="password" class="form-control round" name="password"
                                                       id="password" placeholder="@lang('password')" required=""
                                                       value="{{old('password')}}">
                                            </div>

                                            <div class="progress progress-bar-primary progress-lg w-100"
                                                 style="display: none">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="0"
                                                     aria-valuemin="0" aria-valuemax="100" style="width:0%">0%
                                                </div>
                                            </div>
                                            <div class="col-md-6 m-auto">
                                                <button type="submit"
                                                        class="btn btn-block btn-primary round waves-effect waves-light">
                                                    @lang('submit')
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                    <thead>
                                    <tr>
                                        <td>@lang('id')</td>
                                        <td>@lang('full name')</td>
                                        <td>@lang('role')</td>
                                        <td>@lang('email')</td>
                                        <td>@lang('mobile')</td>
                                        <td>@lang('action')</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($admins as $admin)
                                        <tr>
                                            <td>{{$admin->id}}</td>
                                            <td>{{$admin->name}}</td>
                                            <td>
                                                @foreach($admin->roles as $role)
                                                    <span class="badge badge-success">{{$role->label}}</span>
                                                @endforeach
                                            </td>
                                            <td>{{$admin->email}}</td>
                                            <td>{{$admin->mobile}}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{route('admin.admin.edit',['admin' => $admin])}}"
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{route('admin.admin.delete',['admin' => $admin])}}"
                                                       class="btn btn-sm btn-outline-danger">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </div>
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
@endsection
