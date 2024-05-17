<section id="dashboard-analytics">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-content">
                    <div class="card-body p-0 p-md-1">
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>کاربر</th>
                                    <th>ارز</th>
                                    <th>نوع</th>
                                    <th>مبلغ</th>
                                    <th>تاریخ و ساعت ثبت</th>
                                    <th>وضعیت</th>
                                    <th>اپراتور</th>
                                    <th>توضیحات</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wallets as $wallet)
                                    <tr>
                                        <td>{{$wallet->id}}</td>
                                        <td>{{optional($wallet->user)->name}}</td>
                                        <td>
                                            {{$wallet->currency}}
                                        </td>
                                        <td>{!! $wallet->type_fa !!}</td>
                                        <td>
                                            مبلغ
                                            : {{App\Helpers\Helper::numberFormatPrecision($wallet->price,optional($wallet->currencyRelation)->decimal)}}
                                        </td>
                                        <td>{{$wallet->created_at_fa}}</td>
                                        <td>{!! $wallet->status_fa !!}</td>
                                        <td>{{optional($wallet->admin)->name}}</td>
                                        <td>
                                            @if($wallet->card_id)
                                                <span>بانک: <b>{{optional($wallet->card)->bank_name_text}}</b></span>
                                                <hr>
                                                <span>شماره کارت: <b>{{optional($wallet->card)->card_number}}</b></span>
                                                <hr>
                                                <span>شماره حساب: <b>{{optional($wallet->card)->account_number}}</b></span>
                                                <hr>
                                                <span>شماره شبا: <b>{{optional($wallet->card)->sheba}}</b></span>
                                            @endif
                                            {{$wallet->wallet}}
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm btn-block">
                                                <button class="btn btn-sm btn-success"
                                                        wire:click.prevent="operator({{$wallet->id}})"
                                                        wire:loading.attr="disabled">دریافت سفارش
                                                </button>
                                                @if ($wallet->type == 'decrement')
                                                    <button class="btn btn-sm btn-danger"
                                                            wire:click.prevent="cancel({{$wallet->id}})"
                                                            wire:loading.attr="disabled">رد درخواست
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-info"
                                                        wire:click.prevent="sendToUser({{$wallet->id}})"
                                                        wire:loading.attr="disabled"
                                                        wire:loading.class="btn-dark">
                                                    <div wire:loading>
                                                        در حال واریز...
                                                    </div>
                                                    <div wire:loading.remove>
                                                        تائید ارسال ارز
                                                    </div>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        {{$wallets->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
