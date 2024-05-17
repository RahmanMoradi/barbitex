<div class="card" style="height: 455px">
    <div class="card-header">
        <h3 class="card-title">بازارها</h3>
        <i class="fa fa-search cursor-pointer" data-toggle="modal" data-target="#markets"></i>
    </div>
    <div class="card-body nicescrol" style="overflow-y: scroll"
         wire:target="gotoMarket" wire:loading.class="blur">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>نماد</th>
                <th>قیمت</th>
                <th>تغییر</th>
            </tr>
            </thead>
            <tbody>
            @foreach($marketsList as $item)
                <tr onclick="window.location.href = '/market/{{$item['symbol']}}'"
                    class="cursor-pointer">
                    <td class="p-0">
                        @if($item['symbol'] == $marketActive->symbol)
                            <i class="fa fa-dot-circle-o"></i>
                        @endif
                        {{ $item['symbol'] }}
                    </td>
                    <td class="p-0 {{$item['change_24'] > 0 ? 'text-success' :'text-danger'}}">{{ $item['price'] }}</td>
                    <td class="p-0 {{$item['change_24'] > 0 ? 'text-success' :'text-danger'}}">{{ $item['change_24'] }}
                        %
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" wire:ignore id="markets" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">لیست بازارها</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table dataTable zero-configuration">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($markets as $market)
                            <tr>
                                <td>{{$market->symbol}}</td>
                                <td>
                                    <a href="/market/{{$market->symbol}}" class="btn btn-info btn-sm">انتخاب کنید</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
