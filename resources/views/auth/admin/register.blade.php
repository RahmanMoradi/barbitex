@extends('layouts/fullLayoutMaster')

@section('title', 'ورود')

@section('mystyle')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset('css/pages/authentication.css') }}">
@endsection
@section('content')
    <section class="row flexbox-container justify-content-center">
        <div class="col-xl-12 col-12 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                        <a href="{{url('/')}}">خانه</a>
                        <hr>
                        <img src="{{ asset('images/pages/register.jpg') }}" alt="branding logo">
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        @if (\Illuminate\Support\Facades\Request::is('auth/admin/validate/code'))
                            <div class="card rounded-0 mb-0 p-2">
                                <div class="card-header pt-50 pb-1">
                                    <div class="card-title">
                                        <h4 class="mb-0">ثبت کد ارسالی</h4>
                                    </div>
                                </div>
                                @if (Auth::guard('admin')->user()->two_factor_type == 'google')
                                    <p class="px-2">کد تائید دو مرحله ای خود را وارد کنید</p>
                                @elseif (Auth::guard('admin')->user()->two_factor_type == 'sms')
                                    <p class="px-2">کد ارسال شده به موبایل خود را وارد کنید</p>
                                @else()
                                    <p class="px-2">کد ارسال شده به ایمیل خود را وارد کنید</p>
                                @endif
                                <div class="card-content">
                                    <div class="card-body pt-0">
                                        <form method="POST"
                                              action="{{ route('admin.register.validate') }}">
                                            @csrf
                                            <hr>
                                            <div class="form-label-group">
                                                <!-- <input type="text" id="inputName" class="form-control" placeholder="Name" required> -->
                                                <input id="code" type="text"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       name="code"
                                                       placeholder="{{Auth::guard('admin')->user()->two_factor_type == 'google' ? 'کد ورود دو مرحله ای':'کد ارسال شده'}}"
                                                       value="{{ old('code') }}" required autocomplete="code" autofocus>
                                                <label
                                                    for="code">{{Auth::guard('admin')->user()->two_factor_type == 'google' ?'کد تائید دو مرحله ای' : 'کد ارسال شده'}}</label>
                                                @error('code')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                            <hr>
                                            <button type="submit" class="btn btn-primary float-right btn-inline mb-50"
                                                    >تائید</button>
                                            @if (\Illuminate\Support\Facades\Request::is('auth/admin/validate/code'))
                                                <a id="resendLink" href="javascript:void(0)" disabled="true"
                                                   onclick="resendCode()"
                                                   class="btn btn-danger">
                                                    <span id="timer"></span>
                                                </a>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('myscript')
    @if (Setting::get('NOCAPTCHA_Active') == 1 && env('NOCAPTCHA_SECRET'))
        {!! no_captcha()->script() !!}
        {!! no_captcha()->getApiScript() !!}
        <script>
            grecaptcha.ready(() => {
                window.noCaptcha.render('register', (token) => {
                    document.querySelector('#g-recaptcha-response').value = token;
                });
            });
        </script>
    @endif
    <script>
        let time = 60;
        $('ready', function () {
            setInterval(myTimer, 1000)
        })

        function myTimer() {
            if (time != 0) {
                time--;
                document.getElementById("timer").innerHTML = "0:" + time;
            } else {
                $('#resendLink').removeClass('btn-danger')
                $('#resendLink').addClass('btn-success')
                document.getElementById("timer").innerHTML = 'ارسال مجدد';
            }
        }

        function resendCode() {
            if (time == 0) {
                location.reload()
            }
        }
    </script>
@endsection
