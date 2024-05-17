<div class="card-body">
    <p class="">
        تنظیمات برگه ها
    </p>
    <div class="col-12 border-primary p-2">
        <div class="table-responsive">
            <form id="formSetting" action="{{route('admin.setting.store.page')}}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered table-hover">
                    <tbody class="text-center">
                    <tr>
                        <div class="form-group">
                            <label>متن برگه درباره ما</label>
                            <textarea class="editor" name="about" class="form-control"
                                      rows="3">{{Setting::get('about')}}</textarea>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <label>متن برگه قوانین و مقرات</label>
                            <textarea class="editor" name="terms" class="form-control"
                                      rows="3">{{Setting::get('terms')}}</textarea>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <label>متن برگه تماس با ما</label>
                            <textarea class="editor" name="contact" class="form-control"
                                      rows="3">{{Setting::get('contact')}}</textarea>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <label>متن برگه سوالات متداول</label>
                            <textarea class="editor" name="ask" class="form-control"
                                      rows="3">{{Setting::get('ask')}}</textarea>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <label>متن برگه راهنمای استفاده</label>
                            <textarea class="editor" name="help" class="form-control"
                                      rows="3">{{Setting::get('help')}}</textarea>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <label>متن برگه کارمزد</label>
                            <textarea class="editor" name="wage" class="form-control"
                                      rows="3">{{Setting::get('wage')}}</textarea>
                        </div>
                    </tr>
                    @if(\App\Helpers\Helper::modules()['application'])
                        <tr>
                            <div class="form-group">
                                <label>متن برگه دانلود اپلیکیشن</label>
                                <textarea class="editor" name="applicationPage" class="form-control"
                                          rows="3">{{Setting::get('applicationPage')}}</textarea>
                            </div>
                        </tr>
                    @endif
                    @if(\App\Helpers\Helper::modules()['cooperation'])
                        <tr>
                            <div class="form-group">
                                <label>متن برگه همکاری</label>
                                <textarea class="editor" name="cooperation" class="form-control"
                                          rows="3">{{Setting::get('cooperation')}}</textarea>
                            </div>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <button type="submit" class="btn btn-outline-success">ثبت تنظیمات</button>
            </form>
        </div>
    </div>
</div>
