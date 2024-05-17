<div class="row mt-50 mb-0 full-width" style="background: #161e32">
    <div class="d-flex">
        @foreach($marketsSlider as $market)
            <div class="col-md-2 col-xs-6 border-1px pr-20 pl-20 pt-5"
                 style="border-color: #343d56 !important;display: inline-flex">
                <div>
                    <p class="text-white font-15 font-weight-bold">{{$market->symbol}}</p>
                    <p class="font-18 font-weight-bold">{{App\Helpers\Helper::numberFormatPrecision($market->price,$market->decimal)}}</p>
                    <p class="font-15 {{$market->percent >0 ? 'text-success':'text-danger'}}">{{$market->percent}} %</p>
                </div>
                <div>
                    <p style="color:#161e32">
                        @if (Setting::get('marketNameFa'))
                            {{$market->name}}
                        @else
                            {{$market->symbol}}
                        @endif
                    </p>
                    <img height="30" src="{{$market->chart_image}}">
                    <p style="color:#161e32 ">PRICE</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
