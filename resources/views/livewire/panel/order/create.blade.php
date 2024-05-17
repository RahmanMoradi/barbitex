<div>
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="#" wire:click.prevent="changeType('buy')">
                <div class="card {{$type == 'buy' ? 'bg-primary box-shadow-2':''}}">
                    <div class="card-body d-flex">
                        <div class="align-self-top {{$type == 'buy' ? 'text-white':'text-primary'}}">
                            <i class="feather icon-trending-down icon-opacity font-large-2"></i>
                        </div>
                        <div class="media-body {{$type == 'buy' ? 'text-white':'text-primary'}} text-center mt-1">
                            <span class="d-block mb-1 font-medium-1">خرید </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="#" wire:click.prevent="changeType('sell')">
                <div class="card {{$type == 'sell' ? 'bg-primary box-shadow-2':''}}">
                    <div class="card-body d-flex">
                        <div class="media-body {{$type == 'sell' ? 'text-white':'text-primary'}} text-center mt-1">
                            <span class="d-block mb-1 font-medium-1">فروش </span>
                        </div>
                        <div class="align-self-top {{$type == 'sell' ? 'text-white':'text-primary'}}">
                            <i class="feather icon-trending-up icon-opacity font-large-2"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @if ($market)
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="#chart" >
                    <div class="card">
                        <div class="card-body d-flex">
                            <div class="media-body text-primary text-center mt-1">
                                <span class="d-block mb-1 font-medium-1">چارت </span>
                            </div>
                            <div class="align-self-top text-primary">
                                <i class="feather icon-bar-chart icon-opacity font-large-2"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>
    <div class="row mb-4" wire:loading.class="blur" wire:target="changeType">
        <div class="col-md-6 mb-4">
            <div class="card o-hidden">
                <div id="coinCalculatorPSVouchers" class="card-body">
                    <div class="card-title m-0 mb-1">
                        <i class="feather icon-trending-down"></i>
                        {{$type == 'buy' ? 'خرید' : 'فروش'}}
                    </div>
                    <div class="primary border-primary text-center font-medium-1 p-2">
                        مبلغ پرداختی: {{number_format(intval(preg_replace('/[^\d. ]/', '', $this->price)))}}
                        <span>

                            </span>
                        <small> تومان</small>
                    </div>
                    <div class="details-section-floated">
                        <div>
                            <span>هر واحد {{$currency->name}}</span>
                            <span class="float-right">
                                @if ($currency->send_price < 1)
                                    {{$type == 'buy' ? $currency->send_price : $currency->receive_price}}
                                @else
                                    {{number_format($type == 'buy' ? $currency->send_price : $currency->receive_price)}}
                                @endif
                                     تومان
                                    </span>
                        </div>

                        <div>
                            <span>حداقل {{$type == 'buy' ? 'خرید' : 'فروش'}}</span>
                            <span
                                class="float-right">
                                        {{number_format(Setting::get("min_buy"))}} تومان یا حداقل شبکه
                                    </span>
                        </div>

                    </div>
                    <form novalidate="novalidate" action="" autocomplete="off" method="post"
                          class="mt-2 needs-validation" id="form">
                        <div class="input-double mb-1">
                            <label>مقدار</label>
                            <div class="grouped">
                                <a href="#" id="btnCurrencyModal" data-toggle="modal"
                                   data-target="#modal_currencies">
                                    <img src="{{$currency->iconUrl}}">
                                </a>
                                <input id="coin" autocomplete="off"
                                       wire:model.debounce.1500ms="qty"
                                       maxlength="10" required="required"
                                       class="form-control round text-center ltr-dir sans-serif">
                                <span>{{$currency->name}}</span>
                            </div>

                            <div class="grouped">
                                <img src="/images/iran.svg" alt="تومان">
                                <input id="price" name="price" maxlength="12"
                                       wire:model.debounce.1500ms="price"
                                       required="required"
                                       class="form-control round text-center ltr-dir sans-serif">
                                <span>تومان</span>
                            </div>
                            <small class="text-center col-12">مبلغ را به تومان نیز می توانید مشخص
                                نمایید.</small>
                            <a href="#" class="btn btn-sm btn-success" wire:click.prevent="max"
                               wire:loading.class="blur" wire:target="max">
                                @if ($type == 'buy')
                                    {{number_format($balance)}}
                                @else
                                    {{\App\Helpers\Helper::numberFormatPrecision($balance,$currency->decimal)}}
                                @endif
                                کل موجودی
                            </a>
                            <br>
                            @if($price && intval(preg_replace('/[^\d. ]/', '', $price) < $minPrice))
                                <small class="text-danger col-12">مبلغ وارد شده کمتر از حداقل مجاز است.!</small>
                            @endif
                        </div>
                        <hr>
                        <div class="col-md-6 m-auto">
                            <a href="javascript:void(0)" wire:click.prevent="submit" wire:loading.attr="disabled"
                               wire:target="submit"
                               class="btn btn-primary round btn-block waves-effect waves-light">
                                <span wire:loading.inline wire:target="submit">در حال پردازش...</span>
                                <span wire:loading.remove wire:target="submit">ثبت سفارش</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card o-hidden">
                <div class="card-body">
                    <div class="card-title mb-1 pb-1 border-bottom">
                        <i class="feather icon-info"></i>
                        نکات و هشدارها
                    </div>
                    <div class="text-14 mb-md-5">
                        <p>
                            قیمت فعلی {{$currency->name }} در حال
                            حاظر
                            <span class="{{$currency->percent > 0 ? 'text-success' : 'text-danger'}}">
                                @if ($currency->send_price < 1)
                                    {{$type == 'buy' ? $currency->send_price : $currency->receive_price}}
                                @else
                                    {{number_format($type == 'buy' ? $currency->send_price : $currency->receive_price)}}
                                @endif
                                    تومان
                                </span>
                            می باشد که نسبت به قیمت روز گذشته خود
                            <span class="{{$currency->percent > 0 ? 'text-success' : 'text-danger'}}">
                                {{$currency->percent}} %
                                </span>
                            تغییر داشته است
                        </p>
                        <hr>
                        <p>مبالغ درج شده در فرم روبرو به تومان می باشد.</p>
                        <p>به دلیل نوسان زیاد قیمت ها پس از نهایی شدن فرم مبالغ مجدد محاسبه میگردد.</p>
                    </div>
                </div>
            </div>
        </div>
        @if ($market)
            <div class="col-md-12" id="chart">
                <livewire:market.trading-view :market="$market->market" :symbol="$market->symbol"/>
            </div>
        @endif
    </div>
    <div id="modal_currencies" tabindex="-1" role="dialog" aria-labelledby="currenciesModalLabel"
         wire:ignore.self
         aria-hidden="true"
         class="modal fade">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="currenciesModalLabel" class="modal-title">انتخاب ارز</h5>
                    <button id="closeBtn" type="button" data-dismiss="modal" aria-label="بستن"
                            class="close closeModal"><span
                            aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table dataTable table-bordered table-hover">
                        <thead>
                        <input type="text" class="form-control rounded form-control-sm col-4" wire:model.lazy="search">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($currencies as $currency)
                            <tr class="cursor-pointer" wire:click.prevent="changeCurrency({{$loop->index}})"
                                wire:loading.class="blur"
                                wire:target="changeCurrency">
                                <td>
                                    <img height="32" src="{{$currency->iconUrl}}">
                                </td>
                                <td>
                                    {{$currency->name}}
                                </td>
                                <td>
                                    {{$currency->symbol}}
                                </td>
                                <td>
                                    <span class="badge badge-primary badge-pill">انتخاب کنید</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    {{$currencies->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

