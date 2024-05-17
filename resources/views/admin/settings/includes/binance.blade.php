<div class="card-body">

    <p class="">
        @lang('connection setting')
    </p>
    <p>@lang('your IP to build api in exchange offices')<span class="badge badge-info"
                                                              onclick="copyToClipboard(this)">{{request()->server('SERVER_ADDR')}}</span>
    </p>
    <div class="col-12 border-primary p-2">
        <div class="table-responsive">
            @if(in_array('binance',\App\Helpers\Helper::markets()))
                <p class="text-danger">@lang('binance description')</p>
                <p>@lang('to get api key and secret key, refer to binance site')</p>
                <p>@lang('if you do not have an account on the binance site, use this link to register')</p>
                <a href="https://www.binance.com/en/activity/referral/offers/claim?ref=CPA_002EZAPHO4">@lang('register in binance')</a>
            @endif
            @if(in_array('kucoin',\App\Helpers\Helper::markets()))
                <p class="text-danger">@lang('kucoin description')</p>
                <p>@lang('to get api key and secret key password, refer to kucoin site')</p>
                <p>if you do not have an account on the kucoin site, use this link to register</p>
                <a href="https://www.kucoin.com/ucenter/signup?rcode=r3VTHAW" target="_blank">
                    register in kucoin
                </a>
            @endif
            <hr>
            <form id="formSetting" action="{{route('admin.setting.store.binance')}}" method="post">
                @csrf
                <table class="table table-bordered table-hover">
                    <tbody class="text-center">
                    @if(in_array('binance',\App\Helpers\Helper::markets()))
                        <tr>
                            <th>@lang('binance setting')</th>
                            <th>
                                <label for="">api key</label>
                                <input type="text" class="form-control" name="binance[api_key]"
                                       value="{{Setting::get('binance.api_key')}}">
                                <hr>
                                <label for="">secret key</label>
                                <input type="password" class="form-control" name="binance[secret_key]"
                                       value="{{Setting::get('binance.secret_key')}}" autocomplete="off">
                            </th>
                        </tr>
                    @endif
                    @if(in_array('kucoin',\App\Helpers\Helper::markets()))
                        <tr>
                            <th>@lang('kucoin setting')</th>
                            <th>
                                <label for="">api key kucoin</label>
                                <input type="text" class="form-control" name="kucoin[api_key]"
                                       value="{{Setting::get('kucoin.api_key')}}">
                                <hr>
                                <label for="">secret key kucoin</label>
                                <input type="password" class="form-control" name="kucoin[secret_key]"
                                       value="{{Setting::get('kucoin.secret_key')}}">
                                <hr>
                                <label for="">password kucoin</label>
                                <input type="password" class="form-control" name="kucoin[password]"
                                       value="{{Setting::get('kucoin.password')}}">
                            </th>
                        </tr>
                    @endif
                    @if(in_array('perfectmoney',\App\Helpers\Helper::markets()))
                        <tr>
                            <th>@lang('perfectmoney setting')</th>
                            <th>
                                <label for="">account id perfectmoney</label>
                                <input type="text" class="form-control" name="perfectmoney[account_id]"
                                       value="{{Setting::get('perfectmoney.account_id')}}">
                                <hr>
                                <label for="">passphrase perfectmoney</label>
                                <input type="password" class="form-control" name="perfectmoney[passphrase]"
                                       value="{{Setting::get('perfectmoney.passphrase')}}">
                                <hr>
                                <hr>
                                <label for="">alternate passphrase perfectmoney</label>
                                <input type="password" class="form-control" name="perfectmoney[alternate_passphrase]"
                                       value="{{Setting::get('perfectmoney.alternate_passphrase')}}">
                                <hr>
                                <label for="">merchant perfectmoney</label>
                                <input type="text" class="form-control" name="perfectmoney[merchant_id]"
                                       value="{{Setting::get('perfectmoney.merchant_id')}}">
                            </th>
                        </tr>
                    @endif
                    <tr>
                        <th>@lang('sms panel setting')</th>
                        <th>
                            <label for="">@lang('kavenegar api')</label>
                            <input type="password" class="form-control" name="kavenegar_api"
                                   value="{{Setting::get('kavenegar_api')}}">
                        </th>
                    </tr>
                    <tr>
                        <th>@lang('email send setting')</th>
                        <th>
                            <label for="">@lang('mailer')</label>
                            <select name="mail[mailer]" class="form-control">
                                <option value="">@lang('select')</option>
                                <option {{Setting::get('mail.mailer') == 'smtp' ? 'selected' : ''}} value="smtp">smtp
                                </option>
                                <option
                                    {{Setting::get('mail.mailer') == 'sendmail' ? 'selected' : ''}} value="sendmail">
                                    sendmail
                                </option>
                                <option {{Setting::get('mail.mailer') == 'mailgun' ? 'selected' : ''}} value="mailgun">
                                    mailgun
                                </option>
                            </select>
                            <hr>
                            <label for="">@lang('host')</label>
                            <input type="text" value="{{Setting::get('mail.host')}}" class="form-control"
                                   name="mail[host]">
                            <hr>
                            <label for="">@lang('port')</label>
                            <input type="text" value="{{Setting::get('mail.port')}}" class="form-control"
                                   name="mail[port]">
                            <hr>
                            <label for="">@lang('encryption')</label>
                            <select name="mail[encryption]" class="form-control">
                                <option value="">@lang('select')</option>
                                <option {{Setting::get('mail.encryption') == 'null' ? 'selected' : ''}} value="null">
                                    null
                                </option>
                                <option
                                    {{Setting::get('mail.encryption') == 'tls' ? 'selected' : ''}} value="tls">
                                    tls
                                </option>
                            </select>
                            <hr>
                            <label for="">@lang('username')</label>
                            <input type="text" value="{{Setting::get('mail.username')}}" class="form-control"
                                   name="mail[username]" autocomplete="off">
                            <hr>
                            <label for="">@lang('password')</label>
                            <input type="password" value="{{Setting::get('mail.password')}}" class="form-control"
                                   name="mail[password]">
                            <hr>
                            <label for="">@lang('from address')</label>
                            <input type="text" value="{{Setting::get('mail.from_address')}}" class="form-control"
                                   name="mail[from_address]">
                            <hr>
                            <label for="">@lang('from name')</label>
                            <input type="text" value="{{Setting::get('mail.from_name')}}" class="form-control"
                                   name="mail[from_name]">
                        </th>
                    </tr>
                    </tbody>
                </table>
                <hr>
                <button type="submit" class="btn btn-outline-success">@lang('submit')</button>
            </form>
        </div>
    </div>
</div>
