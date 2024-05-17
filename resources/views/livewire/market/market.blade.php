@section('title')
    {{$market->symbol }}
@endsection
<div class="row d-none d-md-flex">
    <div class="col-md-3 col-sm-12">
        <livewire:market.buyer :market="$market" :key="'market-buyer'.Auth::id()"/>
        <livewire:market.seller :market="$market" :key="'market-seller'.Auth::id()"/>
    </div>
    <div class="col-md-6 col-sm-12">
        <livewire:market.chart :market="$market" :key="'market-chart'.Auth::id()"/>
        <livewire:market.order :market="$market" :key="'market-order'.Auth::id()"/>
    </div>
    <div class="col-md-3 col-sm-12">
        <livewire:market.markets :key="'market-markets'.Auth::id()" :market="$market"/>
        <livewire:market.last-order :market="$market" :key="'market-last-order'.Auth::id()"/>
    </div>
    <div class="col-md-6 col-sm-12">
        <livewire:market.active-order :market="$market" :key="'active-order'.Auth::id()"/>
    </div>
    <div class="col-md-6 col-sm-12">
        <livewire:market.my-orders :market="$market" :key="'my-order'.Auth::id()"/>
    </div>
</div>

<div class="d-md-none">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="marketTabs" role="tablist">
        <li class="flex-sm-fill nav-item" role="presentation">
            <button class="nav-link active" id="chartLink" data-bs-toggle="tab" data-toggle="tab"
                    data-bs-target="#chart" data-target="#chart" type="button" role="tab" aria-controls="chart"
                    aria-selected="true">خرید و فروش
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="orderBookLink" data-bs-toggle="tab" data-toggle="tab"
                    data-bs-target="#orderBook" data-target="#orderBook" type="button" role="tab"
                    aria-controls="orderBook" aria-selected="false">
                سفارشات
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="lastOrdersLink" data-bs-toggle="tab" data-toggle="tab"
                    data-bs-target="#lastOrders" data-target="#lastOrders" type="button" role="tab"
                    aria-controls="lastOrders"
                    aria-selected="false">آخرین معاملات
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="marketsLink" data-bs-toggle="tab" data-toggle="tab"
                    data-bs-target="#marketsList" data-target="#marketsList" type="button" role="tab"
                    aria-controls="markets"
                    aria-selected="false"> بازارها
            </button>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="chart" role="tabpanel" aria-labelledby="chartLink">
            <livewire:market.chart :market="$market" :key="'market-chart'.Auth::id()"/>
            <livewire:market.order :market="$market" :key="'market-order'.Auth::id()"/>
        </div>
        <div class="tab-pane" id="orderBook" role="tabpanel" aria-labelledby="orderBookLink">
            <livewire:market.buyer :market="$market" :key="'market-buyer'.Auth::id()"/>
            <livewire:market.seller :market="$market" :key="'market-seller'.Auth::id()"/>
        </div>
        <div class="tab-pane" id="lastOrders" role="tabpanel" aria-labelledby="lastOrdersLink">
            <livewire:market.last-order :market="$market" :key="'market-last-order'.Auth::id()"/>
        </div>
        <div class="tab-pane" id="marketsList" role="tabpanel" aria-labelledby="marketsLink">
            <livewire:market.markets :key="'market-markets'.Auth::id()" :market="$market"/>
        </div>
    </div>

    <ul class="nav nav-tabs" id="ordersTab" role="tablist">
        <li class="flex-sm-fill nav-item" role="presentation">
            <button class="nav-link active" id="myOrderOpenLink" data-bs-toggle="tab" data-toggle="tab"
                    data-bs-target="#myOrderOpen" data-target="#myOrderOpen" type="button" role="tab"
                    aria-controls="chart"
                    aria-selected="true">معاملات باز
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="myOrdersLink" data-bs-toggle="tab" data-toggle="tab"
                    data-bs-target="#myOrders" data-target="#myOrders" type="button" role="tab"
                    aria-controls="myOrders" aria-selected="false">
                آخرین معاملات
            </button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="myOrderOpen" role="tabpanel" aria-labelledby="chartLink">
            <livewire:market.active-order :market="$market" :key="'active-order'.Auth::id()"/>
        </div>
        <div class="tab-pane" id="myOrders" role="tabpanel" aria-labelledby="orderBookLink">
            <livewire:market.my-orders :market="$market" :key="'my-order'.Auth::id()"/>
        </div>
    </div>
</div>

