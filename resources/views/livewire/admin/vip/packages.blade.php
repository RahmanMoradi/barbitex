<div>
    <!-- Column selectors with Export Options and print table -->
    <section id="column-selectors">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="list-inline mb-0">
                            <li>
                                <a wire:click="$set('collapse',{{!$collapse}})">
                                    <h4 class="card-title">
                                        <i class="feather {{$collapse ? 'icon-plus' : 'icon-minus'}}"></i>
                                        ثبت پکیج جدید
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
                                    <div class="col-md-6 mx-auto">
                                        <div class="form-group">
                                            <label for="title">عنوان</label>
                                            <input type="text" wire:model.lazy="pack.title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="image">تصویر</label>
                                            <input type="file" wire:model.lazy="pack.image">
                                        </div>
                                        <div class="form-group">
                                            <label for="days">تعداد روز</label>
                                            <input type="number" wire:model.lazy="pack.days" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="price">مبلغ(تومان)</label>
                                            <input type="number" wire:model.lazy="pack.price" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">توضیحات</label>
                                            <textarea class="form-control" rows="3"
                                                      wire:model.lazy="pack.description"></textarea>
                                        </div>
                                        <button type="submit" wire:click="storePack" wire:loading.attr="disabled"
                                                wire:target="pack.image"
                                                class="btn btn-primary round waves-effect waves-light">
                                            ثبت
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">لیست پک ها</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    <th>تعداد روزها</th>
                                    <th>مبلغ</th>
                                    <th>توضیحات</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($packs as $pack)
                                    <tr>
                                        <td><img src="{{$pack->image}}" height="60"/></td>
                                        <td>{{$pack->title}}</td>
                                        <td>{{$pack->days}}</td>
                                        <td>{{number_format($pack->price)}}</td>
                                        <td>{{$pack->description}}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="#" wire:click="edit({{$pack}})" class="btn btn-info btn-sm">
                                                    ویرایش
                                                </a>
                                                <a href="#" wire:click="delete({{$pack}})"
                                                   class="btn btn-danger btn-sm">
                                                    حدف
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">vip های فعال</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>کاربر</th>
                                    <th>پک</th>
                                    <th>مانده</th>
                                    <th>وضعیت</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($actives as $active)
                                    <tr>
                                        <td>{{optional($active->user)->name}}</td>
                                        <td>{{optional($active->pack)->title}}</td>
                                        <td>{{Carbon\Carbon::parse($active->expire_at)->diffInDays()}} روز</td>
                                        <td>
                                            <span
                                                class="badge badge-{{$active->active ? 'success' : 'danger'}}">{{$active->active?'فعال':'غیرفعال'}}</span>
                                        </td>
                                        <td>
                                            <a href="#" wire:click="deActive({{$active}})"
                                               class="btn btn-danger btn-sm">
                                                غیر فعال کردن
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    اضافه کردن کاربر به vip
                </div>
                <br>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-md-6 mx-auto">
                                    <div class="form-group">
                                        <label for="title">کاربر(شناسه کاربر را وارد کنید)</label>
                                        <input type="text" wire:model.lazy="buy.user_id" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="days">پکیج انتخابی</label>
                                        <select class="form-control" wire:model.lazy="buy.pack">
                                            <option value="">انتخاب کنید</option>
                                            @foreach($packs as $item)
                                                <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" wire:click="buy" wire:loading.attr="disabled"
                                            wire:target="buy"
                                            class="btn btn-primary round waves-effect waves-light">
                                        ثبت
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column selectors with Export Options and print table -->
</div>
