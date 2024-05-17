<div>
    <div class="card">
        <div class="card-body d-flex justify-content-between">
            <div>بیشترین : {{ $high }}</div>
            <div>کمترین : {{ $low }}</div>
            <div>آخرین : {{ $close }}</div>
            <div>حجم : {{ number_format($volume,0) }}</div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <livewire:market.trading-view :market="$market->market" :symbol="$market->symbol"/>
        </div>
    </div>
</div>
