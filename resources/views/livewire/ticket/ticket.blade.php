<div>
    <div class="content-header row">
        <div class="content-header-left col-md-12  col-12 mb-0">
            <h4 class="content-header-title">موضوع درخواست:
                <span class="font-medium-1">{{$ticket->subject}}</span>
            </h4>
            <p class="font-small-2 text-muted">در صورت نیاز میتوانید فایل خود را پیوست کنید.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="card card-icon mb-2">
                <div class="card-body text-center">
                    <i class="feather icon-calendar icon-opacity warning font-large-2"></i>
                    <p class="text-muted mt-2 mb-1">تاریخ ایجاد</p>
                    <p class="text-primary text-17 line-height-1 m-0" dir="ltr">{{$ticket->created_at}}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="card card-icon mb-2">
                <div class="card-body text-center pb-1">
                    <i class="feather icon-star icon-opacity primary font-large-2"></i>
                    <p class="text-muted mt-2 mb-1">وضعیت</p>
                    <span
                        class="badge badge-pill badge-{{$ticket->status_class}} font-weight-light">{{$ticket->status_fa}}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="card card-icon mb-2">
                <div class="card-body text-center">
                    <i class="feather icon-clock icon-opacity danger font-large-2"></i>
                    <p class="text-muted mt-2 mb-1">آخرین بروزرسانی</p>
                    <p class="text-primary text-17 line-height-1 m-0" dir="ltr">{{$ticket->updated_at}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="card card-icon mb-2 ">
                <div class="card-body text-center">
                    <i class="feather icon-message-circle icon-opacity info font-large-2"></i>
                    <p class="text-muted mt-2 mb-1">تعداد پیام ها</p>
                    <p class="text-primary line-height-1 m-0">{{$ticket->answers->count()}}</p>
                </div>
            </div>
        </div>
    </div>

    <section class="chat-app-window">
        <div class="active-chat">
            <div class="chat_navbar border">
                <header class="chat_header d-flex justify-content-between align-items-center p-1">
                    <div class="vs-con-items d-flex align-items-center">
                        <div class="sidebar-toggle d-block d-lg-none mr-1"><i
                                class="feather icon-menu font-large-1"></i></div>
                        <div class="avatar user-profile-toggle m-0 m-0 mr-1">
                            <svg height="40" width="40">
                                <text x="65%" y="50%"
                                      style="font-family: IRANSans;font-size: 15px;font-weight: bold;fill: white">
                                    {{mb_substr(Auth::user()->name,0,2,'utf-8')}}
                                </text>
                            </svg>
                        </div>
                        <h6 class="mb-0">{{Auth::user()->name}}</h6>
                    </div>
                    <div class="float-left">
                        <a wire:click="close"
                           class="btn btn-outline-danger">
                            <i class="fa fa-close"></i>
                            بستن
                        </a>
                    </div>
                </header>
            </div>
            <div class="user-chats ps ps--active-y" id="chats" style="overflow-y: scroll !important;">
                <div class="chats">
                    @if($ticket->role == 'admin')
                        <div class="chat">
                            <div class="chat-avatar">
                                <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left"
                                   title=""
                                   data-original-title="">
                                    <img src="{{ asset(Setting::get('logo')) }}" alt="{{Setting::get('title')}}"
                                         height="40"
                                         width="40"/>
                                </a>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>
                                        {!! $ticket->message !!}
                                    </p>
                                    @if ($ticket->file)
                                        <hr>
                                        <span class="text-bold">فایل: </span><a target="_blank"
                                                                                href="{{asset($ticket->file)}}"><i
                                                class="feather icon-download"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="chat chat-left">
                            <div class="chat-avatar">
                                <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left"
                                   title=""
                                   data-original-title="">
                                    <svg height="40" width="40">
                                        <text x="65%" y="50%"
                                              style="font-family: IRANSans;font-size: 15px;font-weight: bold;fill: white">
                                            {{mb_substr(Auth::user()->name,0,2,'utf-8')}}
                                        </text>
                                    </svg>
                                </a>
                            </div>
                            <div class="chat-body">
                                <div class="chat-content">
                                    <p>
                                        {!! $ticket->message !!}
                                    </p>
                                    @if ($ticket->file)
                                        <hr>
                                        <span class="text-bold">فایل: </span><a target="_blank"
                                                                                href="{{asset($ticket->file)}}"><i
                                                class="feather icon-download"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    @foreach($answers as $group)
                        <div class="divider">
                            <div class="divider-text">{{$answers->keys()[$loop->index]}}</div>
                        </div>
                        @foreach($group as $answer)
                            @if ($answer->role == 'user')
                                <div class="chat chat-left">
                                    <div class="chat-avatar">
                                        <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left"
                                           title=""
                                           data-original-title="">
                                            <svg height="40" width="40">
                                                <text x="65%" y="50%"
                                                      style="font-family: IRANSans;font-size: 15px;font-weight: bold;fill: white">
                                                    {{mb_substr(Auth::user()->name,0,2,'utf-8')}}
                                                </text>
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-content">
                                            <p>
                                                {!! $answer->message !!}
                                            </p>
                                            @if ($answer->file)
                                                <hr>
                                                <span class="text-bold">فایل: </span><a target="_blank"
                                                                                        href="{{asset($answer->file)}}"><i
                                                        class="feather icon-download"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="chat">
                                    <div class="chat-avatar">
                                        <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right"
                                           title=""
                                           data-original-title="">
                                            <img src="{{ asset(Setting::get('logo')) }}" alt="{{Setting::get('title')}}"
                                                 height="40"
                                                 width="40"/>
                                        </a>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-content">
                                            <p>
                                                {!! $answer->message !!}
                                            </p>
                                            @if ($answer->file)
                                                <hr>
                                                <span class="text-bold">فایل: </span><a target="_blank"
                                                                                        href="{{asset($answer->file)}}"><i
                                                        class="feather icon-download"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
            <div class="chat-app-form">
                <form autocomplete="off" method="post" class="chat-app-input needs-validation " novalidate=""
                      wire:submit.prevent="answer"
                      enctype="multipart/form-data">
                    @csrf
                    <fieldset class="col-12 p-0">
                        <div class="input-group">
                            <textarea class="form-control round" placeholder="پیام خود را تایپ کنید"
                                      wire:model.lazy="message"
                                      id="message" cols="30" rows="3" required=""></textarea>
                        </div>
                    </fieldset>

                    <div class="row mt-1">
                        <fieldset class="text-left form-group round col-12 col-md-3 mb-0">
                            <div class="custom-file rounded">
                                <input type="file" class="custom-file-input" wire:model.lazy="file"
                                       id="file"
                                       accept="image/*,.doc,.docx,.pdf,application/zip,.rar">
                                <label class="custom-file-label" for="file">انتخاب فایل</label>
                            </div>
                        </fieldset>
                        <fieldset class="col-12 col-md-2 offset-md-7 text-right mt-0">
                            <button type="submit"
                                    class="btn btn-block btn-success round btn-min-width btn-glow waves-effect waves-light"
                                    wire:loading.attr="disabled" wire:target="file">
                                ارسال
                            </button>
                        </fieldset>
                    </div>

                    <div class="flex-grow-1">
                        <div class="progress progress-bar-primary progress-lg w-100" style="display: none">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                 aria-valuemax="100" style="width:0%">0%
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
