<div class="card">
    <div class="card-header">
        <h3 class="card-title">سفارشات فعال شما</h3>
    </div>
    <div class="card-body nicescrol" style="height: 250px">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>مقدار</th>
                <th>نوع</th>
                <th>قیمت</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($activeOrders as $item)
                <tr>
                    <td class="p-0">{{ $item->count }}</td>
                    <td class="p-0">
                        {!! $item->type_fa_html !!}
                    </td>
                    <td class="p-0">{{ Helper::formatAmountWithNoE($item->price,2) }}</td>
                    <td class="p-0">
                        <i class="fa fa-trash-o text-danger cursor-pointer" wire:click.prevent="delete({{$item}})"></i>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
