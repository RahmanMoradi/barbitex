<div>
    <section id="portfolios">
        <div class="card  shadow-none">
            <div class="card-header">
                <h4 class="card-title">پورتفووی لحظه ای</h4>
                <i class="fa fa-refresh cursor-pointer" wire:loading.class="fa-spin" wire:target="$refresh"
                   wire:click="$refresh"></i>
            </div>
            <div class="card-content">
                <div class="card-body table-responsive">
                    <div class="alert alert-danger">
                        <p>
                            توجه: این افزونه صرفا جهت تسهیل محاسبات کاربر ایجاد شده و مبنای تصمیم گیری برای کاربر نیست.
                            مسئولیت کنترل صحت محاسبات به عهده کاربر می باشد و {{Setting::get('title')}} مسئولیتی در این
                            خصوص ندارند.
                        </p>
                        <p>توجه: سود زیان محاسبه شده توسط سیستم بدون احتساب کارمزد سایت می باشد.</p>
                    </div>
                    <table class="table data-list-view">
                        <thead>
                        <tr>
                            <th class="text-center">ارز/تعداد</th>
                            <th class="text-center">جمع/نوسان تومانی</th>
                            <th class="text-center">جمع/نوسان دلاری</th>
                            <th class="text-center">نرخ میانگین خرید/اکنون(دلاری)</th>
                            <th class="text-center">نرخ میانگین خرید/اکنون(تومانی)</th>
                            <th class="text-center">کل مبلغ/اکنون(تومانی)</th>
                            <th class="text-center">کل مبلغ/اکنون(دلاری)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($portfolios as $portfolio)
                            <tr>
                                <td class="text-center">
                                    <img src="{{$portfolio['icon']}}" class="float-left" alt="" height="30">
                                    {{$portfolio['symbol']}}
                                    <br>
                                    {{$portfolio['remaining']}}
                                </td>
                                <td class="text-center">
                                    {{$portfolio['sum_irt']}}
                                    <br>
                                    <span class="badge badge-{{$portfolio['positive']> 0 ? 'success':'danger'}}">
                                        {{$portfolio['irt_oscillation']}}
                                        {{$portfolio['percent']}}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{$portfolio['sum_usdt']}}
                                    <br>
                                    <span class="badge badge-{{$portfolio['positive']> 0 ? 'success':'danger'}}">
                                        {{$portfolio['usdt_oscillation']}}
                                        {{$portfolio['percent']}}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{$portfolio['unit_usdt']}}
                                    <br>
                                    {{$portfolio['unit_usdt_now']}}
                                </td>
                                <td class="text-center">
                                    {{$portfolio['unit_irt']}}
                                    <br>
                                    {{$portfolio['unit_irt_now']}}
                                </td>
                                <td class="text-center">
                                    {{$portfolio['sum_irt']}}
                                    <br>
                                    {{$portfolio['sum_irt_now']}}
                                </td>
                                <td class="text-center">
                                    {{$portfolio['sum_usdt']}}
                                    <br>
                                    {{$portfolio['sum_usdt_now']}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                </div>
            </div>
        </div>
    </section>
</div>
