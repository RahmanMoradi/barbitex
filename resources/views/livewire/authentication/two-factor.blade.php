<div>
    <div class="card-body">
        <p class="mt-1">
            به منظور افزایش سطح ایمنی حساب کاربری خود می توانید احراز هویت دو مرحله ای را فعال کنید. با
            فعال کردن این قابلیت حساب کاربری شما در برابر حملات هکرها، فیشینگ و سوء استفاده افراد سودجو
            ایمن خواهد بود. </p>

        <div class="col-12 border-primary p-2 border-bottom-accent-1">
            <fieldset>
                <div class="vs-checkbox-con vs-checkbox-primary">
                    <input type="checkbox" id="emailLogin" wire:model.lazy="emailLogin"
                           wire:change="emailLoginActive" {{Auth::user()->two_factor_type == 'email' ? 'checked' : ''}}>
                    <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                    <span class="">احراز هویت دو مرحله ای از طریق ایمیل</span>
                </div>
            </fieldset>
            <div class="mt-2" id="block_sms">
                <p>با فعالسازی این گزینه برای هر بار ورود به ایمیل که ثبت کرده اید کد پنج رقمی
                    ارسال میشود و آن کد را باید موقع ورود درج کنید.</p>
            </div>
        </div>
        <div class="col-12 border-primary p-2 border-bottom-accent-1">

            <fieldset>
                <div class="vs-checkbox-con vs-checkbox-primary">
                    <input type="checkbox" id="smsLogin" wire:model.lazy="smsLogin"
                           wire:change="smsLoginActive" {{Auth::user()->two_factor_type == 'sms' ? 'checked' : ''}}>
                    <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                    <span class="">احراز هویت دو مرحله ای از طریق کد پیامکی</span>
                </div>
            </fieldset>

            <div class="mt-2" id="block_sms">
                <p>با فعالسازی این گزینه برای هر بار ورود به شماره موبایلی که ثبت کرده اید کد پنج رقمی
                    ارسال میشود و آن کد را باید موقع ورود درج کنید.</p>
            </div>
        </div>

        <div class="col-12 border-bottom-primary border-left-primary border-right-primary p-2">
            <fieldset>
                <div class="vs-checkbox-con vs-checkbox-primary">
                    <input type="checkbox" id="2fa_google" wire:model.lazy="googleLogin"
                        {{Auth::user()->two_factor_type == 'google' ? 'checked' : ''}}>
                    <span class="vs-checkbox">
                                    <span class="vs-checkbox--check">
                                        <i class="vs-icon feather icon-check"></i>
                                    </span>
                                </span>
                    <span>احراز هویت دو مرحله ای با Google Authenticator</span>
                </div>
            </fieldset>


            <div class="mt-2"
                 id="block_google">
                @if (Auth::user()->two_factor_type == 'google')
                    <p>جهت غیرفعال سازی این قابلیت، بایستی کد درج شده در اپلیکیشن را در فیلد زیر درج
                        کنید و دکمه غیر فعالسازی رو بزنید.</p>
                @else
                    <p>جهت فعال سازی این قابلیت، مراحل زیر را دنبال کنید:</p>
                    <div>
                        1. آخرین نسخه Google Authenticator را از
                        <a rel="nofollow" target="_blank"
                           href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">گوگل
                            پلی</a>
                        یا
                        <a rel="nofollow" target="_blank"
                           href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8">اپل
                            استور</a>
                        دریافت نمایید.
                        <br>
                        2. پس از نصب و اجرای برنامه Google Authenticator از طریق یکی از روش های زیر،
                        کلید را
                        به برنامه اضافه نمایید.
                        <div class="m--padding-right-10 m--padding-top-5"><span class="text-bold-600">- Scan a barcode (اسکن بارکد):</span>
                            این گزینه را انتخاب کرده و بارکد زیر را اسکن نمایید.<br>
                            {!! $QR_Image !!}
                            <br>
                            <span
                                class="text-bold-600">- Enter a provided key (با استفاده از کلید):</span>
                            این
                            گزینه را انتخاب کرده و کد زیر را به دقت وارد نمایید.
                            <h2 class="text-info sans-serif">{{$secret}}</h2>
                        </div>
                        3. کد دریافتی (عدد 6 رقمی) را در کادر زیر وارد نموده و دکمه فعال سازی را کلیک
                        نمایید.
                    </div>
                @endif
                <form class="w-100 needs-validation"
                      wire:submit.prevent="googleLoginActive">
                    <div class="row mt-2">

                        <div class="col-md-5 col-12 form-group mb-2">
                            <input type="text" class="form-control round ltr-dir text-center"
                                   required="" id="code" wire:model.lazy="code" minlength="6" maxlength="6"
                                   placeholder="عدد 6 رقمی">
                            <div class="invalid-feedback">
                                کد 6 رقمی در اپلیکیشن را درج کنید
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="submit"
                                   class="btn btn-primary round btn-block waves-effect waves-light"
                                   value="{{Auth::user()->two_factor_type == 'google' ? 'غیر فعال سازی' : 'فعال سازی'}}">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
