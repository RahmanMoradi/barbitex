<div>
    <div class="card-body box-order  border-success ">
        <div class="card-title mb-0">
            جزئیات سفارش: {{$order->qty}} | {{$order->currency->symbol}}
        </div>
        <p class="text-small text-muted">اطلاعاتی که در صفحه میبینید متعلق به این سفارش میباشد.</p>
        <h5>
            <span class="text-primary">شماره سفارش:</span>
            <span class="info">{{$order->id}}#</span>
        </h5>
        <h4>
            <span class="text-primary"> وضعیت:</span>
            {!! $order->status_fa_html !!}
        </h4>

        <h5>
            <span class="text-primary">تاریخ ثبت:</span>
            {{$order->created_at_fa}}
        </h5>

        <h5>
            <span class="text-primary">مبلغ سفارش:</span>
            {{number_format($order->price)}}
        </h5>
        <hr class="w-25">
        <img src="{{$order->currency->iconUrl}}"
             style="position: absolute;width: 10%;left: 40px;top: 20px;">
        <br>
        <div class="table-responsive">
            <div class="table-responsive">
            </div>
            <table class="table table-bordered">
                <thead class="">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center w-60">شرح</th>
                    <th class="text-center">مقدار / تعداد</th>
                    <th class="text-center">وضعیت</th>
                </tr>
                </thead>
                <tbody class="text-center">
                <tr>
                    <td>
                        {{$order->id}}
                    </td>
                    <td>
                        <img src="{{$order->currency->iconUrl}}"
                             class="img img-circle img-table2" style="width: 10%;">
                    </td>
                    <td>
                        {{$order->qty}}
                    </td>
                    <td>{{$order->status_text}}</td>
                </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead class="bg-white">

                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center w-60">شرح</th>
                    <th class="text-center">مقدار / تعداد</th>
                    <th class="text-center">قیمت واحد</th>
                    <th class="text-center">مبلغ کل</th>
                </tr>
                </thead>
                <tbody class="text-center bg-white">
                <tr>
                    <td scope="row" class="sans-serif">1</td>
                    <td>هزینه ارز</td>
                    <td>{{$order->qty}}</td>
                    <td>{{number_format($order->price / $order->qty,$order->currency->decimal)}}</td>
                    <td>{{number_format($order->price - ($order->price * ($order->type == 'sell' ? $order->currency->sell_percent : $order->currency->buy_percent) / 100))}}</td>
                </tr>
                <tr>
                    <td scope="row" class="sans-serif">3</td>
                    <td>کارمزد سایت</td>
                    <td>
                        1
                    </td>
                    <td>
                        ~{{number_format($order->price * ($order->type == 'sell' ? $order->currency->sell_percent : $order->currency->buy_percent) / 100)}}
                    </td>
                    <td>
                        ~{{number_format($order->price * ($order->type == 'sell' ? $order->currency->sell_percent : $order->currency->buy_percent) / 100)}}
                    </td>
                </tr>
                <tr>
                    <td scope="row" class="sans-serif">4</td>
                    <td>قیمت تتر در هنگام ثبت سفارش</td>
                    <td>
                        --
                    </td>
                    <td>{{number_format($order->usdt_price)}}</td>
                    <td>
                        --
                    </td>
                </tr>
                <tr>
                    <td scope="row" class="sans-serif">4</td>
                    <td>مجموع پرداختی</td>
                    <td>
                        {{$order->qty}}
                    </td>
                    <td></td>
                    <td>
                        {{number_format($order->price)}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
