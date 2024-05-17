<div class="card-body">
    <p class="">
        تنظیمات اپلیکیشن PWA
    </p>
    <div class="col-12 border-primary p-2">
        <div class="table-responsive">
            <p>در این برگه کلیه تنظیمات PWA انجام میگردد</p>

            <form id="formSetting" action="{{route('admin.setting.store.pwa')}}" method="post"
            enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered table-hover">
                    <tbody class="text-center">
                    <tr>
                        <th>نام</th>
                        <th>
                            <input type="text" class="form-control" name="pwa[name]"
                                   value="{{Setting::get('pwa.name')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>نام کوتاه</th>
                        <th>
                            <input type="text" class="form-control" name="pwa[short_name]"
                                   value="{{Setting::get('pwa.short_name')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>لینک شروع برنامه</th>
                        <th>
                            <input type="text" dir="ltr" class="form-control" name="pwa[start_url]"
                                   value="{{Setting::get('pwa.start_url')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>
                            رنگ پس زمینه
                        </th>
                        <th>
                            <input type="color" class="form-control" name="pwa[background_color]"
                                   value="{{Setting::get('pwa.background_color')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>رنگ اصلی</th>
                        <th>
                            <input type="color" class="form-control" name="pwa[theme_color]"
                                   value="{{Setting::get('pwa.theme_color')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>رنگ نوار بالا</th>
                        <th>
                            <input type="color" class="form-control" name="pwa[status_bar]"
                                   value="{{Setting::get('pwa.status_bar')}}">
                        </th>
                    </tr>

                    <tr>
                        <th>آیکن برنامه(بهتر است در قابل فایل svg باشد)</th>
                        <th>
                            <input type="file" class="form-control" name="pwa[icon]"
                                   value="{{Setting::get('pwa.icon')}}">
                        </th>
                    </tr>

                    <tr>
                        <th>اسپلش برنامه(بهتر است در قابل فایل svg باشد)</th>
                        <th>
                            <input type="file" class="form-control" name="pwa[splash]"
                                   value="{{Setting::get('pwa.splash')}}">
                        </th>
                    </tr>

                    </tbody>
                </table>
                <input type="submit" value="ثبت تنظیمات" class="btn btn-outline-success">
            </form>
        </div>
    </div>
</div>
