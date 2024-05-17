<section class="inner-header divider parallax overlay-white-8">
    <div class="container pt-60 pb-60">
        <!-- Section Content -->
        <div class="section-content">
            <div class="row">
                <div class="diamond-line-centered-theme-colored2"></div>
                <div class="col-md-12 text-center table-responsive">
                    <table class="table table-striped table-hover text-right">
                        <thead>
                        <tr>
                            <th>نوع ارز</th>
                            <th></th>
                            <th>آخرین قیمت / دلار</th>
                            <th>آخرین قیمت / تومان</th>
                            <th>تغییرات</th>
                            @if (Setting::get('homeChart'))
                                <th>چارت</th>
                            @endif
                            <th>معامله</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($marketsList as $market)
                            <tr class="p-1">
                                <th>
                                    <img height="30" src="{{$market->iconUrl}}"
                                         alt="{{$market->symbol}}">
                                </th>
                                <th>
                                    @if (Setting::get('marketNameFa'))
                                        {{$market->name}} ({{$market->symbol}})
                                    @else
                                        {{$market->symbol}}
                                    @endif
                                </th>
                                <th>{{App\Helpers\Helper::formatAmountWithNoE($market->price,$market->decimal)}}$</th>
                                <th>
                                    <span>خرید از ما:</span>
                                    {{number_format($market->send_price,$market->decimal)}}
                                    تومان
                                    <br>
                                    <span>فروش به ما:</span>
                                    {{number_format($market->receive_price,$market->decimal)}}
                                    تومان
                                </th>
                                <th class="badge badge-pill {{$market->percent < 0 ? 'text-danger badge-danger' : 'text-success badge-success'}}">{{$market->percent}}
                                    %
                                </th>
                                @if (Setting::get('homeChart'))
                                    <td>
                                        <img height="30" src="{{$market->chart_image}}">
                                    </td>
                                @endif
                                <th>
                                    <a href="/panel" class="btn btn-default">معامله</a>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
