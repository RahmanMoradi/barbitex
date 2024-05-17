<div>
    <section id="commission">
        <div class="row">
            <div class="col-md-12 col-sm-12 card">
                <div class="card-header">
                    <h3 class="card-title">بازار حرفه ای</h3>
                </div>
                <hr>
                <div class="card-content">
                    <div class="col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-header">
                                        <h4 class="card-title">درآمد امروز</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>{{$transactionsDaySumInMarket}} $</p>
                                        <p>{{number_format($transactionsDaySumInMarket * Setting::get('dollar_pay'))}}
                                            تومان</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-header">
                                        <h4 class="card-title">درآمد این ماه</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>{{$transactionsMonthSumInMarket}} $</p>
                                        <p>{{number_format($transactionsMonthSumInMarket * Setting::get('dollar_pay'))}}
                                            تومان</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-header">
                                        <h4 class="card-title">درآمد این سال</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>{{$transactionsYearSumInMarket}} $</p>
                                        <p>{{number_format($transactionsYearSumInMarket * Setting::get('dollar_pay'))}}
                                            تومان</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 card">
                <div class="card-header">
                    <h3 class="card-title">بازار ساده</h3>
                </div>
                <hr>
                <div class="card-content">
                    <div class="col-md-12 col-sm-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-header">
                                        <h4 class="card-title">درآمد امروز</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>{{number_format($transactionsDaySumInPlane)}} تومان</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-header">
                                        <h4 class="card-title">درآمد این ماه</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>{{number_format($transactionsMonthSumInPlane)}} تومان</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-header">
                                        <h4 class="card-title">درآمد این سال</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>{{number_format($transactionsYearSumInPlane)}} تومان</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-md-12">
            <div class="card-header">
                <h4 class="card-title">موجودی مدیر</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ارز</th>
                            <th>موجودی</th>
                            <th>ارزش به تتر</th>
                            <th>ارزش به تومان</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($balances as $balance)
                            <tr>
                                <td>
                                    <img src="{{optional($balance->currencyModel)->iconUrl}}" height="30"/>
                                    {{$balance->currency}}
                                </td>
                                <td>{{\App\Helpers\Helper::formatAmountWithNoE($balance->balance_free,2)}}</td>
                                <td>
                                    @if ($balance->currency == 'IRT')
                                        {{$balance->balance_free / Setting::get('dollar_pay')}}
                                    @else
                                        {{$balance->balance_free * optional($balance->currencyModel)->price}}
                                    @endif
                                </td>
                                <td>
                                    @if ($balance->currency == 'IRT')
                                        {{number_format($balance->balance_free)}}
                                    @else
                                        {{number_format(($balance->balance_free * optional($balance->currencyModel)->price) * Setting::get('dollar_pay'))}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$balances->links()}}
                </div>
            </div>
        </div>
        <div class="card col-md-12">
            <div class="card-header">
                <h4 class="card-title">تراکنش ها</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ارز</th>
                            <th>مقدار</th>
                            <th>معادل (USDT)</th>
                            <th>معادل (تومان)</th>
                            <th>توضیحات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>
                                    <img src="{{optional($transaction->currencyRelation)->iconUrl}}" height="30"/>
                                    {{$transaction->currency}}
                                </td>
                                <td>{{\App\Helpers\Helper::formatAmountWithNoE($transaction->price,2)}}</td>
                                <td>
                                    <div class="col-md-10">
                                    <span class="float-left">
                                         @if ($transaction->currency == 'IRT')
                                            {{$transaction->price / Setting::get('dollar_pay')}}
                                        @else
                                            {{$transaction->price * optional($transaction->currencyRelation)->price}}
                                        @endif
                                   </span>
                                   <span class="float-right">
                                       USDT
                                   </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-10">
                                   <span class="float-left">
                                        @if ($transaction->currency == 'IRT')
                                           {{number_format($transaction->price)}}
                                       @else
                                           {{number_format(($transaction->price * optional($transaction->currencyRelation)->price) * Setting::get('dollar_pay'))}}
                                       @endif
                                </span>
                                        <span class="float-right">
                                    تومان
                                </span>
                                    </div>
                                </td>
                                <td>{{$transaction->description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$transactions->links()}}
                </div>
            </div>
        </div>
    </section>
</div>
