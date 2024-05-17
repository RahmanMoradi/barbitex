@extends('layouts/contentLayoutMaster')

@section('title', 'پشتیبانی')

@section('vendor-style')
    {{-- vednor css files --}}
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
@endsection

@section('content')
    {{--    <!-- Column selectors with Export Options and print table -->--}}
    {{--    <section id="column-selectors">--}}
    {{--        <div class="row">--}}
    {{--            <div class="col-12">--}}
    {{--                <div class="card">--}}
    {{--                    <div class="card-header">--}}
    {{--                        <ul class="list-inline mb-0">--}}
    {{--                            <li>--}}
    {{--                                <a data-action="collapse">--}}
    {{--                                    <h4 class="card-title">--}}
    {{--                                        <i class="feather icon-plus"></i>--}}
    {{--                                        ثبت درخواست جدید--}}
    {{--                                    </h4>--}}
    {{--                                </a>--}}
    {{--                            </li>--}}
    {{--                        </ul>--}}
    {{--                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>--}}
    {{--                    </div>--}}
    {{--                    <br>--}}
    {{--                    <div class="card-content collapse">--}}
    {{--                        <div class="card-body">--}}
    {{--                            <div class="row">--}}
    {{--                                <div class="col-sm-12">--}}
    {{--                                    <form autocomplete="off" method="post" class="needs-validation mt-1" novalidate=""--}}
    {{--                                          action="{{url('wa-admin/tiket/store')}}" enctype="multipart/form-data"--}}
    {{--                                          style="">--}}
    {{--                                        @csrf--}}
    {{--                                        <div class="row col-md-7 col-12 m-md-auto ml-0 p-0">--}}
    {{--                                            <div class="col-md-6 p-0 px-md-1 form-group">--}}
    {{--                                                <label for="subject">موضوع</label>--}}
    {{--                                                <input type="text" class="form-control round" name="subject"--}}
    {{--                                                       id="subject" placeholder="موضوع خود را درج کنید" required=""--}}
    {{--                                                       value="{{old('subject')}}">--}}
    {{--                                                <div class="invalid-feedback">موضوع خود را انتخاب کنید</div>--}}
    {{--                                            </div>--}}
    {{--                                            <div class="col-md-6 p-0 px-md-1 form-group">--}}
    {{--                                                <label for="category_id">واحد</label>--}}
    {{--                                                <select class="form-control round" name="category_id" id="category_id"--}}
    {{--                                                        required="">--}}
    {{--                                                    <option value="" disabled="" selected="">--}}
    {{--                                                        واحد را انتخاب کنید--}}
    {{--                                                    </option>--}}
    {{--                                                    @foreach($category as $category)--}}
    {{--                                                        <option value="{{$category->id}}">{{$category->title}}</option>--}}
    {{--                                                    @endforeach--}}
    {{--                                                </select>--}}
    {{--                                                <div class="invalid-feedback">واحد را انتخاب کنید</div>--}}
    {{--                                            </div>--}}


    {{--                                            <div class="col-md-12 p-0 px-md-1 form-group">--}}
    {{--                                                <label for="user_id">کاربر</label>--}}
    {{--                                                <select class="form-control round" name="user_id" id="user_id">--}}
    {{--                                                    @foreach($users as $user)--}}
    {{--                                                        <option value="{{$user->id}}">{{$user->name}}</option>--}}
    {{--                                                    @endforeach--}}
    {{--                                                </select>--}}
    {{--                                            </div>--}}

    {{--                                            <div class="col-md-12 p-0 px-md-1 form-group">--}}
    {{--                                                <label for="message">توضیحات</label>--}}
    {{--                                                <textarea rows="5" name="message" id="message" required=""--}}
    {{--                                                          class="form-control round"--}}
    {{--                                                          placeholder="پیغام خود را درج کنید">{{old('message')}}</textarea>--}}
    {{--                                                <div class="invalid-feedback">پیغام خود را درج کنید</div>--}}
    {{--                                            </div>--}}

    {{--                                            <div class="col-md-12 p-0 px-md-1 form-group">--}}
    {{--                                                <label for="credit1">فایل پیوست</label>--}}
    {{--                                                <fieldset class="form-group">--}}
    {{--                                                    <div class="custom-file rounded">--}}
    {{--                                                        <input type="file" class="custom-file-input" name="file"--}}
    {{--                                                               id="file"--}}
    {{--                                                               accept="image/*,.doc,.docx,.pdf,application/zip,.rar">--}}
    {{--                                                        <label class="custom-file-label" for="file">انتخاب فایل</label>--}}
    {{--                                                    </div>--}}
    {{--                                                    <small class="font-small-2 text-center text-muted">پسوندهای مجاز:--}}
    {{--                                                        jpg, jpeg, png, pdf, doc, docx, zip, rar حداکثر حجم فایل 5--}}
    {{--                                                        مگابایت</small>--}}
    {{--                                                </fieldset>--}}
    {{--                                            </div>--}}

    {{--                                            <div class="progress progress-bar-primary progress-lg w-100"--}}
    {{--                                                 style="display: none">--}}
    {{--                                                <div class="progress-bar" role="progressbar" aria-valuenow="0"--}}
    {{--                                                     aria-valuemin="0" aria-valuemax="100" style="width:0%">0%--}}
    {{--                                                </div>--}}
    {{--                                            </div>--}}
    {{--                                            <div class="col-md-6 m-auto">--}}
    {{--                                                <button type="submit"--}}
    {{--                                                        class="btn btn-block btn-primary round waves-effect waves-light">--}}
    {{--                                                    ثبت درخواست--}}
    {{--                                                </button>--}}
    {{--                                            </div>--}}
    {{--                                        </div>--}}
    {{--                                    </form>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <div class="col-12">--}}
    {{--                <div class="card">--}}
    {{--                    <div class="card-header">--}}
    {{--                        <h4 class="card-title">پشتیبانی</h4>--}}
    {{--                    </div>--}}
    {{--                    <div class="card-content">--}}
    {{--                        <div class="card-body card-dashboard">--}}
    {{--                            <p class="card-text">--}}
    {{--                                لیست تیکت های ارسال شده را مشاهده میکنید .--}}
    {{--                            </p>--}}
    {{--                            <div class="table-responsive">--}}
    {{--                                <table class="table table-striped zero-configuration">--}}
    {{--                                    <thead>--}}
    {{--                                    <tr>--}}
    {{--                                        <th>#</th>--}}
    {{--                                        <th>موضوع</th>--}}
    {{--                                        <th>کاربر</th>--}}
    {{--                                        <th>واحد پشتیبانی</th>--}}
    {{--                                        <th>وضعیت</th>--}}
    {{--                                        <th>تاریخ ایجاد</th>--}}
    {{--                                        <th>آخرین بروزرسانی</th>--}}
    {{--                                        <th>عملیات</th>--}}
    {{--                                    </tr>--}}
    {{--                                    </thead>--}}
    {{--                                    <tbody>--}}
    {{--                                    @foreach($tikets as $ticket)--}}
    {{--                                        <tr>--}}
    {{--                                            <td>{{$ticket->id}}</td>--}}
    {{--                                            <td>--}}
    {{--                                                <a href="{{url('wa-admin/tiket',['ticket'=>$ticket])}}">{{$ticket->subject}}</a>--}}
    {{--                                            </td>--}}
    {{--                                            <td>--}}
    {{--                                                <a target="_blank" href="{{url('wa-admin/user',['user'=>optional($ticket->user)->id])}}">--}}
    {{--                                                    {{optional($ticket->user)->name}}--}}
    {{--                                                </a>--}}
    {{--                                            </td>--}}
    {{--                                            <td>{{optional($ticket->category)->title}}</td>--}}
    {{--                                            <td>{{$ticket->status_fa}}</td>--}}
    {{--                                            <td>{{$ticket->created_at}}</td>--}}
    {{--                                            <td>{{$ticket->updated_at}}</td>--}}
    {{--                                            <td>--}}
    {{--                                                <div class="btn-group btn-group-sm">--}}
    {{--                                                    <a href="{{url('wa-admin/tiket',['ticket'=>$ticket])}}"--}}
    {{--                                                       class="btn btn-outline-info">مشاهده</a>--}}
    {{--                                                    <a href="{{url('wa-admin/tiket/update',['ticket'=>$ticket,'status'=>'3'])}}"--}}
    {{--                                                       class="btn btn-outline-danger">--}}
    {{--                                                        بستن--}}
    {{--                                                    </a>--}}
    {{--                                                </div>--}}
    {{--                                            </td>--}}
    {{--                                        </tr>--}}
    {{--                                    @endforeach--}}
    {{--                                    </tbody>--}}
    {{--                                    <tfoot>--}}
    {{--                                    <tr>--}}
    {{--                                        <th>#</th>--}}
    {{--                                        <th>موضوع</th>--}}
    {{--                                        <th>واحد پشتیبانی</th>--}}
    {{--                                        <th>وضعیت</th>--}}
    {{--                                        <th>تاریخ ایجاد</th>--}}
    {{--                                        <th>آخرین بروزرسانی</th>--}}
    {{--                                    </tr>--}}
    {{--                                    </tfoot>--}}
    {{--                                </table>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}
    {{--    <!-- Column selectors with Export Options and print table -->--}}
    <livewire:ticket.tickets viewType="admin"/>
@endsection
@section('vendor-script')

@endsection
@section('myscript')
    {{-- Page js files --}}
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
