<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card o-hidden">
                <div class="card-body">
                    <div class="card-title m-0 mb-1">
                        <i class="feather icon-trending-up"></i>
                        افزایش موجودی
                    </div>
                    <div class="border border-primary text-center p-2 font-medium-1">
                        کلیه مبالغ باید از کارت های تایید شده به نام شما و ثبت شده در سامانه واریز گردد.
                    </div>
                    <form id="wallet_increase" class="mt-2 needs-validation" novalidate=""
                          wire:submit.prevent="submit" autocomplete="off"
                          method="post">
                        @csrf
                        <div class="col-md-12 p-0 form-group mb-1">
                            <label>مبلغ</label>
                            <input type="text" id="amount" wire:model.defer="amount"
                                   class="form-control round text-center ltr-dir"
                                   required="" placeholder="مبلغ به تومان">
                            <div class="invalid-feedback">مبلغ را درج کنید</div>
                        </div>

                        <div class="col-md-12 p-0 form-group mb-1">
                            <label>شماره کارت مبدا</label>
                            <select class="form-control" name="origin_cart" id="origin_cart" wire:model.defer="origin_cart">
                                <option value="">شماره کارت مبدا را انتخاب کنید...</option>
                                @foreach($cards as $card)
                                    <option value="{{$card->card_number}}">{{$card->card_number}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">شماره کارت مبدا را انتخاب کنید</div>
                        </div>
                        <div class="col-md-12 p-0 form-group mb-1">
                            <label>شماره کارت مقصد</label>
                            <select class="form-control" name="goal_cart" id="goal_cart" wire:model.defer="goal_cart">
                                <option value="">شماره کارت مقصد را انتخاب کنید...</option>
                                @foreach($admin_cards as $admin_card)
                                    <option value="{{$admin_card['1']}}">{{$admin_card[0] .' - '. $admin_card[1] .' - '. $admin_card[2]}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">شماره کارت مقصد را انتخاب کنید</div>
                        </div>
                        <div class="col-md-5  m-auto">
                            <button class="btn btn-primary round btn-block text-14 waves-effect waves-light"
                                    wire:loading.attr="disabled">
                                ثبت تراکنش
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card o-hidden">
                <div class="card-body">
                    <div class="card-title mb-1 pb-1 border-bottom"><i class="feather icon-info"></i> نکات و هشدارها
                    </div>
                    <div class="text-14 pb-3 ">
                        <p>
                            پس از واریز مبلغ فرم روبرو را تکمیل و ثبت نمائید.
                        </p>
                        <p>
                            کلیه مبالغ باید از کارت ثبت شده در سامانه و به نام خودتان واریز گردد.
                            در غیر اینصورت مبالغ واریزی تائید نخواهد شد.
                        </p>
                        <p>
                            کلیه مبالغ به تومان می باشد.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
