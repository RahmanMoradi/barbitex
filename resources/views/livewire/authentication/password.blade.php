<div>
    <div class="card-body">
        <p class="mt-1">
            در صورت لزوم می‌توانید از طریق این صفحه کلمه عبور خود را تغییر دهید.<br>
            سعی کنید کلمه عبور پیچیده ای انتخاب کنید و با سایر حساب های شما در سایت های دیگر یکسان
            نباشد.<br>
            به منظور افزایش سطح ایمنی حساب کاربری خود می توانید احراز هویت دو مرحله ای را نیز <a
                href="{{url('panel/authentication/two-factor-authentication')}}">فعال کنید</a>.<br>
        </p>
        <form autocomplete="off" wire:submit.prevent="changePassword" class="needs-validation" novalidate="">
            @csrf
            <div class="row col-md-6 col-12 m-md-auto m-0 p-0">
                <div class="col-md-12 p-0 form-group mb-1">
                    <label>رمز عبور فعلی</label>
                    <input type="password" class="form-control round text-center ltr-dir" minlength="6"
                           id="old_password" wire:model.lazy="old_password" placeholder="رمز فعلی" required="">
                    <div class="invalid-feedback">رمز فعلی خود را درج کنید(حداقل 6 کاراکتر)</div>
                </div>

                <div class="col-md-12 p-0 form-group mb-1">
                    <label>رمز عبور جدید</label>
                    <input type="password" class="form-control round text-center ltr-dir" minlength="6"
                           id="password" wire:model.lazy="password" placeholder="رمز جدید" required="">
                    <div class="invalid-feedback">رمز جدید خود را درج کنید(حداقل 6 کاراکتر)</div>
                </div>

                <div class="col-md-12 p-0 form-group mb-1">
                    <label>تکرار رمز جدید</label>
                    <input type="password" class="form-control round text-center ltr-dir" minlength="6"
                           id="password_confirmation" wire:model.lazy="password_confirmation"
                           placeholder="تکرار رمز جدید" required="">
                    <div class="invalid-feedback">تکرار رمز جدید خود را درج کنید(حداقل 6 کاراکتر)</div>
                </div>
                <div class="border-bottom w-80 mb-4 mt-2 mx-auto"></div>
                <div class="col-md-12 m-auto mb-md-3 text-center">
                    <button type="submit" class="btn btn-primary round waves-effect waves-light">ثبت
                        تغییرات
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
