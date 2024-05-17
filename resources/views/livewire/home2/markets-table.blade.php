<div>
    <section>
        <div class="container">
            <div class="row medium-padding120">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="mCustomScrollbar scrollable-responsive-table" data-mcs-theme="dark">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام</th>
                                <th>قیمت (تومان)</th>
                                <th>قیمت (دلار)</th>
                                <th>نوسان قیمت</th>
                                <th>چارت</th>
                                <th class="d-sm-none">
                                    <input type="text" placeholder="جستجو کنید..." class="form-control round form-control-sm" wire:model.lazy="filter" style="background: transparent;height: 10px;">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($marketsTable as $market)
                                <tr class="crumina-module crumina-pricing-table pricing-table--style-table-blurring c-border-color">
                                    <td>
                                        {{$loop->index + 1}}
                                    </td>
                                    <td>
                                        <div class="pricing-thumb">
                                            <img src="{{$market->iconUrl}}"
                                                 class="woox-icon" alt="{{$market->symbol}}">
                                            <h6 class="pricing-title">{{$market->symbol}}
                                                <span>{{$market->name}}</span></h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="currency-details-item">
                                            <div class="value">{{number_format($market->irt_price,0)}}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="currency-details-item">
                                            <div class="value c-primary">${{$market->price}}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            class="currency-details-item"
                                            style="box-shadow: 0px 0px 17px 0px var(--box-shadow-color);
                                                --box-shadow-color: {{$market->percent <0 ? '#a93232' : '#9adfa6'}};
                                                border-radius: 10px">
                                            <div
                                                class="value text-center  alert {{$market->percent < 0 ? 'c-red-light' : 'c-green-succes'}}"
                                                style="padding: 1px; margin: 0;justify-content: center;direction: ltr">
                                                {{$market->percent}}
                                                %
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="currency-details-item">
                                            <div class="value">
                                                <img height="30" src="{{$market->chart_image}}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-sm-none">
                                        <a href="/panel"
                                           class="btn btn--small btn--green-light"
                                           style="font-weight: 500;"
                                        >خرید / فروش</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="8">
                                    {{$marketsTable->links()}}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <hr class="divider">
        </div>
    </section>
</div>
