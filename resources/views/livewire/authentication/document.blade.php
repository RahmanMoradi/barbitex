<div>
    @if (!Auth::user()->isActive())
        <div class="alert alert-danger m-1 text-center alert-icon-left alert-dismissible" role="alert">
                            <span class="alert-icon">
                                <i class="feather icon-user"></i>
                            </span>
            اکانت شما بصورت کامل احراز هویت نشده است و لطفا همه اطلاعات را تکمیل نمایید
            <br>
            درصورتی مدارک خود را ارسال کرده اید منتظر بررسی اپراتور بمانید
        </div>
    @endif
    @if(!Auth::user()->hasVerifiedMobile())
        <div class="card-body ">
            <div class="col-lg-4 col-md-6 col-sm-8 mx-auto p-0">
                @if ($send == 0)
                    <form wire:submit.prevent="sendSms">
                        <div class="col-md-12 form-group p-0">
                            <label>موبایل</label>
                            <input type="text" class="form-control round numbers text-center"
                                   wire:model="mobile" required>
                        </div>
                        <div class="col-md-12 m-auto text-center">
                            <button type="submit"
                                    class="btn btn-primary round px-3 waves-effect waves-light">ارسال کد
                            </button>
                        </div>
                    </form>
                @else
                    <form wire:submit.prevent="ValidateSms">
                        <div class="col-md-12 form-group p-0">
                            <label>کد</label>
                            <input type="text" class="form-control round numbers text-center"
                                   wire:model="code" required>
                        </div>
                        <div class="col-md-12 m-auto text-center">
                            <button type="submit"
                                    class="btn btn-primary round px-3 waves-effect waves-light">تائید کد
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @elseif(!Auth::user()->hasVerifiedEmail())
            <div class="card-body ">
                <div class="col-lg-4 col-md-6 col-sm-8 mx-auto p-0">
                    @if ($send == 0)
                        <form wire:submit.prevent="sendEmail">
                            <div class="col-md-12 form-group p-0">
                                <label>ایمیل</label>
                                <input type="text" class="form-control round numbers text-center"
                                       wire:model="email" required>
                            </div>
                            <div class="col-md-12 m-auto text-center">
                                <button type="submit"
                                        class="btn btn-primary round px-3 waves-effect waves-light">ارسال کد
                                </button>
                            </div>
                        </form>
                    @else
                        <form wire:submit.prevent="ValidateEmail">
                            <div class="col-md-12 form-group p-0">
                                <label>کد</label>
                                <input type="text" class="form-control round numbers text-center"
                                       wire:model="code" required>
                            </div>
                            <div class="col-md-12 m-auto text-center">
                                <button type="submit"
                                        class="btn btn-primary round px-3 waves-effect waves-light">تائید کد
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
    @else
        <div class="card-body ">
            <p class="mt-1">
                احراز هویت در {{Setting::get('title')}} بسیار ساده و سریع میباشد و فقط یک بخش دارد که ارسال
                تصویر سلفی به همراه مدارک شناسایی میباشد که در این مرحله مدراک شما باید توسط پشتیبانی
                تایید گردد که در کمترین زمان ممکن این کار انجام میشود.
            </p>
            <form id="nationalCard" class="form-horizontal needs-validation mt-2"
                  wire:submit.prevent="store">
                @csrf
                <hr>
                <div class="">
                    <div class="font-medium-1 mb-0">
                        1. ثبت تصویر مدارک
                    </div>
                    <hr>
                    <p>متن قرارداد:</p>
                    {!! Setting::get('authText') !!}
                    <hr>
                    <p class=" text-center">
                        <a class="badge badge-lg badge-warning"
                           href="{{asset(Setting::get('authImage'))}}"
                           target="_blank"
                           data-lightbox="image-1" data-title="نمونه تصویر مدارک شناسایی">
                            نمایش نمونه تصویر
                        </a>
                    </p>
                    <div class="col-lg-4 col-md-6 col-sm-8 mx-auto p-0">
                        <div class="col-md-12 form-group p-0">
                            <label>نام و نام خانوادگی</label>
                            <input type="text" class="form-control round numbers text-center"
                                   wire:model="name" required>
                        </div>
                        <div class="col-md-12 form-group p-0">
                            <label>موبایل</label>
                            <input type="text" class="form-control round numbers text-center"
                                   wire:model="mobile" required readonly>
                        </div>
                        <div class="col-md-12 form-group p-0">
                            <label>کد ملی</label>
                            <input type="text" class="form-control round numbers text-center ltr-dir"
                                   id="national_code" name="national_code" required=""
                                   wire:model="national_code">
                        </div>
                        <div class="col-md-12 form-group p-0">
                            <small>{{$birthday}}</small>
                            <label>تاریخ تولد <small>(هجده سال به بالا امکان ثبت وجود
                                    دارد)</small></label>
                            <div class="input-group">
                                <input type="hidden" id="dataHide" wire:model="birthday">
                                <input type="text"
                                       class="form-control round ltr-dir text-center font-small-3 px-0 pwt-datepicker-input-element"
                                       id="DateBirth" placeholder="تاریخ" name="birthday" required="" wire:ignore>
                                <div
                                    class="input-group-append cursor-pointer pwt-datepicker-input-element" wire:ignore
                                    id="date1" data-date="{{$birthday}}">
                                                    <span class="input-group-text badge-primary round px-1"><i
                                                            class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    @if (Auth::user()->docs && Auth::user()->docs->status == 'accept' )
                        <div class="text-center">
                            <span class="badge badge-success">تائید شده</span>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-12 mx-auto form-group mb-1">
                                <img src="{{asset(Auth::user()->docs->title)}}" width="100%">
                            </div>
                        </div>
                    @elseif(Auth::user()->docs && Auth::user()->docs->status == 'new')
                        <div class="text-center">
                            <span class="badge badge-info">در حال بررسی</span>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-12 mx-auto form-group mb-1">
                                <img src="{{asset(Auth::user()->docs->title)}}" width="100%">
                            </div>
                        </div>
                    @else
                        <div class="row" wire:ignore>
                            <div class="col-md-8 col-12 mx-auto form-group mb-1">
                                <label class="font-small-2">با کلیک بر روی باکس زیر تصویر را آپلود و یا
                                    تصویر را بر روی باکس زیر درگ(بکشید و بندازید) کنید</label>
                                <input type="file" id="auth_img" name="doc" wire:model="docs" accept="image/*"
                                       class="dropify" data-allowed-file-extensions="jpg jpeg png"
                                       required="">
                            </div>
                        </div>
                        <div class="progress progress-lg  w-100" style="display:none ">
                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                 role="progressbar" aria-valuemax="100" style="width:0%">
                                0%
                            </div>
                        </div>
                        <div class="col-md-12 m-auto text-center">
                            <button type="submit"
                                    class="btn btn-primary round px-3 waves-effect waves-light"
                                    wire:click="$set('birthday',$('#DateBirth').val())" wire:loading.attr="disabled"
                                    wire:target="docs">ارسال تصویر
                            </button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    @endif
</div>

