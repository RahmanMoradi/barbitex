<div>
    <section id="markets">
        <div class="card  shadow-none">
            <div class="card-header">
                <h4 class="card-title">بازارها</h4>
                <div class="btn-group btn-group-sm">
                    <button data-toggle="modal" data-target="#createModal" class="btn btn-success">
                        <i class="fa fa-plus"></i>
                        ایجاد بازار جدید
                    </button>
                    <button wire:click.prevent="deleteAll" class="btn btn-danger">
                        <i class="fa fa-trash-o"></i>
                        حذف همه
                    </button>
                    <button wire:click.prevent="changeStatusAll(0)" class="btn btn-dark">
                        <i class="fa fa-stop"></i>
                        غیر فعال کردن همه
                    </button>
                    <button wire:click.prevent="changeStatusAll(1)" class="btn btn-light">
                        <i class="fa fa-play"></i>
                        فعال کردن همه
                    </button>
                    <button wire:click.prevent="addMarketToRedis" class="btn btn-primary">
                        <i class="fa fa-database"></i>
                        اضافه کردن بازاها به ردیس
                    </button>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>بازار</th>
                            <th>قیمت</th>
                            <th>تغییرات</th>
                            <th>وضعیت</th>
                            <th>api</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($marketsList as $market)
                            <tr class="cursor-pointer">
                                <td>
                                    <span class="text-center">
{{--                                        <img src="{{asset(optional($market['currencyBuyer'])->iconUrl)}}" height="20"/>--}}
                                        {{$market['symbol']}}
                                    </span>
                                </td>
                                <td>{{$market['price']}}</td>
                                <td>
                                    <span
                                        class="badge {{$market['change_24'] > 0 ? 'badge-success' :'badge-danger'}}  badge-pill text-center">
                                        {{$market['change_24']}} %
                                    </span>
                                </td>
                                <td>
                                    {!! $market['status_fa_html'] !!}
                                </td>
                                <td>
                                    {{$market['market']}}
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if (!$market['status'])
                                            <a href="javascript:void(0)"
                                               wire:click.prevent="changeStatus({{$market['id']}})"
                                               class="btn btn-sm btn-success">فعال</a>
                                        @else
                                            <a href="javascript:void(0)"
                                               wire:click.prevent="changeStatus({{$market['id']}})"
                                               class="btn btn-sm btn-dark">غیرفعال</a>
                                        @endif
                                        <a href="#" class="btn btn-sm btn-info"
                                           wire:click.prevent="edit({{$market['id']}})">
                                            <i class="fa fa-edit"></i>
                                            ویرایش
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger"
                                           wire:click.prevent="delete({{$market['id']}})">
                                            <i class="fa fa-trash-o"></i>
                                            حذف
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
    </section>
    <div class="modal" id="createModal" wire:ignore.self tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ایجاد بازار جدید</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="symbol">نماد</label>
                                <input type="text" wire:model.lazy="symbol" class="form-control"
                                       placeholder="مثال:  BTC-USDT">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currencyBuy">ارز پایه</label>
                                <select wire:model.lazy="currency_buy" id="currencyBuy" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($buyCurrencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->symbol}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="active">وضعیت</label>
                                <select wire:model.lazy="status" id="active" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    <option value="1">فعال</option>
                                    <option value="0">غیر فعال</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currencySell">ارز تبدیل</label>
                                <select wire:model.lazy="currency_sell" id="currencySell" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($sellCurrencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->symbol}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="market">بازار</label>
                                <select wire:model.lazy="market" id="market" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    @foreach(array_diff(\App\Helpers\Helper::markets(),['manual']) as $market)
                                        <option value="{{$market}}">{{$market}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="store" class="btn btn-primary">ایجاد بازار</button>
                    <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal editModal" id="editModal" wire:ignore.self tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ویرایش بازار</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="symbol">نماد</label>
                                <input type="text" wire:model.lazy="symbol" class="form-control"
                                       placeholder="مثال:  BTCUSDT">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currencyBuy">ارز پایه</label>
                                <select wire:model.lazy="currency_buy" id="currencyBuy" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($buyCurrencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->symbol}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="active">وضعیت</label>
                                <select wire:model.lazy="status" id="active" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    <option value="1">فعال</option>
                                    <option value="0">غیر فعال</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currencySell">ارز تبدیل</label>
                                <select wire:model.lazy="currency_sell" id="currencySell" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($sellCurrencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->symbol}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="market">بازار</label>
                                <select wire:model.lazy="market" id="market" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    @foreach(array_diff(\App\Helpers\Helper::markets(),['manual']) as $market)
                                        <option value="{{$market}}">{{$market}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="update({{$marketEdit}})" class="btn btn-primary"
                            wire:loading.attr="disabled">ویرایش
                        بازار
                    </button>
                    <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>
</div>
