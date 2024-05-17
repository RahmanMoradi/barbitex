<div class="card">
    <div class="card-body row">
        <div class="col-md-12">
            <span class="btn btn-sm btn-{{$orderType == 'limit' ? 'primary':'dark'}}"
                  wire:click="$set('orderType','limit')">قیمت ثابت</span>
            @if(\App\Helpers\Helper::modules()['marketOrder'])
                <span class="btn btn-sm btn-{{$orderType == 'market' ? 'primary':'dark'}}"
                      wire:click="$set('orderType','market')">قیمت بازار</span>
            @endif
            <hr>
        </div>
        <div class="col-md-6 col-sm-12">
            <h6>خرید ({{ optional($market->currencyBuyer)->symbol }})</h6>
            <div class="form-group">
                <label for="count">
                    @switch($orderType)
                        @case('limit')
                        مقدار ({{ optional($market->currencyBuyer)->symbol }})
                        @break
                        @case('market')
                        بودجه ({{ optional($market->currencySeller)->symbol }})
                        @break
                    @endswitch
                </label>
                <span
                    class="float-right">موجودی شما {{ $balances['sell'] ? App\Helpers\Helper::numberFormatPrecision($balances['sell']['balance_free']) : 0 }} {{ optional($market->currencySeller)->symbol }}</span>
                <input type="text" class="form-control" id="count"
                       wire:model.lazy="countBuy" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="amount">قیمت واحد ({{ optional($market->currencySeller)->symbol }})</label>
                <input type="text" class="form-control" id="amount"
                       wire:model.lazy="amountBuy" autocomplete="off" {{$orderType == 'market' ? 'readonly':''}}>
            </div>
            <div class="form-group {{$orderType == 'market' ? 'd-none' : ''}}">
                <label for="sumBuy">قیمت کل ({{ optional($market->currencySeller)->symbol }})</label>
                <input type="text" class="form-control" readonly id="sumBuy" wire:model.lazy="sumBuy" autocomplete="off">
            </div>
            <div class="form-group">
                <div class="btn-group d-flex justify-contant-center">
                    <a href="javascript:void(0)" wire:click="setAmount('buy',100)"
                       class="btn btn-outline-success btn-sm">100%</a>
                    <a href="javascript:void(0)" wire:click="setAmount('buy',75)"
                       class="btn btn-outline-success btn-sm">75%</a>
                    <a href="javascript:void(0)" wire:click="setAmount('buy',50)"
                       class="btn btn-outline-success btn-sm">50%</a>
                    <a href="javascript:void(0)" wire:click="setAmount('buy',25)"
                       class="btn btn-outline-success btn-sm">25%</a>
                </div>
            </div>
            @auth
                <button type="submit" wire:loading.attr="disabled" class="btn btn-success btn-block"
                        wire:click="addOrder('buy')">ثبت سفارش
                </button>
            @else
                <a href="/panel" class="btn btn-success btn-block">ورود ثبت نام</a>
            @endauth
        </div>
        <div class="d-md-none">
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <h6>فروش ({{optional($market->currencyBuyer)->symbol }})</h6>
            <div class="form-group">
                <label for="countSell">
                    مقدار ({{ optional($market->currencyBuyer)->symbol }})
                </label>
                <span class="float-right">
                        موجودی شما
                        {{ $balances['buy'] ? App\Helpers\Helper::numberFormatPrecision($balances['buy']['balance_free'],$market->currencyBuyer->decimal) : 0 }}
                    {{optional($market->currencyBuyer)->symbol}}
                    </span>
                <input id="countSell" type="text" class="form-control"
                       wire:model.lazy="countSell" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="amountSell">قیمت واحد ({{ optional($market->currencySeller)->symbol }})</label>
                <input id="amountSell" type="text" class="form-control"
                       wire:model.lazy="amountSell" autocomplete="off" {{$orderType == 'market' ? 'readonly':''}}>
            </div>

            <div class="form-group {{$orderType == 'market' ? 'd-none' : ''}}">
                <label for="sumSell">قیمت کل ({{ optional($market->currencySeller)->symbol }})</label>
                <input type="text" class="form-control" readonly id="sumSell" wire:model.lazy="sumSell"
                       autocomplete="off">
            </div>
            <div class="form-group">
                <div class="btn-group d-flex justify-contant-center">
                    <a href="javascript:void(0)" wire:click="setAmount('sell',100)"
                       class="btn btn-outline-danger btn-sm">100%</a>
                    <a href="javascript:void(0)" wire:click="setAmount('sell',75)"
                       class="btn btn-outline-danger btn-sm">75%</a>
                    <a href="javascript:void(0)" wire:click="setAmount('sell',50)"
                       class="btn btn-outline-danger btn-sm">50%</a>
                    <a href="javascript:void(0)" wire:click="setAmount('sell',25)"
                       class="btn btn-outline-danger btn-sm">25%</a>
                </div>
            </div>
            @auth
                <button type="submit" wire:loading.attr="disabled" class="btn btn-danger btn-block"
                        wire:click="addOrder('sell')">ثبت سفارش
                </button>
            @else
                <a href="/panel" class="btn btn-danger btn-block">ورود ثبت نام</a>
            @endauth
        </div>
    </div>
</div>
