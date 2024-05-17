@if ($type == 'fiat')
    <div class="row">
        <div class="col-md-6">
            <div class="card o-hidden">
                <div class="card-body">
                    <div class="card-title m-0 mb-1">
                        <i class="feather icon-trending-up"></i>
                        افزایش موجودی
                    </div>
                    <div class="border border-primary text-center p-2 font-medium-1">
                        موجودی: {{number_format($balance)}}<small>
                            تومان </small>
                    </div>
                    <form id="wallet_increase" class="mt-2 needs-validation" novalidate=""
                          wire:submit.prevent="submit" autocomplete="off"
                          method="post">
                        @csrf
                        <div class="col-md-12 p-0 form-group mb-1">
                            <label>مبلغ</label>
                            <input type="text" id="amount" wire:model.lazy="amount"
                                   class="form-control round text-center ltr-dir"
                                   required="" placeholder="مبلغ به تومان">
                            <div class="invalid-feedback">مبلغ را درج کنید</div>
                        </div>

                        <div class="col-md-12 p-0 form-group mb-1">
                            <label for="phone">توضیحات اضافه</label>
                            <textarea rows="3" class="form-control round text-center" wire:model.lazy="description"
                                      name="description" maxlength="300"></textarea>
                        </div>
                        <div class="col-md-5  m-auto">
                            <button class="btn btn-primary round btn-block text-14 waves-effect waves-light"
                                    wire:loading.attr="disabled">
                                انتقال به درگاه
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
                        <p>موجودی کیف پول به شما این امکان را می دهد تا در مواردی که درگاه بانکی مشکل دارد سریعتر
                            خرید
                            کنید و هر بار نیاز به وارد کردن اطلاعات حساب بانکی نباشد.</p>
                        <p>جهت استفاده از موجودی کیف پول در هنگام پرداخت فاکتور، می بایست گزینه پرداخت با «کیف پول»
                            را
                            انتخاب نمایید.</p>
                        <p>تنها زمانی می توانید از اعتبار کیف پول برای پرداخت فاکتور استفاده کنید که کیف پول شما
                            موجودی
                            کافی داشته باشد.</p>
                        <p>چنان چه کیف پول خود را توسط چندین کارت بانکی شارژ می کنید، به منظور جلوگیری از تأخیر در
                            انجام
                            سفارش، اطلاعات کارت بانکی خود را در بخش&nbsp;<a
                                href="{{url('panel/authentication/card')}}" target="_blank">کارت های بانکی من</a>
                            ثبت نمایید.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-6">
            <div class="card o-hidden">
                <div class="card-body">
                    <div class="card-title m-0 mb-1">
                        <i class="feather icon-trending-up"></i>
                        افزایش موجودی
                    </div>
                    <div class="border border-primary text-center p-2 font-medium-1">
                        موجودی: {{Helper::numberFormatPrecision($balance,$currency->decimal)}}
                        <small>
                            {{$currency->symbol}}
                        </small>
                        {{--                        <i class="fa fa-refresh cursor-pointer" wire:click="refreshBalance"></i>--}}
                    </div>
                    <form id="wallet_increase" class="mt-2 needs-validation" novalidate=""
                          action="" autocomplete="off"
                          wire:submit.prevent="submit"
                          method="post">
                        @csrf
                        @if($currency->market != 'perfectmoney')
                            <div class="col-md-12 p-0 form-group mb-1">
                                <label>انتخاب شبکه</label>
                                <select class="form-control round" wire:model.lazy="network_id" wire:change="changeNetwork">
                                    @foreach($networks as $networkItem)
                                        <option
                                            value="{{$networkItem->id}}">
                                            {{ $networkItem->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 p-0 form-group mb-1">
                                <label>آدرس کیف پول</label>
                                <input type="text" value="{{$network->address}}" readonly="readonly"
                                       data-toggle="tooltip"
                                       data-title="کپی در حافظه"
                                       onclick="copyToClipboard(this)"
                                       class="form-control round text-center text-primary"
                                       data-original-title="">
                            </div>
                            <div class="col-md-12 p-0 form-group mb-1 text-center">
                                <img id="imgAddress" src="{{$network->qr_address}}">
                            </div>

                            <div class="col-md-12 p-0 form-group mb-1"
                                 style="display: {{!$network->tag ? 'none' : ''}}">
                                <label>تگ کیف پول</label>
                                <input id="tag" type="text" readonly="readonly"
                                       value="{{$network->tag}}"
                                       data-toggle="tooltip" data-title="کپی در حافظه"
                                       onclick="copyToClipboard(this)"
                                       class="form-control round text-center text-primary">
                            </div>
                            <div class="col-md-12 p-0 form-group mb-1 text-center">
                                <img id="imgTag" src="{{$network->qr_tag}}">
                            </div>

                            <div class="col-md-12 p-0 form-group mb-1">
                                <label for="txid">کد تراکنش (TXID)</label>
                                <input id="txid" type="text" wire:model.lazy="txid"
                                       class="form-control round text-center text-primary">
                            </div>
                        @else
                            <div class="col-md-12 p-0 form-group mb-1">
                                <label>کد ووچر</label>
                                <input type="text" id="voucher_code" wire:model.defer="voucher_code"
                                       class="form-control round text-center ltr-dir"
                                       required="" placeholder="کد ووچر">
                                <div class="invalid-feedback">کد ووچر را وارد کنید</div>
                            </div>
                            <div class="col-md-12 p-0 form-group mb-1">
                                <label>کد فعال سازی</label>
                                <input type="text" id="voucher_activation_code" wire:model.defer="voucher_activation_code"
                                       class="form-control round text-center ltr-dir"
                                       required="" placeholder="کد فعال سازی">
                                <div class="invalid-feedback">کد فعال سازی را وارد کنید</div>
                            </div>
                        @endif
                        <div class="col-md-5  m-auto">
                            <button class="btn btn-primary round btn-block text-14 waves-effect waves-light">
                                ثبت و بررسی
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
                            در واریز خود به آدرس روبرو دقت فرمائید ، مسئولیت هر گونه اشتباه در واریز به عهده شما می
                            باشد
                        </p>
                        <p>
                            جهت افزایش موجوی ابتدا مقدار مورد نظرتان را به آدرس ذکر شده ارسال و بعاد از کامفیرم شدن
                            تراکنش موجودی خود را چک نمائید
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
