<div>
    @if (\App\Helpers\Helper::modules()['market'])
        <section id="markets">
            <div class="card  shadow-none">
                <div class="card-header">
                    <h4 class="card-title">سفارشات باز من(بازارهای حرفه ای)</h4>
                </div>
                <div class="card-content">
                    <div class="card-body table-responsive">
                        <table class="table data-list-view">
                            <thead>
                            <tr>
                                <th>شناسه سفارش</th>
                                <th>بازار</th>
                                <th>نوع</th>
                                <th>مقدار</th>
                                <th>قیمت واحد</th>
                                <th>قیمت کل</th>
                                <th>پر شده(%)</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($myOpenOrders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{optional($order->market)->symbol}}</td>
                                    <td>{!! $order->type_fa_html !!}</td>
                                    <td>
                                        {{$order->count}}
                                        {{optional($order->market)->currencyBuyer->symbol}}
                                    </td>
                                    <td>{{$order->price}} {{ optional($order->market->currencySeller)->symbol}} </td>
                                    <td>{{App\Helpers\Helper::numberFormatPrecisionString($order->sumPrice , optional($order->market->currencySeller)->decimal)}}  {{ optional($order->market->currencySeller)->symbol}}</td>
                                    <td>{{$order->remaining == 0 ? 100 : number_format(100 - (($order->remaining * 100) / $order->count),0)}}</td>
                                    <td>
                                        {!! $order->status_fa_html !!}
                                    </td>
                                    <td>
                                        <i class="fa fa-trash-o text-danger cursor-pointer"
                                           wire:click.prevent="delete({{$order}})"></i>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        {{$myOpenOrders->links()}}
                    </div>
                </div>
            </div>
        </section>
        <section id="markets">
            <div class="card  shadow-none">
                <div class="card-header">
                    <h4 class="card-title">سفارشات من(بازارهای حرفه ای)</h4>
                    <div class="row col-md-12 mt-3">
                        <div class="form-group col-md-3">
                            <label for="filterMarket">بازار</label>
                            <select wire:model.lazy="filterMarket" class="form-control form-control-sm round select2">
                                <option value="">انتخاب کنید</option>
                                @foreach($markets as $market)
                                    <option value="{{$market->id}}">{{$market->symbol}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filterType">نوع</label>
                            <select wire:model.lazy="filterType" class="form-control form-control-sm round select2">
                                <option value="">انتخاب کنید</option>
                                <option value="buy">خرید</option>
                                <option value="sell">فروش</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filterStatus">وضعیت</label>
                            <select wire:model.lazy="filterStatus" class="form-control form-control-sm round select2">
                                <option value="">انتخاب کنید</option>
                                <option value="init">باز</option>
                                <option value="done">انجام شده</option>
                                <option value="cancel">لغو شده</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filterStatus">جستجو..</label>
                            <input type="text" class="form-control form-control-sm round"
                                   wire:model.lazy="searchProfessional"
                                   placeholder="جستجو...">
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body table-responsive">
                        <table class="table data-list-view">
                            <thead>
                            <tr>
                                <th>شناسه سفارش</th>
                                <th>بازار</th>
                                <th>نوع</th>
                                <th>مقدار</th>
                                <th>قیمت واحد</th>
                                <th>قیمت کل</th>
                                <th>پر شده(%)</th>
                                <th>وضعیت</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($myOrders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{optional($order->market)->symbol}}</td>
                                    <td>{!! $order->type_fa_html !!}</td>
                                    <td>
                                        {{$order->count}}
                                        {{optional(optional($order->market)->currencyBuyer)->symbol}}
                                    </td>
                                    <td>{{$order->price}} {{ optional(optional($order->market)->currencySeller)->symbol}} </td>
                                    <td>{{App\Helpers\Helper::numberFormatPrecisionString($order->sumPrice , optional(optional($order->market)->currencySeller)->decimal)}}  {{ optional(optional($order->market)->currencySeller)->symbol}}</td>
                                    <td>{{$order->remaining == 0 ? 100 : number_format(100 - (($order->remaining * 100) / $order->count),0)}}</td>
                                    <td>
                                        {!! $order->status_fa_html !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        {{$myOrders->links()}}
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if (\App\Helpers\Helper::modules()['orderPlane'])
        <section id="orders">
            <div class="card  shadow-none">
                <div class="card-header">
                    <h4 class="card-title">سفارشات من(بازارهای ساده)</h4>
                    <div class="row col-md-12 mt-3">
                        <div class="form-group col-md-3">
                            <label for="filterPlainCurrency">ارز</label>
                            <select wire:model.lazy="filterPlainCurrency" class="form-control form-control-sm round select2">
                                <option value="">انتخاب کنید</option>
                                @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}">{{$currency->symbol}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filterPlainType">نوع</label>
                            <select wire:model.lazy="filterPlainType" class="form-control form-control-sm round select2">
                                <option value="">انتخاب کنید</option>
                                <option value="buy">خرید</option>
                                <option value="sell">فروش</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filterPlainStatus">وضعیت</label>
                            <select wire:model.lazy="filterPlainStatus" class="form-control form-control-sm round select2">
                                <option value="">انتخاب کنید</option>
                                <option value="new">جدید</option>
                                <option value="done">انجام شده</option>
                                <option value="process">در حال انجام</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="searchPlain">جستجو...</label>
                            <input type="text" class="form-control form-control-sm round" wire:model.lazy="searchPlain"
                                   placeholder="جستجو...">
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body table-responsive">
                        <table class="table data-list-view">
                            <thead>
                            <tr>
                                <th>شناسه سفارش</th>
                                <th>ارز</th>
                                <th>نوع</th>
                                <th>مقدار</th>
                                <th>مبلغ</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($planeOrders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{optional($order->currency)->symbol}}</td>
                                    <td>{!! $order->type_fa_html !!}</td>
                                    <td>
                                        {{$order->qty}}
                                        {{optional($order->currency)->symbol}}
                                    </td>
                                    <td>{{number_format($order->price)}} تومان</td>
                                    <td>
                                        {!! $order->status_fa_html !!}
                                    </td>
                                    <td>
                                        <a href="{{route('order.show',['order'=>$order])}}"
                                           class="">
                                            <i class="btn btn-outline-info btn-circled btn-sm fa fa-link"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        {{$planeOrders->links()}}
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
