<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3>لیست ارزها</h3>
                <input type="text" wire:model.lazy="search" class="form-control-sm col-md-6 float-left rounded" placeholder="جستجو...">
            </div>
            <div class="card-content">
                <div class="card-body p-0 p-md-1 text-center">
                    <div class="table-responsive">
                        <table
                            class="table table-bordered table-hover-animation col-md-12 mx-auto">
                            <thead>
                            <tr>
                                <td>ارز</td>
                                <td>نام ارز</td>
                                <td>قیمت خرید از ما</td>
                                <td>قیمت فروش به ما</td>
                                {{--                                        <td>موجودی</td>--}}
                                <td>عملیات</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($currencies as $currency)
                                <tr>
                                    <td>
                                        <img src="{{asset($currency->icon_url)}}"
                                             class="img-fluid" width="40px">
                                    </td>
                                    <td>
                                        {{$currency->enname}}
                                        {{$currency->name}}
                                        ({{$currency->symbol}})
                                        @if ($currency->network)
                                            <span class="badge badge-info">{{$currency->network}}</span>
                                        @endif
                                    </td>
                                    <td>
                                                <span id=""
                                                      style="">{{number_format($currency->send_price,$currency->decimal)}}</span>
                                    </td>
                                    <td>
                                                <span id=""
                                                      style="">{{number_format($currency->receive_price,$currency->decimal)}}</span>
                                    </td>
                                    {{--                                            <td>--}}
                                    {{--                                                <span id=""--}}
                                    {{--                                                      style="">{{number_format($currency->count,$currency->decimal)}}</span>--}}
                                    {{--                                            </td>--}}
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{url("panel/order/create?currency=$currency->symbol")}}"
                                               class="btn btn-success">خرید</a>
                                            <a href="{{url("panel/order/create?currency=$currency->symbol")}}"
                                               class="btn btn-danger"> فروش</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$currencies->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
