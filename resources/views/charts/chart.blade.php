<!doctype html>
<html lang="en" style="height: 100%; width: 100%">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$market->symbol}} Trading View</title>
</head>
<body style="height: 100%; width: 100%;margin: 0">
<div class="tradingview-widget-container">
    <div id="tradingview_a06b2"></div>
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <script type="text/javascript">
        new TradingView.widget(
            {
                "width": '100%',
                "height": '100%',
                "symbol": "{{strtoupper($market->market)}}:{{str_replace('-','',$market->symbol)}}",
                "interval": "D",
                "timezone": "Asia/Tehran",
                "theme": "dark",
                "hide_legend": true,
                "style": "1",
                "locale": "fa_IR",
                "toolbar_bg": "#f1f3f6",
                "enable_publishing": false,
                "withdateranges": false,
                "hide_side_toolbar": false,
                "allow_symbol_change": false,
                "studies": [
                    "Volume@tv-basicstudies"
                ],
                "container_id": "tradingview_a06b2"
            }
        );
    </script>
</div>
</body>
</html>

