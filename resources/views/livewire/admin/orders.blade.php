<div>
    <section id="markets">
        <div class="card  shadow-none">
            <div class="card-header">
                <div class="col-md-12 d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">آخرین سفارشات (بازار حرفه ای)</h4>
                        <input type="text" class="form-control round form-control-sm"
                               wire:model.lazy="searchProfessional">
                    </div>
                    <button wire:click="checkAllOpenOrder" class="btn btn-success" data-toggle="tooltip"
                            data-placement="top"
                            wire:loading.attr="disabled"
                            title="وضعیت تمام سفارشات باز در مارکت ها بررسی میگردد و در صورت بسته شدن آن سفارش عملیات اعمال می گردد. هشدار این عملیات ممکن است زمان بر باشد">
                        <i class="fa fa-check-circle-o"></i>
                        چک کردن تمام سفارشات باز
                    </button>
                </div>
                <hr>
                <div class="row col-md-12 mt-3">
                    <div class="form-group col-md-3">
                        <label for="filterUser">کاربر</label>
                        <select wire:model.lazy="filterUser" data-livewire-model="filterUser"
                                class="form-control form-control-sm round select2">
                            <option value="">انتخاب کنید</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->email}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="filterMarket">بازار</label>
                        <select wire:model.lazy="filterMarket" data-livewire-model="filterMarket" class="form-control form-control-sm round select2">
                            <option value="">انتخاب کنید</option>
                            @foreach($markets as $market)
                                <option value="{{$market->id}}">{{$market->symbol}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="filterType">نوع</label>
                        <select wire:model.lazy="filterType" class="form-control form-control-sm round">
                            <option value="">انتخاب کنید</option>
                            <option value="buy">خرید</option>
                            <option value="sell">فروش</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="filterStatus">وضعیت</label>
                        <select wire:model.lazy="filterStatus" class="form-control form-control-sm round">
                            <option value="">انتخاب کنید</option>
                            <option value="init">باز</option>
                            <option value="done">انجام شده</option>
                            <option value="cancel">لغو شده</option>
                        </select>
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
                            <th>کاربر</th>
                            <th>مقدار</th>
                            <th>قیمت واحد</th>
                            <th>قیمت کل</th>
                            <th>پر شده(%)</th>
                            <th>نوع</th>
                            <th>وضعیت</th>
                            <th>تاریخ</th>
                            @if(env('APP_DEBUG'))
                                <th></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ordersProfessional as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{optional($order->market)->symbol}}</td>
                                <td>
                                    <a href="{{route('admin.user.show',['user' => $order->user??0])}}">
                                        {{optional($order->user)->name}}
                                    </a>
                                </td>
                                <td>
                                    {{$order->count}} {{$order->type == 'buy' ?
                                    optional(optional($order->market)->currencyBuyer)->symbol :
                                    optional(optional($order->market)->currencySeller)->symbol}}
                                </td>
                                <td>
                                    {{Helper::numberFormatPrecision($order->price)}}
                                    {{optional(optional($order->market)->currencySeller)->symbol}}
                                </td>
                                <td>
                                    {{Helper::numberFormatPrecision($order->sumPrice)}}
                                    {{optional(optional($order->market)->currencySeller)->symbol}}
                                </td>
                                <td>{{$order->remaining == 0 ? 100 : Helper::numberFormatPrecision(100 - (($order->remaining * 100) / $order->count),0)}}</td>
                                <td>
                                    {!! $order->type_fa_html !!}
                                </td>
                                <td>
                                    {!! $order->status_fa_html !!}
                                </td>
                                <td>
                                    {{$order->created_at_fa}}
                                </td>
                                <td>
                                    @if($order->status == 'init')
                                        <button class="btn btn-sm btn-success" wire:click="markAsDone({{$order}})">
                                            علامت گذاری به عنوان انجام شده
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                    {{$ordersProfessional->links()}}
                </div>
            </div>
        </div>

        @if (\App\Helpers\Helper::modules()['orderPlane'])
            <div class="card  shadow-none">
                <div class="card-header">
                    <div class="col-md-12">
                        <h4 class="card-title">آخرین سفارشات (بازار ساده)</h4>
                        <input type="text" class="form-control round col-md-4 form-control-sm" wire:model.lazy="searchPlain">
                    </div>
                    <div class="row col-md-12 mt-3">
                        <div class="form-group col-md-3">
                            <label for="filterPlainUser">کاربر</label>
                            <select wire:model.lazy="filterPlainUser" data-livewire-model="filterPlainUser"
                                    class="form-control form-control-sm round select2">
                                <option value="">انتخاب کنید</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->email}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filterPlainCurrency">ارز</label>
                            <select wire:model.lazy="filterPlainCurrency" data-livewire-model="filterPlainCurrency" class="form-control form-control-sm round select2">
                                <option value="">انتخاب کنید</option>
                                @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}">{{$currency->symbol}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filterPlainType">نوع</label>
                            <select wire:model.lazy="filterPlainType" class="form-control form-control-sm round">
                                <option value="">انتخاب کنید</option>
                                <option value="buy">خرید</option>
                                <option value="sell">فروش</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filterPlainStatus">وضعیت</label>
                            <select wire:model.lazy="filterPlainStatus" class="form-control form-control-sm round">
                                <option value="">انتخاب کنید</option>
                                <option value="new">جدید</option>
                                <option value="done">انجام شده</option>
                                <option value="process">در حال انجام</option>
                            </select>
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
                                <th>کاربر</th>
                                <th>تعداد</th>
                                <th>قیمت</th>
                                <th>قیمت تتر</th>
                                <th>نوع</th>
                                <th>وضعیت</th>
                                <th>تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ordersPlain as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{optional($order->currency)->symbol}}</td>
                                    <td>
                                        <a href="{{route('admin.user.show',['user' => $order->user??0])}}">
                                            {{optional($order->user)->name}}
                                        </a>
                                    </td>
                                    <td>
                                        {{$order->qty}}
                                    </td>
                                    <td>
                                        {{number_format($order->price)}}
                                    </td>
                                    <td>
                                        {{number_format($order->usdt_price)}}
                                    </td>
                                    <td>
                                        {!! $order->type_fa_html !!}
                                    </td>
                                    <td>
                                        {{$order->created_at_fa}}
                                    </td>
                                    <td>
                                        {!! $order->status_fa_html !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        {{$ordersPlain->links()}}
                    </div>
                </div>
            </div>
        @endif
    </section>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            function init() {
                $('.select2').select2();
            }
            setTimeout(function (){
                init()
            },300)
            $('.select2').on('change', function (e) {
                var model = e.target.getAttribute('data-livewire-model');
                var data = e.target.value
                @this.set(model, data);
                setTimeout(function (){
                    init()
                },1000)
            });
        });
    </script>
@endpush
