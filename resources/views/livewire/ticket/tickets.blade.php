<div>
    <!-- Column selectors with Export Options and print table -->
    <section id="column-selectors">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="list-inline mb-0">
                            <li>
                                <a wire:click="collapse">
                                    <h4 class="card-title">
                                        <i class="feather icon-plus"></i>
                                        ثبت درخواست جدید
                                    </h4>
                                </a>
                            </li>
                        </ul>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <br>
                    <div class="card-content {{$collapse ? 'collapse' :''}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form autocomplete="off" method="post" class="needs-validation mt-1" novalidate=""
                                          wire:submit.prevent="submit" enctype="multipart/form-data" style="">
                                        @csrf
                                        <div class="row col-md-7 col-12 m-md-auto ml-0 p-0">
                                            <div class="col-md-6 p-0 px-md-1 form-group">
                                                <label for="subject">موضوع</label>
                                                <input type="text" class="form-control round" wire:model.lazy="subject"
                                                       id="subject" placeholder="موضوع خود را درج کنید" required="">
                                                <div class="invalid-feedback">موضوع خود را انتخاب کنید</div>
                                            </div>
                                            <div class="col-md-6 p-0 px-md-1 form-group">
                                                <label for="category_id">واحد</label>
                                                <select class="form-control round" wire:model.lazy="category_id"
                                                        id="category_id"
                                                        required="">
                                                    <option value="">
                                                        واحد را انتخاب کنید
                                                    </option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">واحد را انتخاب کنید</div>
                                            </div>

                                            @if ($viewType == 'user')
                                                <div class="col-md-12 p-0 px-md-1 form-group">
                                                    <label for="order_id">در خصوص سفارش</label>
                                                    <select class="form-control round" wire:model.lazy="order_id"
                                                            id="order_id">
                                                        <option value="">هیچ کدام</option>
                                                        @foreach($orders as $order)
                                                            <option value="{{$order->id}}">
                                                                سفارش شماره {{$order->id}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <div class="col-md-12 p-0 px-md-1 form-group">
                                                    <label for="user_id">کاربر</label>
                                                    <select class="form-control round" wire:model.lazy="user_id"
                                                            id="user_id">
                                                        <option value="">هیچ کدام</option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">
                                                                {{$user->name}} ({{$user->email}})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif

                                            <div class="col-md-12 p-0 px-md-1 form-group">
                                                <label for="message">توضیحات</label>
                                                <textarea rows="5" wire:model.lazy="message" id="message" required=""
                                                          class="form-control round"
                                                          placeholder="پیغام خود را درج کنید"></textarea>
                                                <div class="invalid-feedback">پیغام خود را درج کنید</div>
                                            </div>
                                            <div class="col-md-12 p-0 px-md-1 form-group">
                                                <label for="credit1">فایل پیوست</label>
                                                <fieldset class="form-group">
                                                    <div class="custom-file rounded">
                                                        <input type="file" class="custom-file-input"
                                                               wire:model.lazy="file"
                                                               id="file"
                                                               accept="image/*,.doc,.docx,.pdf,application/zip,.rar">
                                                        <label class="custom-file-label" for="file">انتخاب فایل</label>
                                                    </div>
                                                    <small class="font-small-2 text-center text-muted">پسوندهای مجاز:
                                                        jpg, jpeg, png, pdf, doc, docx, zip, rar حداکثر حجم فایل 5
                                                        مگابایت</small>
                                                </fieldset>
                                            </div>
                                            <div class="progress progress-bar-primary progress-lg w-100"
                                                 style="display: none">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="0"
                                                     aria-valuemin="0" aria-valuemax="100" style="width:0%">0%
                                                </div>
                                            </div>
                                            <div class="col-md-6 m-auto">
                                                <button type="submit"
                                                        class="btn btn-primary round waves-effect waves-light"
                                                        wire:loading.attr="disabled" wire:target="file">
                                                    ثبت درخواست
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">پشتیبانی</h4>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-info" wire:click="$set('filter','new')">جدید</button>
                            <button class="btn btn-success" wire:click="$set('filter','admin')">پاسخ مدیر</button>
                            <button class="btn btn-primary" wire:click="$set('filter','user')">پاسخ کاربر</button>
                            <button class="btn btn-danger" wire:click="$set('filter','close')">بسته شده</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <p class="card-text">
                                لیست تیکت های ارسال شده را مشاهده میکنید .
                            </p>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>موضوع</th>
                                        @if($viewType == 'admin')
                                            <th>کاربر</th>
                                        @endif
                                        <th>واحد پشتیبانی</th>
                                        <th>وضعیت</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>آخرین بروزرسانی</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>
                                                <a href="{{url("$prefix/ticket",['ticket'=>$ticket])}}">{{$ticket->subject}}</a>
                                            </td>
                                            @if($viewType == 'admin')
                                                <td>{{optional($ticket->user)->email}}</td>
                                            @endif
                                            <td>{{optional($ticket->category)->title}}</td>
                                            <td>
                                                <span
                                                    class="badge badge-{{$ticket->status_class}}">{{$ticket->status_fa}}
                                                </span>
                                            </td>
                                            <td>{{$ticket->created_at}}</td>
                                            <td>{{$ticket->updated_at}}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{url($prefix.'/ticket',['ticket'=>$ticket])}}"
                                                       class="btn btn-outline-info">مشاهده</a>
                                                    <a wire:click="close({{$ticket}})"
                                                       class="btn btn-outline-danger">
                                                        بستن
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>موضوع</th>
                                        <th>واحد پشتیبانی</th>
                                        <th>وضعیت</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>آخرین بروزرسانی</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <hr>
                            {{$tickets->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Column selectors with Export Options and print table -->
</div>
