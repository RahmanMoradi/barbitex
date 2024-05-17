<section id="dashboard-analytics">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        لیست کاربران
                    </h4>
                    <input type="text" class="col-md-4 form-control form-control-sm round" wire:model.lazy="search"
                           placeholder="جستجو...">
                </div>
                <div class="card-content">
                    <div class="card-body p-0 p-md-1">
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                <thead>
                                <tr>
                                    <td>
                                        موجودی های دارای اختلاف
                                    </td>
                                </tr>
                                <tr>
                                    <td>شناسه کاربر</td>
                                    <td>ارز</td>
                                    <td>موجودی</td>
                                    <td>موجودی قابل برداشت</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wrongBalance as $balance)
                                    <tr>
                                        <td>{{$balance->user_id}}</td>
                                        <td>{{$balance->currency}}</td>
                                        <td>{{$balance->balance}}</td>
                                        <td>{{$balance->balance_free}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <table
                                class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                <thead>
                                <tr>
                                    <td>شناسه کاربر</td>
                                    <td>نام و نام خانوادگی</td>
                                    <td>ایمیل</td>
                                    <td>تلفن</td>
                                    <td>موبایل</td>
                                    <td>تاریخ ثبت نام</td>
                                    <td>وضعیت</td>
                                    <td>موجودی</td>
                                    <td>عملیات</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->mobile}}</td>
                                        <td>{!! $user->created_at_fa !!}</td>
                                        <td>{!! $user->status_html!!}</td>
                                        <td><span
                                                class="badge badge-info">{{number_format($user->balance)}} تومان</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{route('admin.user.show',['user' => $user])}}"
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)" wire:click.prevent="delete({{$user}})"
                                                   class="btn btn-sm btn-outline-danger">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
