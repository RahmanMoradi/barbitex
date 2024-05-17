<div class="card" style="height: 440px">
    <div class="card-header">
        <h3 class="card-title">آخرین معاملات</h3>
    </div>
    <div class="card-body nicescrol">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>تاریخ</th>
                <th>قیمت</th>
                <th style="float: left">مقدار</th>
            </tr>
            </thead>
            <tbody>
            @foreach(collect(array_reverse($lastOrders))->take(14) as $item)
                <tr v-for="item in $lastOrder">
                    <td class="p-0">{{ \Carbon\Carbon::createFromTimestamp($item['T'])->toTimeString() }}</td>
                    <td class="p-0 {{$item['m']  ? 'text-danger' : 'text-success'}}   ">{{ $item['p'] }}</td>
                    <td class="p-0" style="float: left">{{ $item['q'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
