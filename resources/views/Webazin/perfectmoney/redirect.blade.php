@extends('layouts/contentLayoutMaster')

@section('title', 'خرید پرفکت مانی')

@section('vendor-style')

@endsection

@section('content')
    <form action="https://perfectmoney.com/api/step1.asp" id="form" method="POST">
        <input type="hidden" name="PAYEE_ACCOUNT" value="{{\App\Helpers\Helper::decrypt(config('webazin.perfectmoney.merchant_id'))}}">
        <input type="hidden" name="PAYEE_NAME" value="{{Setting::get('title')}}">
        <input type="hidden" name="PAYMENT_ID" value="{{$wallet->id}}"><br>
        <input type="hidden" name="PAYMENT_AMOUNT" value="{{number_format( $wallet->price , 2 , '.' , '' )}}"><br>
        <input type="hidden" name="PAYMENT_UNITS" value="USD">
        <input type="hidden" name="STATUS_URL" value="">
        <input type="hidden" name="PAYMENT_URL"
               value="{{url('panel.wallet.callback.perfectmoney',['hash'=> \App\Helpers\Helper::encrypt('success|'.$wallet->id)])}}">
        <input type="hidden" name="PAYMENT_URL_METHOD" value="LINK">
        <input type="hidden" name="NOPAYMENT_URL"
               value="{{route('panel.wallet.callback.perfectmoney',['hash'=> \App\Helpers\Helper::encrypt('fail|'.$wallet->id)])}}">
        <input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK">
        <input type="hidden" name="SUGGESTED_MEMO" value="">
        <input type="hidden" name="orderid" value="{{$wallet->id}}">
        <input type="hidden" name="BAGGAGE_FIELDS" value="orderid">
        <input type="submit" name="PAYMENT_METHOD" value="در حال انتقال....">
    </form>
@endsection
@section('myscript')
    <script>
        $('#form').submit()
    </script>
@endsection



