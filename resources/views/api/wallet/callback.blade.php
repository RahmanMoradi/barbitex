<!doctype html>
<html lang="en" dir="rtl">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>بازگشت به اپلیکیشن</title>
</head>
<body class="bg-dark">
@if ($wallet->status != 'done')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <p class="text-center text-danger">پرداخت با موفقیت انجام نشد</p>
                <a class="text-center btn btn-block btn-danger"
                   href="{{Setting::get('application.packageName')}}://type=wallet&id={{$wallet->id}}&code=0&message=پرداخت با موفقیت انجام نشد">بازگشت
                    به
                    اپلیکیشن</a>
            </div>
        </div>
    </div>
@else
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <p class="text-center text-success">پرداخت با موفقت انجام شد</p>
                <a class="text-center btn btn-block btn-success"
                   href="{{Setting::get('application.packageName')}}://type=wallet&id={{$wallet->id}}&code=1&message=پرداخت با موفقیت انجام شد">بازگشت
                    به اپلیکیشن</a>
            </div>
        </div>
    </div>
@endif
</body>
</html>
