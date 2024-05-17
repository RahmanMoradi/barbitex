<div>
    <section id="wallet">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">لیست دارایی</h4>
                        <input type="text" class="form-control form-control-sm round col-6" placeholder="جستجو..."
                               wire:model.lazy="search">
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <p class="card-text">
                                لیست دارایی های شما.
                            </p>
                            <div class="pull-left">
                                <div class="custom-control custom-switch switch-md custom-switch-success mr-2 mb-1">
                                    <input type="checkbox" class="custom-control-input" id="count"
                                           wire:change="$set('filter',{{ !$filter }})" {{$filter  ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="count">
                                        <span class="switch-text-left">موجود</span>
                                        <span class="switch-text-right">همه</span>
                                    </label>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped data-list-view">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ارز</th>
                                        <th>موجودی</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($balances as  $wallet)
                                        <tr>
                                            <td>
                                                <img src="{{asset($wallet['currency']->icon_url)}}"
                                                     alt="{{$wallet['currency']->symbol}}" height="40">
                                            </td>
                                            <td>
                                                <p>{{$wallet['currency']->name}}</p>
                                                @if ($wallet['currency']->type == 'coin')
                                                    <p>{{$wallet['currency']->price}} $</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($wallet['currency']->symbol == 'IRT')
                                                    موجودی
                                                    کل: {{number_format(optional($wallet['balance'])['balance'])}}
                                                    {{$wallet['currency']->symbol}}
                                                    <br>
                                                    قابل
                                                    برداشت: {{number_format(optional($wallet['balance'])['balance_free'])}}
                                                    {{$wallet['currency']->symbol}}</td>
                                            @else
                                                موجودی
                                                کل: {{Helper::numberFormatPrecision(optional($wallet['balance'])['balance'],$wallet['currency']->decimal)}}
                                                {{$wallet['currency']->symbol}}
                                                <br>
                                                قابل
                                                برداشت: {{Helper::numberFormatPrecision(optional($wallet['balance'])['balance_free'],$wallet['currency']->decimal)}}
                                                {{$wallet['currency']->symbol}}
                                                @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{route('panel.wallet.deposit',['currency' => $wallet['currency']->symbol])}}"
                                                           class="btn btn-outline-success">واریز</a>
                                                        <a href="{{route('panel.wallet.withdraw',['currency' => $wallet['currency']->symbol])}}"
                                                           class="btn btn-outline-danger">برداشت</a>
                                                        @if($wallet['currency']->symbol != 'IRT')
                                                            <a href="{{url('/panel/order/create')}}?currency={{$wallet['currency']->symbol}}"
                                                               class="btn btn-outline-info">خرید/فروش</a>
                                                        @endif
                                                        @if($wallet['currency']->symbol != 'IRT' && $wallet['currency']->symbol != 'USDT' && $wallet['currency']->defaultMarket)
                                                            <div class="btn-group btn-group-sm dropdown">
                                                                <button type="button"
                                                                        class="btn btn-outline-primary dropdown-toggle waves-effect waves-light"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    بازارها
                                                                </button>
                                                                <div class="dropdown-menu" x-placement="bottom-start">
                                                                    @foreach($wallet['currency']->markets as $market)
                                                                        <a class="dropdown-item"
                                                                           href="{{url("market/".$market->symbol)}}">{{$market->symbol}}</a>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if($wallet['currency']->symbol !== 'IRT' && Helper::modules()['global_transfer'])
                                                        <a href="{{route('panel.wallet.transfer',['symbol'=>$wallet['currency']->symbol])}}"
                                                           class="btn btn-sm btn-success mt-1 w-100">
                                                            انتقال داخلی (انتقال به کابران سایت)
                                                            <i class="fa fa-send"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>ارز</th>
                                        <th>موجودی</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
