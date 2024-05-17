<section id="transfer">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title m-0 mb-1">

                        <i class="feather icon-trending-down"></i>
                        انتقال موجودی
                    </div>
                    <div class="border border-primary text-center p-2 font-medium-1">
                        موجودی: {{Helper::numberFormatPrecision($balance,$currency->decimal)}}<small>
                            {{$currency->symbol}} </small>
                    </div>
                    <form id="wallet_transfer" class="mt-2 needs-validation" novalidate=""
                          wire:submit.prevent="transfer" autocomplete="off">
                        @csrf
                        <div class="col-md-12 p-0 form-group mb-1">
                            <div class="col-md-12 p-0 form-group mb-1">
                                <label>مقدار ارز</label>
                                <input type="number" id="amount" wire:model.lazy="amount"
                                       class="form-control round text-center ltr-dir"
                                       required="" placeholder="مقدار ارز مورد نظر جهت انتقال">
                                <div class="invalid-feedback">مقدار ارز مورد نظر جهت انتقال</div>
                            </div>
                        </div>
                        <div class="col-md-12 p-0 form-group" id="box-cardbank">
                            <div class="col-md-12 p-0 form-group mb-1">
                                <label>شناسه کاربر جهت انتقال</label>
                                <input type="number" id="user_id" wire:model.lazy="user_id"
                                       class="form-control round text-center ltr-dir"
                                       required="" placeholder="شناسه کاربر جهت انتقال">
                                <div class="invalid-feedback">شناسه کاربر جهت انتقال</div>
                            </div>
                        </div>
                        <div class="col-md-5  m-auto">
                            <button type="submit" class="btn btn-primary round btn-block text-14 waves-effect waves-light">
                                انتقال
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title mb-1 pb-1 border-bottom"><i class="feather icon-info"></i> نکات و هشدارها
                    </div>
                    <div class="text-14 mb-md-5">
                        <p>
                            لطفا در وارد کردن شناسه کاربر دقت فرمائید مسئولیت وارد کردن اشتباه شناسه به عهده شما می
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
</section>
