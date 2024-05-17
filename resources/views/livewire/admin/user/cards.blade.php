<section id="dashboard-analytics">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">کارت های بانکی</h4>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-info" wire:click="$set('filter','0')">درانتظار تایید</button>
                        <button class="btn btn-success" wire:click="$set('filter','1')">تایید شده</button>
                        <button class="btn btn-danger" wire:click="$set('filter','2')">رد شده</button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body p-0 p-md-1">
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                <thead>
                                <tr>
                                    <th>کابر</th>
                                    <th>بانک</th>
                                    <th>شماره کارت</th>
                                    <th>شماره حساب</th>
                                    <th>شماره شبا</th>
                                    <th>وضعیت</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cards as $card)
                                    <tr>
                                        <td>
                                            <a href="{{route('admin.user.show',['user' => $card->user])}}">
                                                {{optional($card->user)->name}}
                                            </a>
                                        </td>
                                        <td>{{$card->bank_name}}</td>
                                        <td>{{$card->card_number}}</td>
                                        <td>{{$card->account_number}}</td>
                                        <td>{{$card->sheba}}</td>
                                        <td>{!! $card->status_html!!}</td>
                                        <td>
                                            <div class="flex flex-column justify-content-between">
                                                @if (config('webazin.inquiry.default') === 'jibit')
                                                    <button class="btn btn-sm btn-success w-100"
                                                            wire:target="matchingCardWithNational"
                                                            wire:loading.attr="disabled"
                                                            wire:click="matchingCardWithNational({{$card}})">
                                                        تطابق اطلاعات کارت با کد ملی
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-info w-100 mt-1" wire:target="inquiryCard"
                                                        wire:loading.attr="disabled"
                                                        wire:click="inquiryCard(`{{$card->card_number}}`)">
                                                    استعلام و دریافت اطلاعات کارت
                                                </button>
                                            </div>
                                            <div class="btn-group btn-group-sm mt-2">
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="changeStatus('1' ,`{{$card->id}}`)"
                                                   class="btn btn-outline-success">تایید</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="changeStatus('2' ,`{{$card->id}}`)"
                                                   class="btn btn-outline-danger">رد</a>
                                                <a href="javascript:void(0)"
                                                   wire:click.prevent="delete({{$card->id}})"
                                                   class="btn btn-outline-danger">حذف</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        {{$cards->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
