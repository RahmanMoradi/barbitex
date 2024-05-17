<div class="card-body">
    <p class="">
        تنظیمات عمومی سایت
    </p>
    <div class="col-12 border-primary p-2">
        <div class="table-responsive">
            <form id="formSetting" action="{{route('admin.setting.store')}}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered table-hover">
                    <tbody class="text-center">
                    <tr>
                        <th>عنوان</th>
                        <th>
                            <input type="text" class="form-control" name="title"
                                   value="{{Setting::get('title')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>لوگو</th>
                        <th>
                            <input type="file" class="form-control" name="logo">
                        </th>
                    </tr>
                    <tr>
                        <th>فاو آیکون</th>
                        <th>
                            <input type="file" class="form-control" name="favicon">
                        </th>
                    </tr>
                    <tr>
                        <th>نمایش بازار برای کاربر مهمان و احراز نشده</th>
                        <th>
                            <select name="guestShowMarket" class="form-control">
                                <option value="">انتخاب کنید...</option>
                                <option {{Setting::get('guestShowMarket') == '1' ? 'selected':''}} value="1">
                                    بله
                                </option>
                                <option {{Setting::get('guestShowMarket') == '0' ? 'selected':''}} value="0">
                                    خیر
                                </option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th>نمایش نام فارسی در صفحه اصلی</th>
                        <th>
                            <select name="marketNameFa" class="form-control">
                                <option value="">انتخاب کنید...</option>
                                <option {{Setting::get('marketNameFa') == '1' ? 'selected':''}} value="1">
                                    بله
                                </option>
                                <option {{Setting::get('marketNameFa') == '0' ? 'selected':''}} value="0">
                                    خیر
                                </option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th>نمایش چارت در لیست صفحه اصلی</th>
                        <th>
                            <select name="homeChart" class="form-control">
                                <option value="">انتخاب کنید...</option>
                                <option {{Setting::get('homeChart') == '1' ? 'selected':''}} value="1">
                                    بله
                                </option>
                                <option {{Setting::get('homeChart') == '0' ? 'selected':''}} value="0">
                                    خیر
                                </option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th>نمایش ماشین حساب در صفحه اصلی</th>
                        <th>
                            <select name="homeCalculator" class="form-control">
                                <option value="">انتخاب کنید...</option>
                                <option {{Setting::get('homeCalculator') == '1' ? 'selected':''}} value="1">
                                    بله
                                </option>
                                <option {{Setting::get('homeCalculator') == '0' ? 'selected':''}} value="0">
                                    خیر
                                </option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th>قالب پنل کاربران</th>
                        <th>
                            <select name="panelV4" class="form-control">
                                <option value="">انتخاب کنید...</option>
                                <option {{Setting::get('panelV4') == '1' ? 'selected':''}} value="1">
                                    تم 1
                                </option>
                                <option {{Setting::get('panelV4') == '0' ? 'selected':''}} value="0">
                                    تم 2
                                </option>
                            </select>
                        </th>
                    </tr>

                    <tr>
                        <th>
                            ارسال کد ثبت نام به:
                            <span class="badge badge-light-danger">جدید</span>
                        </th>
                        <th>
                            <select name="registerField" class="form-control">
                                <option {{Setting::get('registerField') == 'email' ? 'selected':''}} value="email">
                                    ایمیل
                                </option>
                                <option {{Setting::get('registerField') == 'mobile' ? 'selected':''}} value="mobile">
                                    موبایل
                                </option>
                            </select>
                        </th>
                    </tr>

                    @if (\App\Helpers\Helper::modules()['orderPlane'])
                        <tr>
                            <th>حداقل خرید از ما بازار ساده</th>
                            <th>
                                <input type="text" class="form-control" name="min_buy"
                                       value="{{Setting::get('min_buy')}}">
                            </th>
                        </tr>
                        <tr>
                            <th>حداقل فروش به ما بازار ساده</th>
                            <th>
                                <input type="text" class="form-control" name="min_sell"
                                       value="{{Setting::get('min_sell')}}">
                            </th>
                        </tr>
                    @endif
                    <tr>
                        <th>برداشت از کیف پول</th>
                        <th>
                            <select name="autoWithdraw" class="form-control">
                                <option value="">انتخاب کنید...</option>
                                <option {{Setting::get('autoWithdraw') == '0' ? 'selected':''}} value="0">نیاز به تائید
                                    مدیر
                                </option>
                                <option {{Setting::get('autoWithdraw') == '1' ? 'selected':''}} value="1">اتوماتیک
                                </option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th>واریز به کیف پول</th>
                        <th>
                            <select name="autoDeposit" class="form-control">
                                <option value="">انتخاب کنید...</option>
                                <option {{Setting::get('autoDeposit') == '0' ? 'selected':''}} value="0">نیاز به تائید
                                    مدیر
                                </option>
                                <option {{Setting::get('autoDeposit') == '1' ? 'selected':''}} value="1">اتوماتیک
                                </option>
                            </select>
                        </th>
                    </tr>

                    <tr>
                        <th>
                            کارمزد برداشت تومانی
                            <span class="badge badge-light-danger">جدید</span>
                        </th>
                        <th>
                            <input type="text" class="form-control" name="withdraw_irt_fee" placeholder="1000"
                                   value="{{Setting::get('withdraw_irt_fee')}}">
                        </th>
                    </tr>

                    <tr>
                        <th>کارمزد معاملات بازار حرفه ای</th>
                        <th>
                            <input type="text" class="form-control" name="market_fee" placeholder="0.15"
                                   value="{{Setting::get('market_fee')}}">
                        </th>
                    </tr>

                    <tr>
                        <th>حداقل سفارش در بازار حرفه ای</th>
                        <th>
                            <input type="text" class="form-control" name="min_market_buy"
                                   value="{{Setting::get('min_market_buy')}}">
                        </th>
                    </tr>

                    <tr>
                        <th>متن احراز هویت</th>
                        <th>
                            <textarea type="text" class="editor form-control" name="authText"
                            >{{Setting::get('authText')}}
                            </textarea>
                        </th>
                    </tr>
                    <tr>
                        <th>پیام هنگام ورود کاربران</th>
                        <th>
                                                <textarea name="adminMessage" class="form-control editor"
                                                          rows="3">{{Setting::get('adminMessage')}}</textarea>
                        </th>
                    </tr>
                    <tr>
                        <th>تصویر احراز هویت</th>
                        <th>
                            <input type="file" class="form-control" name="authImage">
                        </th>
                    </tr>
                    <tr>
                        <th>قالب ادمین و کاربران</th>
                        <th>
                            <select name="theme" id="theme" class="form-control">
                                <option
                                    {{Setting::get('theme')  == 'light' ? 'selected' : ''}} value="light">
                                    روشن
                                </option>
                                <option
                                    {{Setting::get('theme')  == 'dark' ? 'selected' : ''}} value="dark">
                                    تاریک
                                </option>
                                <option
                                    {{Setting::get('theme') ==  'semi-dark' ? 'selected' : ''}} value="semi-dark">
                                    منو تاریک - صفحه روشن
                                </option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th>توضیحات</th>
                        <th>
                                                <textarea name="description" class="form-control"
                                                          rows="3">{{Setting::get('description')}}</textarea>
                        </th>
                    </tr>
                    <tr>
                        <th>توضیحات سئو</th>
                        <th>
                                                <textarea name="meta_description" class="form-control"
                                                          rows="3">{{Setting::get('meta_description')}}</textarea>
                        </th>
                    </tr>
                    <tr>
                        <th>کلمات کلیدی سئو</th>
                        <th>
                                                <textarea name="meta_tag" class="form-control"
                                                          rows="3">{{Setting::get('meta_tag')}}</textarea>
                        </th>
                    </tr>
                    <tr>
                        <th>ایمیل</th>
                        <th>
                            <input type="text" class="form-control" name="email"
                                   value="{{Setting::get('email')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>تلفن</th>
                        <th>
                            <input type="text" class="form-control" name="phone"
                                   value="{{Setting::get('phone')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>موبایل</th>
                        <th>
                            <input type="text" class="form-control" name="mobile"
                                   value="{{Setting::get('mobile')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>آدرس</th>
                        <th>
                                                <textarea name="address" class="form-control"
                                                          rows="3">{{Setting::get('address')}}</textarea>
                        </th>
                    </tr>
                    <tr>
                        <th>اطلاعات حساب کارت به کارت</th>
                        <th>
                                                <textarea name="account" class="form-control editor"
                                                          rows="3">{{Setting::get('account')}}</textarea>
                        </th>
                    </tr>
                    <tr>
                        <th>کد جاوا اسکریپت (کد چت)</th>
                        <th>
                                                <textarea name="script" class="form-control"
                                                          rows="3">{{Setting::get('script')}}</textarea>
                        </th>
                    </tr>
                    <tr>
                        <th>کارمزد زیر مجموعه گیری(%)</th>
                        <th>
                            <input type="text" class="form-control" name="referralPercent"
                                   value="{{Setting::get('referralPercent')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>فعال کردن NoCaptcha</th>
                        <th>
                            <select type="text" class="form-control" name="NOCAPTCHA_Active">
                                <option value="">انتخاب کنید</option>
                                <option {{Setting::get('NOCAPTCHA_Active') == 1 ? 'selected' : ''}} value="1">فعال
                                </option>
                                <option {{Setting::get('NOCAPTCHA_Active') == 0 ? 'selected' : ''}} value="0">غیر فعال
                                </option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th>گوگل NOCAPTCHA_SECRET</th>
                        <th>
                            <input type="text" class="form-control" name="NOCAPTCHA_SECRET"
                                   value="{{Setting::get('NOCAPTCHA_SECRET')}}" placeholder="گوگل NOCAPTCHA_SECRET">
                        </th>
                    </tr>
                    <tr>
                        <th>گوگل NOCAPTCHA_SITEKEY</th>
                        <th>
                            <input type="text" class="form-control" name="NOCAPTCHA_SITEKEY"
                                   value="{{Setting::get('NOCAPTCHA_SITEKEY')}}" placeholder="گوگل NOCAPTCHA_SITEKEY">
                        </th>
                    </tr>
                    <tr>
                        <th>تلگرام</th>
                        <th>
                            <input type="text" class="form-control" name="telegram"
                                   value="{{Setting::get('telegram')}}" placeholder="https://t.me/webazin">
                        </th>
                    </tr>
                    <tr>
                        <th>اینستاگرام</th>
                        <th>
                            <input type="text" class="form-control" name="instagram"
                                   value="{{Setting::get('instagram')}}" placeholder="https://instagram.com/">
                        </th>
                    </tr>
                    <tr>
                        <th>واتس آپ</th>
                        <th>
                            <input type="text" class="form-control" name="whatsapp"
                                   value="{{Setting::get('whatsapp')}}" placeholder="">
                        </th>
                    </tr>
                    <tr>
                        <th>فیسبوک</th>
                        <th>
                            <input type="text" class="form-control" name="facebook"
                                   value="{{Setting::get('facebook')}}" placeholder="">
                        </th>
                    </tr>
                    <tr>
                        <th>تویتر</th>
                        <th>
                            <input type="text" class="form-control" name="twitter"
                                   value="{{Setting::get('twitter')}}" placeholder="">
                        </th>
                    </tr>
                    <tr>
                        <th>اسکایپ</th>
                        <th>
                            <input type="text" class="form-control" name="skype"
                                   value="{{Setting::get('skype')}}" placeholder="">
                        </th>
                    </tr>
                    <tr>
                        <th>youtube</th>
                        <th>
                            <input type="text" class="form-control" name="youtube"
                                   value="{{Setting::get('youtube')}}" placeholder="">
                        </th>
                    </tr>
                    <tr>
                        <th>pinterest</th>
                        <th>
                            <input type="text" class="form-control" name="pinterest"
                                   value="{{Setting::get('pinterest')}}" placeholder="">
                        </th>
                    </tr>

                    </tbody>
                </table>
                <button type="submit" class="btn btn-outline-success">
                    ثبت تنظیمات
                </button>
            </form>
        </div>
    </div>
</div>
