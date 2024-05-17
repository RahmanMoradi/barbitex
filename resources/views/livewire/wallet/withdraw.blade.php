@if ($type == 'fiat')
    <div class="row">
        <div class="col-md-6">
            <div class="card o-hidden">
                <div class="card-body">
                    <div class="card-title m-0 mb-1">
                        <i class="feather icon-trending-down"></i>
                        کاهش موجودی
                    </div>
                    <div class="border border-primary text-center p-2 font-medium-1">
                        موجودی: {{Helper::numberFormatPrecision($balance,0)}}<small>
                            تومان </small>
                    </div>
                    <p class="font-small-3 ">حداقل مبلغ قابل برداشت 50,000 تومان است.</p>
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
                        @if (Setting::get('withdraw_irt_fee') && Setting::get('withdraw_irt_fee') > 0)
                            <div class="col-md-12 p-0 form-group mb-1">
                                <label>کارمزد برداشت</label>
                                <input type="text" id="wage"
                                       class="form-control round text-center ltr-dir"
                                       value="{{Setting::get('withdraw_irt_fee')}} تومان" readonly>
                            </div>
                            <div class="col-md-12 p-0 form-group mb-1">
                                <label>مبلغ دریافتی</label>
                                <input type="text" id="wage"
                                       class="form-control round text-center ltr-dir"
                                       value="{{number_format(intval(preg_replace('/[^\d. ]/', '', $amount)) - Setting::get('withdraw_irt_fee'))}} تومان"
                                       readonly>
                            </div>
                        @endif

                        <div class="col-md-12 p-0 form-group" id="box-cardbank">
                            <label for="phone">کارت بانکی جهت واریز</label>
                            <select class="form-control round" wire:model.lazy="card_id" id="cardbank" required="">
                                <option>کارت بانکی را انتخاب کنید</option>
                                @foreach(Auth::user()->cardActive as $card)
                                    <option value="{{$card->id}}">{{$card->card_number}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">کارت بانکی را انتخاب کنید</div>
                            <small class="mr-2">لیست کارت بانکی های تایید شده را مشاهده میکنید.
                            </small>
                        </div>

                        <div class="col-md-12 p-0 form-group mb-1">
                            <label for="phone">توضیحات اضافه</label>
                            <textarea rows="3" class="form-control round text-center" id="description"
                                      wire:model.lazy="description" maxlength="300"></textarea>
                        </div>

                        <div class="col-md-5  m-auto">
                            <button class="btn btn-primary round btn-block text-14 waves-effect waves-light"
                                    wire:loading.attr="disabled">
                                ثبت درخواست
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

                    <div class="text-14 mb-md-5">
                        <p>دقت نمایید پس از ثبت درخواست، امکان لغو درخواست وجود نداشته و وجه درخواستی بلافاصله از
                            کیف پول شما کسر می گردد.</p>
                        <p>پس از ثبت، درخواست شما به واحد مالی اعلام شده و مبلغ درخواستی به حساب بانکی شما واریز
                            خواهد شد.</p>
                        <p>برای پیگیری درخواست میتوانید به بخش تیکت ها و یا لیست تراکنش ها مراجعه کنید.</p>
                        <p>از تاریخ شنبه مورخه ۴ مرداد ماه تمامی سفارت فروش و برداشت به بانک های غیر از ملی و ملت
                            بصورت پایا واریز خواهد شد اما هر کاربر روزانه 1 بار حق برداشت بصورت کارت به کارت تا سقف
                            300,000 تومان برای هر بانکی را دارد.
                        </p>
                        <p>
                            سفارشات فروش و برداشت از کیف پول به مقصد بانک آینده زیر ۲۰ دقیقه انجام خواهد شد‌.
                            <br>
                            مابقی بانک ها طبق سیکل پایا بانک مرکزی طی فرمول ذیل به حساب واریز میشود.
                            <br>
                            از ساعت 00:00 تا 10:30 صبح ساعت 11:15 صبح واریز میشود.
                            <br>
                            از 10:31 تا 12:00 ساعت 14:00 واریز میشود.
                            <br>
                            از 12:01 ظهر تا 23:59 فردای آن روز ساعت 04:00 صبح واریز میشود.
                            <br>
                            توصیه میشود برای دریافت آنی وجه از بانک آینده استفاده نمایید‌. با تشکر
                        </p>

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

                        <i class="feather icon-trending-down"></i>
                        کاهش موجودی
                    </div>
                    <div class="border border-primary text-center p-2 font-medium-1">
                        موجودی: {{Helper::numberFormatPrecision($balance,$currency->decimal)}}<small>
                            {{$currency->symbol}} </small>
                    </div>
                    <form id="wallet_increase" class="mt-2 needs-validation" novalidate=""
                          wire:submit.prevent="submitCurrency" autocomplete="off">
                        @csrf
                        @if ($currency->market == 'perfectmoney')
                            <div class="col-md-12 p-0 form-group mb-1">
                                <div class="col-md-12 p-0 form-group mb-1">
                                    <label>مقدار حداقل ( 10 {{$currency->symbol}})</label>
                                    <input type="text" id="amount" wire:model.lazy="amount"
                                           class="form-control round text-center ltr-dir"
                                           required="" placeholder="مقدار">
                                </div>
                            </div>
                            <div class="col-md-12 p-0 form-group mb-1">
                                <label>نوع برداشت</label>
                                <select class="form-control round" wire:model.lazy="pmType">
                                    <option value="perfectmoney">پرفکت مانی</option>
                                    <option value="voucher">ووچر</option>
                                </select>
                            </div>
                            @if ($pmType == 'perfectmoney')
                                <div class="col-md-12 p-0 form-group mb-1">
                                    <label>کیف پول جهت برداشت</label>
                                    <input type="text" id="wallet" wire:model.lazy="wallet"
                                           class="form-control round text-center ltr-dir"
                                           required="" placeholder="کیف پول">
                                    <div class="invalid-feedback">کیف پول را درج کنید</div>
                                </div>
                            @endif
                        @else
                            <div class="col-md-12 p-0 form-group mb-1">
                                <div class="col-md-12 p-0 form-group mb-1">
                                    <label>مقدار حداقل ({{$network->withdrawMin}} {{$currency->symbol}})</label>
                                    <input type="text" id="amount" wire:model.lazy="amount"
                                           class="form-control round text-center ltr-dir"
                                           required="" placeholder="مقدار">
                                </div>
                            </div>
                            <div class="col-md-12 p-0 form-group" id="box-cardbank">
                                <div class="col-md-12 p-0 form-group mb-1">
                                    <label>شبکه برداشت</label>
                                    <select class="form-control round" wire:model.lazy="network_id"
                                            wire:change="changeNetwork">
                                        @foreach($networks as $networkItem)
                                            <option
                                                value="{{$networkItem->id}}">
                                                {{ $networkItem->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 p-0 form-group mb-1">
                                    <label>کیف پول جهت برداشت</label>
                                    <input type="text" id="wallet" wire:model.lazy="wallet"
                                           class="form-control round text-center ltr-dir"
                                           required="" placeholder="کیف پول">
                                    <div class="invalid-feedback">کیف پول را درج کنید</div>
                                </div>
                            </div>
                            @if ($network->tag)
                                <div class="col-md-12 p-0 form-group mb-1">
                                    <label>تگ کیف پول جهت برداشت</label>
                                    <input type="text" id="tag" wire:model.lazy="tag"
                                           class="form-control round text-center ltr-dir"
                                           required="" placeholder="تگ کیف پول">
                                    <div class="invalid-feedback">تگ کیف پول را درج کنید</div>
                                </div>

                            @endif
                            <div class="col-md-12 p-0 form-group" id="box-cardbank">
                                <div class="col-md-12 p-0 form-group mb-1">
                                    <label>کارمزد انتقال</label>
                                    <input type="text" class="form-control round text-center ltr-dir" readonly
                                           required="" placeholder="کارمزد انتقال"
                                           value="{{$network->withdrawFee}} {{$currency->symbol}}">
                                </div>
                            </div>
                        @endif
                        <div class="col-md-5  m-auto">
                            <button class="btn btn-primary round btn-block text-14 waves-effect waves-light">
                                برداشت
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
                    <div class="text-14 mb-md-5">
                        <p>
                            لطفا در وارد کردن آدرس برداشت دقت فرمائید مسئولیت وارد کردن اشتباه کیف پول به عهده شما می
                            باشد
                        </p>
                        <p>
                            عملیات برداشت از حساب به صورت اتوماتیک انجام میگردد
                        </p>
                        <p>
                            ممکن است پس از ثبت در خواست برداشت تا کانفیرم شدن تراکنش شما کمی زمان ببرد
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
