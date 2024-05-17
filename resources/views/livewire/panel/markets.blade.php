<section id="markets">
    <div class="card  shadow-none">
        <div class="card-header">
            <h4 class="card-title">بازارها</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <ul class="list-group scrollable-container nicescroll" style="height: 270px;overflow-y: scroll">
                    <li class="list-group-item d-flex justify-content-between align-items-center text-bold-600">
                        <span>نوع ارز</span>
                        <span>قیمت ($)</span>
                        <span>تغییرات</span>
                    </li>
                    @foreach($marketsList as $market)
                        <li wire:click="gotoMarket(`{{$market['symbol']}}`)"
                            class="list-group-item d-flex justify-content-between align-items-center cursor-pointer">
                            <span class="text-center">
{{--                                <img src="{{asset(optional($market['currencyBuyer'])['icon'])}}" height="20"/>--}}
                                {{$market['symbol']}}
                            </span>
                            <span class="text-center">{{$market['price']}}</span>
                            <span
                                class="badge {{$market['change_24'] > 0 ? 'badge-success' :'badge-danger'}}  badge-pill text-center">{{$market['change_24']}} %</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
