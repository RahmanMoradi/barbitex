<div>
    <div class="card-body">

        <p class="">جهت دریافت خدمات و سرویس های وب سایت به صورت آنی، می بایست شماره کارت بانکی که خرید
            را
            توسط آن انجام می دهید ثبت نمایید.
        </p>
        <div class="col-12 border-primary p-2">
            <fieldset>
                <div class="vs-checkbox-con vs-checkbox-primary">
                    <input type="checkbox" onclick="$('form').slideToggle();" checked="">
                    <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                    <span>افزودن کارت بانکی</span>
                </div>
            </fieldset>
            <form autocomplete="off" wire:submit.prevent="store"
                  novalidate>
                @csrf
                <div class="row col-md-9 col-12 m-md-auto m-0 p-0 mt-2">

                    <div class="col-md-6 form-group">
                        <label>نام بانک</label>
                        <select wire:model.lazy="bank_name" id="bank_name" required
                                class="form-control round text-center">
                            <option value="" selected>انتخاب کنید</option>
                            <option value="بانک ملی">بانک ملی</option>
                            <option value="بانک ملت">بانک ملت</option>
                            <option value="بانک مسکن">بانک مسکن</option>
                            <option value="بانک آینده">بانک آینده</option>
                            <option value="بانک صادرات">بانک صادرات</option>
                            <option value="بانک کشاورزی">بانک کشاورزی</option>
                            <option value="بانک سامان">بانک سامان</option>
                            <option value="بانک پارسیان">بانک پارسیان</option>
                            <option value="بانک پاسارگاد">بانک پاسارگاد</option>
                            <option value="بانک دی">بانک دی</option>
                            <option value="بانک رسالت">بانک رسالت</option>
                            <option value="بانک شهر">بانک شهر</option>
                            <option value="بانک سرمایه">بانک سرمایه</option>
                            <option value="بانک اقتصاد نوین">بانک اقتصاد نوین</option>
                            <option value="بانک انصار">بانک انصار</option>
                            <option value="بانک تجارت">بانک تجارت</option>
                            <option value="بانک ایران زمین">بانک ایران زمین</option>
                            <option value="سایر">سایر</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>شماره کارت</label>
                        <input type="text" class="form-control round text-center numbers ltr-dir"
                               wire:model.lazy="card_number" maxlength="16" minlength="16" placeholder="شماره کارت"
                               required="">
                    </div>

                    <div class="clearfix"></div>
                    <div id="box-shaba" class="w-100">
                        <div class="d-flex">
                            <div class="col-md-6 form-group validate">
                                <label>شماره حساب</label>
                                <input type="text"
                                       class="form-control round text-center numbers ltr-dir"
                                       wire:model.lazy="account_number" maxlength="16" minlength="9"
                                       data-validation-required-message="این فیلد اجباری می باشد"
                                       placeholder="شماره حساب"
                                       required>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>شماره شبا بدون IR</label>
                                <input type="text"
                                       class="form-control round text-center numbers ltr-dir"
                                       wire:model.lazy="sheba"
                                       maxlength="24" minlength="24"
                                       data-validation-containsnumber-message="شماره شبای 24 رقمی را وارد کنید"
                                       placeholder="شماره شبا بدون IR" required>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-md-4 mx-auto">
                        <button type="submit"
                                class="btn btn-primary round btn-block waves-effect waves-light">ثبت
                            کارت
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-default">
                <tr>
                    <th class="text-center ">#</th>
                    <th class="text-center">شماره کارت</th>
                    <th class="text-center">شماره حساب</th>
                    <th class="text-center">شبا</th>
                    <th class="text-center">وضعیت</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($cards as $card)
                    <tr>
                        <td scope="row" class="sans-serif">1</td>
                        <td class=" sans-serif">{{$card->card_number}}</td>
                        <td class=" sans-serif">{{$card->account_number}}</td>
                        <td class=" sans-serif">{{$card->sheba}}</td>
                        <td>
                            {!! $card->status_html !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
