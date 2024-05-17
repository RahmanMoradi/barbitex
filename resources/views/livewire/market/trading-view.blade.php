<div>
    <!-- TradingView Widget END -->
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <script type="text/javascript">
        new TradingView.widget(
            {
                "width": "100%",
                "height": 390,
                "symbol": "{{strtoupper($market)}}:{{str_replace('-','',$symbol)}}",
                "interval": "D",
                "timezone": "Asia/Tehran",
                "theme": "{{Auth::check() ? Auth::user()->theme : 'dark'}}",
                {{--"theme" : {--}}
                    {{--    theme: "{{Auth::check() ? Auth::user()->theme : 'light'}}",--}}
                    {{--    bg: '#ffffff',--}}
                    {{--    front: '#2AA3A3',--}}
                    {{--    candleUp: '#229e6b',--}}
                    {{--    candleDown: '#ef055c',--}}
                    {{--    gridColor: '#DFDFDF',--}}
                    {{--    crossHair: '#999999',--}}
                    {{--    textColor: '#31353F',--}}
                    {{--    lineColor: '#DFDFDF'--}}
                    {{--},--}}
                "hide_legend": true,
                "style": "1",
                "locale": "fa_IR",
                "toolbar_bg": "#414561",
                "enable_publishing": false,
                "withdateranges": false,
                "hide_side_toolbar": false,
                "allow_symbol_change": false,
                "studies": [
                    "Volume@tv-basicstudies"
                ],
                "container_id": "tradingview_{{$symbol}}"
            }
        );
    </script>
</div>
