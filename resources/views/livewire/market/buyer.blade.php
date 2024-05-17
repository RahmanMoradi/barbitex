<div class="card" style="height: 455px;">
    <div class="card-header">
        <h3 class="card-title">خریداران</h3>
    </div>
    <div class="card-body nicescrol">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th style="text-align: right">مقدار({{ optional($market->currencyBuyer)->symbol }})</th>
                <th style="text-align: left">واحد({{ optional($market->currencySeller)->symbol }})</th>
                {{--                <th>کل(تومان)</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach ($buyer as $key=>$item)
                <tr class="cursor-pointer"
                    style="background-color: none;background-image: linear-gradient(90deg,rgba(108,215,131,0.2) {{$item[1]}}%, #fff0 0%, rgb(255 255 255 / 0%) 0%)"
                    wire:click.prevent="$emitTo('market.order', 'setAmountFromBook',{{$key}},{{$item[0]}},'sell')">
                    <td class="p-0" style="text-align: right">{{ $item[0] }}</td>
                    <td class="p-0 text-success" style="text-align: left">{{ $key }}</td>
                    {{--                    <td class="p-0">{{ $item[0]->allSumPrice }}</td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
