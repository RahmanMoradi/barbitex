@extends('layouts/fullLayoutMaster')

@section('title', 'ثبت نام')

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
                        @if (\Illuminate\Support\Facades\Request::is('auth/panel/validate/code'))
                            <div class="card rounded-0 mb-0 p-2">
                                <div class="card-header pt-50 pb-1">
                                    <div class="card-title">
                                        <h4 class="mb-0">ثبت کد ارسالی</h4>
                                    </div>
                                </div>
                                @if (Auth::user()->two_factor_type == 'google')
                                    <p class="px-2">کد تائید دو مرحله ای خود را وارد کنید</p>
                                @elseif (Auth::user()->two_factor_type == 'sms')
                                    <p class="px-2">کد ارسال شده به موبایل خود را وارد کنید</p>
                                @else()
                                    <p class="px-2">کد ارسال شده به ایمیل خود را وارد کنید</p>
                                @endif
                                <div class="card-content">
                                    <div class="card-body pt-0">
                                        <form method="POST"
                                              action="{{ route('register.validate') }}">
                                            @csrf
                                            <hr>
                                            <div class="form-label-group">
                                                <!-- <input type="text" id="inputName" class="form-control" placeholder="Name" required> -->
                                                <input id="code" type="text"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       name="code"
                                                       placeholder="{{Auth::user()->two_factor_type == 'google' ? 'کد ورود دو مرحله ای':'کد ارسال شده'}}"
                                                       value="{{ old('code') }}" required autocomplete="code" autofocus>
                                                <label
                                                    for="code">{{Auth::user()->two_factor_type == 'google' ?'کد تائید دو مرحله ای' : 'کد ارسال شده'}}</label>
                                                @error('code')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                            <hr>
                                            <button type="submit" class="btn btn-primary float-right btn-inline mb-50"
                                            >تائید
                                            </button>
                                            @if (\Illuminate\Support\Facades\Request::is('auth/panel/validate/code') && Auth::user()->two_factor_type != 'google')
                                                <a id="resendLink" href="javascript:void(0)" disabled="true"
                                                   onclick="resendCode()"
                                                   class="btn btn-danger">
                                                    <span id="timer"></span>
                                                </a>
                                                <hr>
                                            @endif
                                            <a href="{{route('logout')}}">تغییر اطلاعات ورود!</a>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        @else
                            <div class="card rounded-0 mb-0 p-2">
                                <div class="card-header pt-50 pb-1">
                                    <div class="card-title">
                                        <h4 class="mb-0">ثبت نام در سایت</h4>
                                    </div>
                                </div>
                                <p class="px-2">کلیه اطلاعات به صورت صحیح و کامل وارد شود.</p>
                                <div class="card-content">
                                    <div class="card-body pt-0">
                                        <form method="POST" action="{{ route('register.register') }}">
                                            @csrf
                                            @if (Setting::get('registerField') == 'mobile')
                                                <div class="form-label-group">
                                                    <input id="name" type="text"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           name="name"
                                                           placeholder="نام و نام خانوادگی" value="{{ old('name') }}"
                                                           required
                                                           autocomplete="name">
                                                    <label for="name">نام و نام خانوادگی</label>
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-label-group">
                                                    <input id="mobile" type="text"
                                                           class="form-control @error('mobile') is-invalid @enderror"
                                                           name="mobile"
                                                           placeholder="موبایل" value="{{ old('mobile') }}" required
                                                           autocomplete="mobile">
                                                    <label for="mobile">موبایل</label>
                                                    @error('mobile')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            @endif
                                            <div class="form-label-group">
                                                <input id="email" type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       name="email"
                                                       placeholder="ایمیل" value="{{ old('email') }}" required
                                                       autocomplete="email">
                                                <label for="email">ایمیل</label>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-label-group">
                                                <!-- <input type="password" id="inputPassword" class="form-control" placeholder="Password" required> -->
                                                <input id="password" type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       name="password" placeholder="رمز عبور" required
                                                       autocomplete="new-password">
                                                <label for="password">رمز عبور</label>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-label-group">
                                                <!-- <input type="password" id="inputConfPassword" class="form-control" placeholder="Confirm Password" required> -->
                                                <input id="password-confirm" type="password" class="form-control"
                                                       name="password_confirmation" placeholder="تکرار رمز عبور"
                                                       required
                                                       autocomplete="new-password">
                                                <label for="password-confirm">تکرار رمز عبور</label>
                                            </div>
                                            <div class="form-label-group">
                                                <!-- <input type="text" id="inputName" class="form-control" placeholder="Name" required> -->
                                                <input id="parent_id" type="text"
                                                       class="form-control @error('parent_id') is-invalid @enderror"
                                                       name="parent_id"
                                                       placeholder="کد معرف (اختیاری)"
                                                       value="{{ old('parent_id') ? : Request::get('ref') }}"
                                                       autocomplete="parent_id"
                                                       autofocus {{Request::get('ref') ? 'readonly' : ''}}>
                                                <label for="parent_id">کد معرف</label>
                                                @error('parent_id')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input type="checkbox" name="terms">
                                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                  <i class="vs-icon feather icon-check"></i>
                                                </span>
                                              </span>
                                                            <span
                                                                class=""> کلیه قوانین و مقررات این سایت را میپذیرم.</span>
                                                        </div>
                                                    </fieldset>
                                                    @error('terms')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <a href="/auth/panel/login"
                                               class="btn btn-outline-primary float-left btn-inline mb-50">قبلا
                                                ثبت نام کرده ام</a>
                                            <button type="submit" class="btn btn-primary float-right btn-inline mb-50">
                                                ثبت نام
                                            </button>
                                            @if (Setting::get('NOCAPTCHA_Active') == 1 && env('NOCAPTCHA_SECRET'))
                                                {!!  no_captcha()->input('g-recaptcha-response') !!}
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
