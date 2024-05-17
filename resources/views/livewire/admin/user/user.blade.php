<section id="dashboard-analytics">
    <div class="row">
        {{--        action box--}}
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <a href="/wa-admin/tickets?user_id={{$user->id}}" class="btn btn-primary">
                            <i class="fa fa-send"></i>
                            @lang('send ticket to this user')
                        </a>
                        <a href="#logs" class="btn btn-primary">
                            <i class="fa fa-key"></i>
                            @lang('user login logs')
                        </a>
                        <a href="#subsets" class="btn btn-primary">
                            <i class="fa fa-users"></i>
                            @lang('user subsets')
                        </a>
                        @if ($user->parent_id)
                            <a target="_blank" href="{{route('admin.user.show',['user' =>$user->parent??0 ])}}"
                               class="btn btn-info">
                                @lang('this user subset of',['user' => optional($user->parent)->id])
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-6">
                                <form wire:submit.prevent="update" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <fieldset class="form-label-group form-group">
                                        <input wire:model.lazy="name" type="text" class="form-control"
                                               id="name" value="{{$user->name}}">
                                        <label for="name">نام و نام خانوادگی</label>
                                    </fieldset>
                                    <fieldset class="form-label-group form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <label class="btn" for="mobile">موبایل</label>
                                            </div>
                                            <input type="text" class="form-control" id="mobile" wire:model.lazy="mobile"
                                                   value="{{$user->mobile}}">
                                            <div class="input-group-append">
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="changeStatus('mobile',{{$user->hasVerifiedMobile() ? 0 : 1}})"
                                                   class="btn btn-outline-{{$user->hasVerifiedMobile() ? 'danger' : 'success'}} waves-effect waves-light">
                                                    <i class="fa {{$user->hasVerifiedMobile() ? 'fa-ban' : 'fa-check'}}"></i>
                                                    {{$user->hasVerifiedMobile() ? 'رد' : 'تائید'}}
                                                </a>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-label-group form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <label class="btn" for="email">ایمیل</label>
                                            </div>
                                            <input type="text" class="form-control" id="email" wire:model.lazy="email"
                                                   value="{{$user->email}}">
                                            <div class="input-group-append">
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="changeStatus('email',{{$user->hasVerifiedEmail() ? 0 : 1}})"
                                                   class="btn btn-outline-{{$user->hasVerifiedEmail() ? 'danger' : 'success'}} waves-effect waves-light">
                                                    <i class="fa {{$user->hasVerifiedEmail() ? 'fa-ban' : 'fa-check'}}"></i>
                                                    {{$user->hasVerifiedEmail() ? 'رد' : 'تائید'}}
                                                </a>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-label-group form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <label class="btn" for="birthday">تاریخ تولد</label>
                                            </div>
                                            <input type="text" readonly class="form-control" id="birthday"
                                                   value="{{$user->birthday}}">
                                        </div>
                                    </fieldset>

                                    <input type="submit" class="btn btn-outline-primary" value="ثبت اطلاعات">
                                </form>
                                <hr>
                                <form wire:submit.prevent="changePassword"
                                      method="post">
                                    @csrf
                                    <div class="col-12 mt-2">
                                        <fieldset class="form-label-group form-group">
                                            <input wire:model.lazy="password" type="password" class="form-control"
                                                   id="password">
                                            <label for="password">رمز عبور</label>
                                        </fieldset>

                                        <fieldset class="form-label-group form-group">
                                            <input wire:model.lazy="password_confirmation" type="password"
                                                   class="form-control"
                                                   id="password_confirmation">
                                            <label for="password_confirmation">تکرار رمز عبور</label>
                                        </fieldset>
                                    </div>
                                    <input type="submit" class="btn btn-outline-success" value="تغییر رمز">
                                </form>
                            </div>
                            <div class="col-6">
                                آخرین کد ارسال شده برای کاربر : {{$validCode}}
                                <div class="form-group mt-1">
                                    {!! $user->document_status !!}
                                    <a href="{{asset(optional($user->docs)->title)}}" target="_blank">
                                        <img src="{{asset(optional($user->docs)->title)}}" alt=""
                                             title="برای مشاهده در اندازه واقعی بر روی عکس کلیک کنید!"
                                             class="img-rounded img-responsive"
                                             style="width: 100%; height: 350px!important;">
                                    </a>
                                </div>
                                <div class="col-12 mt-4">
                                    <a href="javascript:void(0)"
                                       wire:click.prevent="documentChangeStatus('new')"
                                       class="btn btn-outline-info">
                                        در حال بررسی
                                    </a>
                                    <a href="javascript:void(0)"
                                       wire:click.prevent="documentChangeStatus('accept')"
                                       class="btn btn-outline-success">
                                        تائید
                                    </a>
                                    <a href="javascript:void(0)"
                                       wire:click.prevent="documentChangeStatus('failed')"
                                       class="btn btn-outline-danger">رد
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <hr>
                                <h3>سرویس استعلام کاربر</h3>
                                <div class="btn-group">
                                    <button class="btn btn-success"
                                            wire:loading.attr="disabled"
                                            wire:click="matchingMobileWithNational">استعلام موبایل با کد ملی</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <livewire:admin.user.cards :user_id="$user->id"/>

            <div class="card">
                <div class="card-header">
                    <h3>لیست موجودی کاربر</h3>
                </div>
                <div class="card-content">
                    <div class="card-body p-0 p-md-1">
                        <div class="row">
                            <div class="col-md-12 mb-5">
                                <table
                                    class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                    <thead>
                                    <tr>
                                        <th>ارز</th>
                                        <th>موجودی</th>
                                        <th>موجودی قابل برداشت</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($balances as $balance)
                                        <tr>
                                            <td>{{$balance->currency}}</td>
                                            <td>{{\App\Helpers\Helper::formatAmountWithNoE($balance->balance,2)}}</td>
                                            <td>{{\App\Helpers\Helper::formatAmountWithNoE($balance->balance_free,2)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{$balances->links()}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>مدیریت کیف پول کاربر</h3>
                    <p>موجودی تومان : {{number_format($user->balance)}}</p>
                </div>
                <div class="card-content">
                    <div class="card-body p-0 p-md-1">
                        <div class="row">
                            <div class="col-md-6 mb-5">
                                <form wire:submit.prevent="walletStore" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="currency">نوع ارز</label>
                                        <select wire:model.lazy="currency" class="select2 form-control">
                                            @if (!App\Helpers\Helper::modules()['api_version'] === 2)
                                                <option value="IRT">IRT</option>
                                            @endif
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->symbol}}">{{$currency->symbol}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">نوع تراکنش</label>
                                        <select wire:model.lazy="type" class="form-control">
                                            <option value="">انتخاب کنید...</option>
                                            <option value="increment">افزایش اعتبار</option>
                                            <option value="decrement">کاهش اعتبار</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="paice">مبلغ مورد نظر</label>
                                        <input type="text" wire:model.lazy="price" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">توضیحات</label>
                                        <textarea class="form-control" wire:model.lazy="description"></textarea>
                                    </div>
                                    <input type="submit" class="btn btn-outline-success" value="ثبت">
                                </form>
                            </div>
                            <div class="col-md-6 mb-5">
                                <form wire:submit.prevent="maxBuyUpdate"
                                      method="post">
                                    @csrf
                                    <div class="form-group">
                                        <p>تغییر اعتبار سقف خرید کاربر</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="max_buy">سقف اعتبار</label>
                                        <input type="number" wire:model.lazy="max_buy" value="{{$user->max_buy}}"
                                               class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <p>جهت تغییر سقف اعتبار کاربر بعد از تکمیل فرم بالا دکمه ثبت را فشار
                                            دهید</p>
                                    </div>
                                    <input type="submit" class="btn btn-outline-success" value="ثبت">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <livewire:admin.wallet.transactions :user_id="$user->id"/>

            <div class="card">
                <div class="card-header">
                    <h3>ثبت سفارش برای کاربر</h3>
                </div>
                <div class="card-content">
                    <div class="card-body p-0 p-md-1">
                        <div class="row">
                            <div class="col-md-6 mb-5 mx-auto">
                                <form wire:submit.prevent="addOrder" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="orderMarket">بازار</label>
                                        <select wire:model.lazy="orderMarketId" class="select2 form-control">
                                            <option value="">انتخاب کنید...</option>
                                            @foreach($markets as $market)
                                                <option value="{{$market->id}}">{{$market->symbol}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">نوع تراکنش</label>
                                        <select wire:model.lazy="orderType" class="form-control">
                                            <option value="">انتخاب کنید...</option>
                                            <option value="buy">خرید</option>
                                            <option value="sell">فروش</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="orderPrice">تعداد مورد نظر</label>
                                        <input type="text" wire:model.lazy="orderQty" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="orderPrice">مبلغ مورد نظر</label>
                                        <input type="text" wire:model.lazy="orderPrice" class="form-control">
                                    </div>

                                    <button type="submit" class="btn btn-outline-success">ثبت سفارش</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="log">
                <livewire:auth-log.auth-log :user_id="$user->id"/>
            </div>
            <div id="subsets">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="title">@lang('user subsets')</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body p-0 p-md-1">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                            <thead>
                                            <tr>
                                                <th>@lang('id')</th>
                                                <th>@lang('user')</th>
                                                <th>@lang('created at')</th>
                                                <th>@lang('email')</th>
                                                <th>@lang('document status')</th>
                                                <th>@lang('card status')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($subsets as $subset)
                                                <tr>
                                                    <td>{{$subset->id}}</td>
                                                    <td>{{$subset->name}}</td>
                                                    <td>{{$subset->email}}</td>
                                                    <td>{!! $subset->created_at_fa !!}</td>
                                                    <td>{{$subset->document_status_text}}</td>
                                                    <td>{{$subset->cardActive ? __('active') : 'deactive'}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <hr>
                                        {{$subsets->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
