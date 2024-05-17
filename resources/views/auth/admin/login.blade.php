@extends('layouts/fullLayoutMaster')

@section('title', 'ورود')

@section('mystyle')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset('css/pages/authentication.css') }}">
@endsection

@section('content')
    <section class="row flexbox-container justify-content-center">
        <div class="col-xl-8 col-11  justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                        <a href="{{url('/')}}">خانه</a>
                        <hr>
                        <img src="{{asset('images/pages/login.png')}}" alt="{{asset(Setting::get('title'))}}">
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        @if (Request::is('panel/ForgetPassword'))

                            @if (Request::has('code'))
                                <div class="card rounded-0 mb-0 px-0 px-md-2">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0"><i class="feather icon-user-check"></i> فراموشی روز عبور
                                            </h4>
                                        </div>
                                    </div>
                                    <p class="px-2">خوش آمدید، لطفا کد را درج کنید</p>
                                    <div class="card-content">
                                        <div class="card-body pt-1">
                                            <form class="needs-validation" action="{{route('ForgetPassword.post')}}"
                                                  novalidate
                                                  method="POST" autocomplete="off">
                                                @csrf
                                                <input type="hidden" name="mobile" value="{{Request::query('mobile')}}">
                                                <input type="hidden" name="level" value="2">
                                                <fieldset
                                                    class="form-label-group form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control ltr text-center numbers"
                                                           id="code"
                                                           maxlength="4" minlength="4" name="code"
                                                           placeholder="کد ارسال شده"
                                                           required value="{{old('code')}}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                    <label for="user-name">کد</label>
                                                    <div class="invalid-feedback">
                                                        کد را بدرستی درج کنید
                                                    </div>
                                                </fieldset>

                                                <fieldset
                                                    class="form-label-group form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control ltr text-center numbers"
                                                           id="password"
                                                           name="password"
                                                           placeholder="رمز عبور"
                                                           required value="{{old('password')}}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                    <label for="user-name">رمز عبور</label>
                                                </fieldset>

                                                <fieldset
                                                    class="form-label-group form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control ltr text-center numbers"
                                                           id="password_confirmation"
                                                           name="password_confirmation"
                                                           placeholder="تکرار رمز عبور"
                                                           required value="{{old('password_confirmation')}}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                    <label for="user-name">تکرار رمز عبور</label>
                                                </fieldset>

                                                <a href="{{route('register')}}"
                                                   class="btn btn-outline-primary float-left btn-inline waves-effect waves-light">ثبت
                                                    نام</a>
                                                <button type="submit"
                                                        class="btn btn-primary float-right btn-inline g-recaptcha waves-effect waves-light">
                                                    تغییر رمز
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="login-footer">
                                        <div class="divider">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card rounded-0 mb-0 px-0 px-md-2">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0"><i class="feather icon-user-check"></i> فراموشی روز عبور
                                            </h4>
                                        </div>
                                    </div>
                                    <p class="px-2">خوش آمدید، لطفا شماره موبایل خود را درج کنید</p>
                                    <div class="card-content">
                                        <div class="card-body pt-1">
                                            <form class="needs-validation" action="{{route('ForgetPassword.post')}}"
                                                  novalidate
                                                  method="POST" autocomplete="off">
                                                @csrf
                                                <fieldset
                                                    class="form-label-group form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control ltr text-center numbers"
                                                           id="mobile"
                                                           maxlength="18" minlength="18" name="mobile"
                                                           placeholder="موبایل"
                                                           required value="{{old('mobile')}}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                    <label for="user-name">موبایل</label>
                                                    <div class="invalid-feedback">
                                                        شماره موبایل را بدرستی درج کنید
                                                    </div>
                                                </fieldset>

                                                <a href="{{route('register')}}"
                                                   class="btn btn-outline-primary float-left btn-inline waves-effect waves-light">ثبت
                                                    نام</a>
                                                <button type="submit"
                                                        class="btn btn-primary float-right btn-inline g-recaptcha waves-effect waves-light">
                                                    ارسال کد
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="login-footer">
                                        <div class="divider">
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @else
                            <div class="card rounded-0 mb-0 px-0 px-md-2">
                                <div class="card-header pb-1">
                                    <div class="card-title">
                                        <h4 class="mb-0"><i class="feather icon-user-check"></i> ورود</h4>
                                    </div>
                                </div>
                                <p class="px-2">خوش آمدید، لطفا شماره موبایل و کلمه عبور خود را درج کنید</p>
                                <div class="card-content">
                                    <div class="card-body pt-1">
                                        <form action="{{route('admin.login.login')}}"
                                              method="POST">
                                            @csrf
                                            <fieldset
                                                class="form-label-group form-group position-relative has-icon-left">
                                                <input type="email" class="form-control ltr text-center"
                                                       id="email"
                                                       name="email" placeholder="ایمیل"
                                                       required value="{{old('email')}}">
                                                <div class="form-control-position">
                                                    <i class="feather icon-user"></i>
                                                </div>
                                                <label for="email">ایمیل</label>
                                            </fieldset>

                                            <fieldset class="form-label-group position-relative has-icon-left">
                                                <input type="password" class="form-control ltr text-center"
                                                       id="password"
                                                       minlength="6" name="password" placeholder="کلمه عبور"
                                                       required="">
                                                <div class="form-control-position">
                                                    <i class="feather icon-lock"></i>
                                                </div>
                                                <label for="user-password">کلمه عبور</label>
                                                <div class="invalid-feedback">
                                                    کلمه عبور حداقل 6 کاراکتر درج شود
                                                </div>
                                            </fieldset>
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <div class="text-left">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input type="checkbox" id="remember" name="remember">
                                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                  <i class="vs-icon feather icon-check"></i>
                                                </span>
                                              </span>
                                                            <span class="">مرا بخاطر بسپار</span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <button type="submit"
                                                    class="btn btn-primary float-left btn-inline waves-effect waves-light">
                                                ورود
                                            </button>
                                            @if (Setting::get('NOCAPTCHA_Active') == 1 && env('NOCAPTCHA_SECRET'))
                                                {!!  no_captcha()->input('g-recaptcha-response') !!}
                                            @endif
                                        </form>
                                    </div>
                                </div>
                                <div class="login-footer">
                                    <div class="divider">
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
        <script src="{{ asset('js/scripts/auth/login.js') }}"></script>
        {!! no_captcha()->script() !!}
        {!! no_captcha()->getApiScript() !!}
        <script>
            grecaptcha.ready(() => {
                window.noCaptcha.render('login', (token) => {
                    document.querySelector('#g-recaptcha-response').value = token;
                });
            });
        </script>
    @endif
@endsection
