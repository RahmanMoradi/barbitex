<div class="card-body">
    <p class="">
        تنظیمات درگاه پرداخت
    </p>
    <p>ip شما جهت ساخت درگاه <span class="badge badge-info"
                                   onclick="copyToClipboard(this)">{{request()->server('SERVER_ADDR')}}</span>
        می باشد</p>
    <div class="col-12 border-primary p-2">
        <div class="table-responsive">
            <form id="formSetting" action="{{route('admin.setting.store.payment')}}" method="post">
                @csrf
                <table class="table table-bordered table-hover">
                    <tbody class="text-center">
                    <tr>
                        <th>درگاه پیشفرض سایت</th>
                        <th>
                            <select class="form-control" name="default_pay" id="default_pay">
                                <option value="">انتخاب کنید</option>
                                @foreach(\App\Helpers\Helper::payments() as $payment)
                                    <option
                                        {{Setting::get('default_pay') == $payment ? 'selected':''}} value="{{$payment}}">
                                        {{$payment}}
                                    </option>
                                @endforeach
                            </select>
                        </th>
                    </tr>
                    @if(in_array('Idpay',\App\Helpers\Helper::payments()))
                        <tr>
                            <th>api در گاه idpay</th>
                            <th>
                                <input type="text" class="form-control" name="idpay_api"
                                       value="{{Setting::get('idpay_api')}}">
                            </th>
                        </tr>
                    @endif
                    @if(in_array('Nextpay',\App\Helpers\Helper::payments()))
                        <tr>
                            <th>api در گاه nextpay</th>
                            <th>
                                <input type="text" class="form-control" name="nextpay_api"
                                       value="{{Setting::get('nextpay_api')}}">
                            </th>
                        </tr>
                    @endif
                    @if(in_array('Payir',\App\Helpers\Helper::payments()))
                        <tr>
                            <th>api در گاه Payir</th>
                            <th>
                                <input type="text" class="form-control" name="payir_api"
                                       value="{{Setting::get('payir_api')}}">
                            </th>
                        </tr>
                    @endif
                    @if(in_array('Zarinpal',\App\Helpers\Helper::payments()))
                        <tr>
                            <th>api در گاه Zarinpal</th>
                            <th>
                                <input type="text" class="form-control" name="zarinpal_merchant"
                                       value="{{Setting::get('zarinpal_merchant')}}">
                            </th>
                        </tr>
                    @endif
                    @if(in_array('Zibal',\App\Helpers\Helper::payments()))
                        <tr>
                            <th>api در گاه Zibal</th>
                            <th>
                                <input type="text" class="form-control" name="zibal-merchant"
                                       value="{{Setting::get('zibal-merchant')}}">
                            </th>
                        </tr>
                    @endif
                    @if(in_array('Mellat',\App\Helpers\Helper::payments()))
                        <tr>
                            <th>در گاه Mellat</th>
                            <th>
                                <label for="">username در گاه Mellat</label>
                                <input type="text" class="form-control" name="mellat_username"
                                       value="{{Setting::get('mellat_username')}}">

                                <label>password در گاه Mellat</label>
                                <input type="text" class="form-control" name="mellat_password"
                                       value="{{Setting::get('mellat_password')}}">

                                <label>terminalID در گاه Mellat</label>
                                <input type="text" class="form-control" name="mellat_terminal_id"
                                       value="{{Setting::get('mellat_terminal_id')}}">
                            </th>
                        </tr>
                    @endif

                    </tbody>
                </table>
                <input type="submit" value="ثبت تنظیمات" class="btn btn-outline-success">
            </form>
        </div>
    </div>
</div>
