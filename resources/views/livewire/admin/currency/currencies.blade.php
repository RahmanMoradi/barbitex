<div>
    <wire:refresh/>
    <section id="dashboard-analytics">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">

                            <label for="usdAutoUpdate">آپدیت اتوماتیک قیمت تتر</label>
                            <input type="checkbox"
                                   id="usdAutoUpdate"
                                   name="usdAutoUpdate"
                                   wire:change="autoUpdate"
                                {{Setting::get('usdAutoUpdate') ? 'checked' : ''}}
                            >
                            <hr>
                            @if (Setting::get('usdAutoUpdate'))
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">در صد اضافه به قیمت تتر (فروش به کاربر)</label>
                                            <input name="dollar_sell_pay_percent" type="text" class="form-control"
                                                   wire:model.lazy="dollar_sell_pay_percent" placeholder="درصد خرید تتر"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">در صد کم شده قیمت تتر (خرید از کاربر)</label>
                                            <input name="dollar_buy_pay_percent" type="text" class="form-control"
                                                   wire:model.lazy="dollar_buy_pay_percent" placeholder="درصد فروش تتر"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">در صد اضافه به قیمت کوین ها(فروش به کاربر)</label>
                                            <input name="currency_sell_pay_percent" type="text" class="form-control"
                                                   wire:model.lazy="currency_sell_pay_percent"
                                                   placeholder="درصد خرید کوین ها"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">در صد کم شده قیمت کوین ها (خرید از کاربر)</label>
                                            <input name="currency_buy_pay_percent" type="text" class="form-control"
                                                   wire:model.lazy="currency_buy_pay_percent" placeholder="درصد فروش کوین ها"
                                            >
                                        </div>
                                    </div>
                                    @if (in_array('perfectmoney',\App\Helpers\Helper::markets()))
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">در صد اضافه به پرفکت مانی(فروش به کاربر)</label>
                                                <input name="perfectmoney_sell_pay_percent" type="text"
                                                       class="form-control"
                                                       wire:model.lazy="perfectmoney_sell_pay_percent"
                                                       placeholder="درصد خرید پرفکت مانی"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">در صد کم شده پرفکت مانی (خرید از کاربر)</label>
                                                <input name="perfectmoney_buy_pay_percent" type="text"
                                                       class="form-control"
                                                       wire:model.lazy="perfectmoney_buy_pay_percent"
                                                       placeholder="درصد فروش پرفکت مانی"
                                                >
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12 mt-1">
                                        <div class="form-group">
                                            <button type="submit" wire:click="changePercent"
                                                    class="btn btn-outline-success">ثبت
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            @else

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">قیمت (تتر) فروش به کاربر</label>
                                            <input name="dollar_sell_pay" type="text" class="form-control"
                                                   wire:model.lazy="dollar_sell_pay" placeholder="قیمت خرید تتر">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">قیمت (تتر) خرید به کاربر</label>
                                            <input name="dollar_buy_pay" type="text" class="form-control"
                                                   wire:model.lazy="dollar_buy_pay" placeholder="قیمت فروش تتر">
                                        </div>
                                    </div>
                                    <div class="col-4 mt-1">
                                        <div class="form-group">
                                            <button type="submit" wire:click="changePrice"
                                                    class="btn btn-outline-success">ثبت
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <div class="col-md-8 btn-group btn-group-sm">
                                <a href="#" data-toggle="modal" data-target="#createModal" class="btn btn-primary">
                                    <i class="feather icon-plus"></i>
                                    ثبت ارز جدید
                                </a>
                                <a href="#" class="btn btn-success" wire:click.prevent="changeActive(1)">
                                    <i class="feather icon-check"></i>
                                    فعال کردن همه
                                </a>
                                <a href="#" class="btn btn-danger" wire:click.prevent="changeActive(0)">
                                    <i class="feather icon-stop-circle"></i>
                                    غیر فعال کردن همه
                                </a>
                                <a href="#" class="btn btn-info" wire:click.prevent="changeNetwork">
                                    <i class="feather icon-edit-1"></i>
                                    بروز رسانی همه ارزها
                                </a>
                                <a href="3" class="btn btn-secondary" wire:click.prevent="$set('filter','status')">
                                    <i class="feather icon-status"></i>
                                    نمایش ارزهای غیر فعال
                                </a>
                            </div>
                            <input class="col-md-4 float-right form-control form-control-sm round" type="text"
                                   placeholder="جستجو..."
                                   wire:change="filter"
                                   wire:model.lazy="search">
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover-animation col-md-12 mx-auto"
                                       id="basic-list-group">
                                    <thead>
                                    <tr>
                                        <td>ارز</td>
                                        <td>مارکت</td>
                                        <td>نماد</td>
                                        <td>قیمت</td>
                                        <td>قیمت فروش به ما</td>
                                        <td>قیمت خرید از ما</td>
                                        <td>وضعیت</td>
                                        <td>عملیات</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($currencies as $currency)
                                        <tr class="{{$currency->networks->count() < 1 ? 'bg-dark':''}}">
                                            <td>
                                                <img src="{{asset($currency->icon_url)}}"
                                                     class="img-fluid" width="40px">
                                                <p class="text-danger">{{$currency->networks->count() <1 ?'شبکه این ارز موجود نیست':''}}</p>
                                            </td>
                                            <td>{{$currency->market}}</td>
                                            <td>{{$currency->symbol}}</td>
                                            <td>{{number_format($currency->price,$currency->decimal)}}</td>
                                            <td>
                                                <span id=""
                                                      style="">{{number_format($currency->receive_price,$currency->decimal)}}</span>
                                            </td>
                                            <td>
                                                <span id=""
                                                      style="">{{number_format($currency->send_price,$currency->decimal)}}</span>
                                            </td>
                                            <td>
                                                <input type="checkbox" id="{{$currency->id}}"
                                                       name="active"
                                                       {{$currency->active ? 'checked' : ''}} wire:change="changeStatus({{$currency}})">
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <i wire:click="changePosition('up-{{$currency->id}}')"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title="بالا"
                                                       class="btn btn-outline-success fa fa-arrow-up up cursor-pointer"></i>
                                                    <i wire:click="changePosition('down-{{$currency->id}}')"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title="پایین"
                                                       class="btn btn-outline-danger fa fa-arrow-down down cursor-pointer"></i>
                                                    <a href="#" wire:click.prevent="edit({{$currency->id}})"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title="ویرایش"
                                                       class="btn btn-outline-info">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title="حذف"
                                                       wire:click="delete({{$currency}})"
                                                       class="btn btn-outline-danger">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                    <a href="javascript:void(0)"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title="سوزاندن txid های این ارز"
                                                       wire:click="burnTxids({{$currency}})"
                                                       class="btn btn-outline-primary">
                                                        <i class="fa fa-history"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $currencies->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal bd-example-modal-lg" tabindex="-1" role="dialog" id="createModal" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ایجاد ارز جدید</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="symbol">نماد ارز</label>
                                <input wire:model.lazy="symbol" type="text" class="form-control"
                                       id="symbol" value="{{old('symbol')}}" placeholder="مثال : BTC">
                            </div>
                            <div class="form-group">
                                <label for="name">نام ارز (فارسی)</label>
                                <input wire:model.lazy="name" type="text" class="form-control"
                                       id="name" value="{{old('name')}}" placeholder="مثال : بیتکوین">
                            </div>
                            <div class="form-group">
                                <label for="chart_name">نام چارت (از سایت arzdigital.com)</label>
                                <input wire:model.lazy="chart_name" type="text" class="form-control"
                                       id="chart_name" value="{{old('chart_name')}}" placeholder="مثال : btc">
                            </div>
                            <div class="form-group">
                                <label for="market">صرافی</label>
                                <select wire:model.lazy="market" class="form-control">
                                    <option value="">انتخاب کنید...</option>
                                    @foreach(\App\Helpers\Helper::markets() as $market)
                                        <option value="{{$market}}">{{$market}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="decimal">نمایش تعداد رقم اعشار</label>
                                <input wire:model.lazy="decimal" type="text" class="form-control"
                                       id="decimal" value="{{old('decimal')}}" placeholder="مثال : 6">
                            </div>
                            <div class="form-group">
                                <label for="decimal_size">تعداد رقم در هنگام معامله</label>
                                <input wire:model.lazy="decimal_size" type="text" class="form-control"
                                       id="decimal" value="{{old('decimal_size')}}" placeholder="مثال : 6">
                            </div>

                            <div class="form-group">
                                <label for="explorer">صفحه اطلاعات txid (explorer)</label>
                                <input wire:model.lazy="explorer" type="text" class="form-control"
                                       id="decimal" value="{{old('explorer')}}"
                                       placeholder="مثال : https://www.blockchain.com/btc/tx/">
                            </div>

                            <div class="form-group col-6">
                                <label for="icon">آیکون ارز</label>
                                <input type="file" wire:model.lazy="icon">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="description_buy">توضیحات صفحه خرید از ما</label>
                                <textarea class="editor"
                                          wire:model.lazy="description_buy">{{old('description_buy')}}</textarea>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="description_sell">توضیحات صفحه فروش به ما</label>
                                <textarea wire:model.lazy="description_sell"
                                          class="editor">{{old('description_sell')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div wire:loading wire:target="icon">درحال بارگذاری...</div>
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:target="icon"
                            wire:key="storeBtn" wire:click.prevent="store">ایجاد
                    </button>
                    <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">انصراف
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bd-example-modal-lg editModal" tabindex="-1" role="dialog" id="editModal" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ایجاد ارز جدید</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="symbol">نماد ارز</label>
                                <input wire:model.lazy="symbol" type="text" class="form-control"
                                       id="symbol" value="{{old('symbol')}}" placeholder="مثال : BTC">
                            </div>
                            <div class="form-group">
                                <label for="name">نام ارز (فارسی)</label>
                                <input wire:model.lazy="name" type="text" class="form-control"
                                       id="name" value="{{old('name')}}" placeholder="مثال : بیتکوین">
                            </div>
                            <div class="form-group">
                                <label for="chart_name">نام چارت (از سایت arzdigital.com)</label>
                                <input wire:model.lazy="chart_name" type="text" class="form-control"
                                       id="chart_name" value="{{old('chart_name')}}"
                                       placeholder="مثال : bitcoin-chart.png">
                            </div>
                            <div class="form-group">
                                <label for="explorer">صفحه اطلاعات txid (explorer)</label>
                                <input wire:model.lazy="explorer" type="text" class="form-control"
                                       id="decimal" value="{{old('explorer')}}"
                                       placeholder="مثال : https://www.blockchain.com/btc/tx/">
                            </div>
                            <div class="form-group">
                                <label for="market">صرافی</label>
                                <select wire:model.lazy="market" class="form-control">
                                    <option value="">انتخاب کنید...</option>
                                    @foreach(\App\Helpers\Helper::markets() as $market)
                                        <option value="{{$market}}">{{$market}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="decimal">نمایش تعداد رقم اعشار</label>
                                <input wire:model.lazy="decimal" type="text" class="form-control"
                                       id="decimal" value="{{old('decimal')}}" placeholder="مثال : 6">
                            </div>
                            <div class="form-group">
                                <label for="decimal_size">تعداد رقم در هنگام معامله</label>
                                <input wire:model.lazy="decimal_size" type="text" class="form-control"
                                       id="decimal" value="{{old('decimal_size')}}" placeholder="مثال : 6">
                            </div>
                            <div class="{{$class}}">
                                <div class="form-group">
                                    <label for="price">قیمت ارز</label>
                                    <input type="text" wire:model.lazy="price" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="percent">درصد ارز</label>
                                    <input type="text" wire:model.lazy="percent" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="icon">آیکون ارز</label>
                                <input type="file" wire:model.lazy="icon">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="description_buy">توضیحات صفحه خرید از ما</label>
                                <textarea class="editor"
                                          wire:model.lazy="description_buy">{{old('description_buy')}}</textarea>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="description_sell">توضیحات صفحه فروش به ما</label>
                                <textarea wire:model.lazy="description_sell"
                                          class="editor">{{old('description_sell')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div wire:loading wire:target="icon">درحال بارگذاری...</div>
                    <button type="button" class="btn btn-primary" wire:key="storeBtn" wire:click.prevent="update">ویرایش
                    </button>
                    <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">انصراف
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
