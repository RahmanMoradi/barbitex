<section id="dashboard-analytics">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">اعلان ها</h3>
                    @if($path == 'admin')
                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#sendModal">
                            <i class="fa fa-send-o"></i>
                            ارسال اعلان جدید
                        </button>
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-body p-0 p-md-1">
                        <div class="table-responsive">
                            <table
                                class="table table-striped col-md-12 mx-auto" style="width:100%">
                                <thead>
                                <tr>
                                    <th>عنوان</th>
                                    <th style="width:30%">متن</th>
                                    <th>تاریخ</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($notifications as $notification)
                                    <a
                                        href="{{url($notification->data['url'])}}">
                                        <tr>
                                            <td>{{$notification['data']['subject']}}</td>
                                            <td style="width:30%">{{$notification['data']['message']}}</td>
                                            <td>{{\Morilog\Jalali\Jalalian::forge($notification->created_at)->ago()}}</td>
                                            <td>
                                                @if ($notification->unread())
                                                    <button class="btn btn-sm btn-danger"
                                                            wire:click="markAsRead({{$notification}})">
                                                        <i class="fa fa-stop-circle"></i>
                                                        خوانده شد
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-success"
                                                            wire:click="markAsRead({{$notification}})">
                                                        <i class="fa fa-check-circle-o"></i>
                                                        خوانده نشد
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    </a>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $notifications->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal bd-example-modal-lg sendModal" tabindex="-1" role="dialog" id="sendModal" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ایجاد اعلان جدید</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title">ارسال به گروه</label>
                                <select class="form-control" name="group" wire:model.lazy="group">
                                    <option value="">انتخاب گروه</option>
                                    <option value="users">کاربران</option>
                                    <option value="admins">مدیران</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">عنوان</label>
                                <input wire:model.lazy="title" type="text" class="form-control"
                                       id="title" value="{{old('title')}}" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="link">لینک</label>
                                <input wire:model.lazy="link" type="text" class="form-control"
                                       id="link" value="{{old('link')}}" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="link_title">عنوان لینک</label>
                                <input wire:model.lazy="link_title" type="text" class="form-control"
                                       id="link_title" value="{{old('link_title')}}" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="message">پیام</label>
                                <textarea class="editor form-control"
                                          wire:model.lazy="message" required>{{old('message')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" wire:key="send" wire:click.prevent="send">
                        <i class="fa fa-send-o"></i>
                        ارسال
                    </button>
                    <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">انصراف
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
