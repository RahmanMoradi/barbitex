<div class="card">
    <div class="card-header">
        <h3 class="card-title">سفارشات انجام شده</h3>
    </div>
    <div class="card-body nicescrol" style="height: 250px">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>نوع سفارش</th>
                <th>مقدار ({{ optional($market->currencyBuyer)->symbol }})</th>
                <th>قیمت واحد ({{optional($market->currencySeller)->symbol}})</th>
                <th>قیمت کل ({{optional($market->currencySeller)->symbol}})</th>
                <th>درصد انجام شده</th>
            </tr>
            </thead>
            <tbody>
            @foreach($myOrders as $order)
                <tr>
                    <td class="text-danger">
                        {!! $order->type_fa_html !!}
                    </td>
                    <td>{{ $order->count }}</td>
                    <td>{{ Helper::formatAmountWithNoE($order->price,2) }}</td>
                    <td>{{ $order->count * $order->price }}</td>
                    <td>{{$order->remaining == 0 ? '100' :100- ($order->count  / 100 *  $order->remaining) }}%</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
