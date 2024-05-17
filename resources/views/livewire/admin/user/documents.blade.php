<section id="dashboard-analytics">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-content">
                    <div class="card-body p-0 p-md-1">
                        <div class="table-responsive">
                            <h3>در حال بررسی</h3>
                            <table
                                class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                <thead>
                                <tr>
                                    <td>شناسه مدرک</td>
                                    <td>نام و نام خانوادگی</td>
                                    <td>موبایل</td>
                                    <td>تاریخ ارسال</td>
                                    <td>تاریخ ویرایش</td>
                                    <td>وضعیت</td>
                                    <td>عملیات</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($newDocuments as $doc)
                                    <tr>
                                        <td>{{$doc->id}}</td>
                                        <td>{{optional($doc->user)->name}}</td>
                                        <td>{{optional($doc->user)->mobile}}</td>
                                        <td>{!! $doc->created_at_fa !!}</td>
                                        <td>{!! $doc->updated_at_fa !!}</td>
                                        <td>{!! $doc->status_fa!!}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{asset($doc->title)}}" target="_blank"
                                                   class="btn btn-outline-info">مشاهده</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="update({{$doc}},'new')"
                                                   class="btn btn-outline-info">بررسی</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="update({{$doc}},'accept')"
                                                   class="btn btn-outline-success">تائید</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="update({{$doc}},'failed')"
                                                   class="btn btn-outline-danger">رد</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <h3>تائید شده</h3>
                            <table
                                class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                <thead>
                                <tr>
                                    <td>شناسه مدرک</td>
                                    <td>نام و نام خانوادگی</td>
                                    <td>موبایل</td>
                                    <td>تاریخ ارسال</td>
                                    <td>تاریخ ویرایش</td>
                                    <td>وضعیت</td>
                                    <td>عملیات</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($acceptDocuments as $doc)
                                    <tr>
                                        <td>{{$doc->id}}</td>
                                        <td>{{optional($doc->user)->name}}</td>
                                        <td>{{optional($doc->user)->mobile}}</td>
                                        <td>{!! $doc->created_at_fa !!}</td>
                                        <td>{!! $doc->updated_at_fa !!}</td>
                                        <td>{!! $doc->status_fa!!}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{asset($doc->title)}}" target="_blank"
                                                   class="btn btn-outline-info">مشاهده</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="update({{$doc}},'new')"
                                                   class="btn btn-outline-info">بررسی</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="update({{$doc}},'accept')"
                                                   class="btn btn-outline-success">تائید</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="update({{$doc}},'failed')"
                                                   class="btn btn-outline-danger">رد</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <h3>رد شده</h3>
                            <table
                                class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                <thead>
                                <tr>
                                    <td>شناسه مدرک</td>
                                    <td>نام و نام خانوادگی</td>
                                    <td>موبایل</td>
                                    <td>تاریخ ارسال</td>
                                    <td>تاریخ ویرایش</td>
                                    <td>وضعیت</td>
                                    <td>عملیات</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($failedDocuments as $doc)
                                    <tr>
                                        <td>{{$doc->id}}</td>
                                        <td>{{optional($doc->user)->name}}</td>
                                        <td>{{optional($doc->user)->mobile}}</td>
                                        <td>{!! $doc->created_at_fa !!}</td>
                                        <td>{!! $doc->updated_at_fa !!}</td>
                                        <td>{!! $doc->status_fa!!}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{asset($doc->title)}}" target="_blank"
                                                   class="btn btn-outline-info">مشاهده</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="update({{$doc}},'new')"
                                                   class="btn btn-outline-info">بررسی</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="update({{$doc}},'accept')"
                                                   class="btn btn-outline-success">تائید</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="update({{$doc}},'failed')"
                                                   class="btn btn-outline-danger">رد</a>
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
