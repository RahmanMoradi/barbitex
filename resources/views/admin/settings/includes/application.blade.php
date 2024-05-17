<div class="card-body">
    <p class="">
        @lang('application setting')
        @lang('جهت سفارش اپلیکیشن در ارتباط باشید')
    </p>
    <div class="col-12 border-primary p-2">
        <div class="table-responsive">
            <form id="formSetting" action="{{route('admin.setting.store.application')}}" method="post" enctype="multipart/form-data">
                @csrf
                <table class="table table-bordered table-hover">
                    <tbody class="text-center">
                    <tr>
                        <th>@lang('incoming message background image')</th>
                        <th>
                            <input type="file" name="application[bg-message]">
                            <a href="{{asset(Setting::get('application.bg-message'))}}" target="_blank">@lang('current image')</a>
                        </th>
                    </tr>
                    <tr>
                        <th>@lang('message id when opening the app')</th>
                        <th>
                            <input type="number" name="application[text_id]" class="form-control"
                                   value="{{Setting::get('application.text_id')}}"/>
                        </th>
                    </tr>
                    <tr>
                        <th>@lang('message title when opening the app')</th>
                        <th>
                             <input name="application[title]" class="form-control"
                                       value="{{Setting::get('application.title')}}"/>
                        </th>
                    </tr>
                    <tr>
                        <th>@lang('message when opening the app')</th>
                        <th>
                             <textarea name="application[message]" class="form-control"
                                       rows="3">{{Setting::get('application.message')}}</textarea>
                        </th>
                    </tr>
                    <tr>
                        <th>@lang('home message under slider')</th>
                        <th>
                            <input type="text" name="application[home_message]"
                                   class="form-control" value="{{Setting::get('application.home_message')}}"/>
                        </th>
                    </tr>
                    <tr>
                        <th>@lang('application version')</th>
                        <th>
                            <input type="text" class="form-control" name="application[version]"
                                   value="{{Setting::get('application.version')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>@lang('application file')</th>
                        <th>
                            <input type="text" class="form-control" name="application[link]"
                                   value="{{Setting::get('application.link')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>@lang('requires mandatory update')</th>
                        <th>
                            <select name="application[force_download]" class="form-control">
                                <option {{Setting::get('application.force_download') == 1 ? 'selected' : ''}} value="1">
                                    @lang('yes')
                                </option>
                                <option {{Setting::get('application.force_download') == 1 ? '' : 'selected'}} value="0">
                                    @lang('no')
                                </option>
                            </select>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-outline-success">@lang('submit')</button>
            </form>
        </div>
    </div>
</div>
