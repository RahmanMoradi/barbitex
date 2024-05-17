@extends('layouts/contentLayoutMaster')

@section('title', 'احراز هویت')

@section('mystyle')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset('css/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" href="{{asset('vendors/css/dropify/dropy.css')}}">
    <link type="text/css" rel="stylesheet"
          href="https://unpkg.com/persian-datepicker@latest/dist/css/persian-datepicker.min.css"/>

    <style>
        .dropify-filename-inner {
            display: none
        }

        audio {
            width: 100%;
            outline: none;
        }
    </style>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-3 mb-2 p-md-0 d-none d-md-block">
            <div class="card o-hidden">

                <div class="card-body p-md-0">
                    <div class="card-body text-center">
                        <div class="mb-2 mx-auto rounded-circle w-60">
                            <div class="avatar bg-primary m-0">
                                <div class="avatar-content" style="width: 100px; height: 100px">
                                    <i class="feather icon-user font-large-4"></i>
                                </div>
                            </div>
                        </div>
                        <h5 class="m-0">{{Auth::user()->name}}</h5>
                        <p class="mt-0">{{Auth::user()->mobile}}</p>
                        <hr>

                        <div class="list-group mt-2 text-left menu-profile">
                            <a href="{{url('/panel/authentication/profile')}}"
                               class="list-group-item list-group-item-action {{Request::is('panel/authentication/profile') ? 'active' : ''}}">
                                <i class="ft-user mr-1"></i>
                                اطلاعات و احراز هویت
                            </a>
                            <a href="{{url('/panel/authentication/card')}}"
                               class="list-group-item list-group-item-action {{Request::is('panel/authentication/card') ? 'active' : ''}}">
                                <i class="ft-credit-card mr-1"></i>
                                کارت های بانکی
                            </a>
                            <a href="{{url('/panel/authentication/password')}}"
                               class="list-group-item list-group-item-action {{Request::is('panel/authentication/password') ? 'active' : ''}}">
                                <i class="ft-lock mr-1"></i>
                                کلمه عبور
                            </a>
                            <a href="{{url('/panel/authentication/two-factor-authentication')}}"
                               class="list-group-item list-group-item-action {{Request::is('panel/authentication/two-factor-authentication') ? 'active' : ''}}">
                                <i class="ft-flag mr-1"></i>
                                ورود دو مرحله ای
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 mb-2">

            <div class="card o-hidden">
                @if (Request::is('panel/authentication/card'))
                    <livewire:authentication.card/>
                @elseif(Request::is('panel/authentication/profile'))
                    <livewire:authentication.document/>
                @elseif (Request::is('panel/authentication/password'))
                    <livewire:authentication.password/>
                @elseif('panel/authentication/two-factor-authentication')
                    <livewire:authentication.two-factor/>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
    <!-- vednor files -->
    <script src="{{ asset('vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
@endsection
@section('myscript')
    <!-- Page js files -->
    <script src="{{ asset('js/scripts/forms/validation/form-validation.js') }}"></script>
    <script src="{{asset('vendors/js/dropy/dropy.js')}}"></script>

    <script type="text/javascript" src="https://unpkg.com/persian-date@latest/dist/persian-date.min.js"></script>
    <script type="text/javascript"
            src="https://unpkg.com/persian-datepicker@latest/dist/js/persian-datepicker.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('.dropify').dropify({
                messages: {
                    'default': 'عکس را بکشید و رها کنید',
                    'replace': 'عکس را جایگزین کنید',
                    'remove': 'حذف',
                    'error': 'خطایی رخ داد.'
                }
            });

            $('#DateBirth,#date1').attr('data-date', new persianDate().subtract('year', 20).format('YYYY/MM/DD'));
            $('#date1,#DateBirth').persianDatepicker({
                altField: '#DateBirth',
                initialValueType: 'persian',
                maxDate: new persianDate().subtract('year', 18).valueOf(),
                altFormat: 'YYYY/MM/DD',
                initialValue: false,
                viewMode: 'year',
                observer: true,
                autoClose: true,
                format: 'YYYY/MM/DD',
                toolbox: {
                    enabled: false,
                },
                timePicker: {
                    enabled: false,
                    second: {
                        enabled: false,
                    }
                }
            });
        });
        let log = console.log.bind(console),
            id = val => document.getElementById(val),
            ul = id('ul'),
            gUMbtn = id('gUMbtn'),
            start = id('start'),
            stop = id('stop'),
            stream,
            recorder,
            counter = 1,
            chunks,
            media;

        if ($('#gUMbtn').length > 0) {
            gUMbtn.onclick = e => {
                let mv = id('mediaVideo'),
                    mediaOptions = {
                        video: {
                            tag: 'video',
                            type: 'video/webm',
                            ext: '.mp4',
                            gUM: {video: true, audio: true}
                        },
                        audio: {
                            tag: 'audio',
                            type: 'audio/mp3',
                            ext: '.mp3',
                            gUM: {audio: true}
                        }
                    };
                media = mv.checked ? mediaOptions.video : mediaOptions.audio;
                navigator.mediaDevices.getUserMedia(media.gUM).then(_stream => {
                    stream = _stream;
                    id('gUMArea').style.display = 'none';
                    id('btns').style.display = 'inherit';
                    start.removeAttribute('disabled');
                    recorder = new MediaRecorder(stream);
                    recorder.ondataavailable = e => {
                        chunks.push(e.data);
                        if (recorder.state == 'inactive') makeLink();
                    };
                    $('#toast-container').html('');
                    toastr.success('دسترسی به میکروفن با موفقیت اعمال شد', "انجام شد!", {
                        positionClass: "toast-bottom-center",
                        progressBar: !0,
                    })
                }).catch(
                    toastr.warning('اجازه دسترسی به میکروفن را بدهید', "خطا!", {
                        positionClass: "toast-bottom-center",
                        progressBar: !0,
                    })
                );
            }
        }

        var timer;

        if ($('#start').length > 0 && $('#stop').length > 0) {
            start.onclick = e => {
                $('#ul').html('');
                start.disabled = true;
                start.style.display = 'none';
                stop.style.display = 'inherit';
                stop.removeAttribute('disabled');
                chunks = [];
                recorder.start();

                var i = 1;
                $('#timerBox').fadeIn();
                timer = setInterval(function () {
                    $('#timer').html(timecode(i * 1000));
                    i++;
                }, 1000);
            }


            stop.onclick = e => {
                clearInterval(timer);
                $('#timerBox').fadeOut(0);
                $('#timer').html('0:00');
                stop.disabled = true;
                stop.style.display = 'none';
                start.style.display = 'inherit';
                recorder.stop();
                start.removeAttribute('disabled');
            }
        }


        let blob

        function makeLink() {
            blob = new Blob(chunks, {type: media.type})
                , url = URL.createObjectURL(blob)
                , li = document.createElement('li')
                , mt = document.createElement(media.tag)
                , hf = document.createElement('a')
            ;
            mt.controls = true;
            mt.src = url;
            hf.href = url;
        }
        //hf.down…
    </script>
@endsection
