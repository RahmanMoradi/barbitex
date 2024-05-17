<div>
    <section id=transactions">
        <div class="card  shadow-none">
            <div class="card-header">
                <h4 class="card-title">تراکنش های من(کیف پول)</h4>
                <div class="row col-md-12 mt-3">
                    <div class="form-group col-md-3">
                        <label for="filterCurrency">ارز</label>
                        <select wire:model.lazy="filterCurrency" class="form-control form-control-sm round select2">
                            <option value="">انتخاب کنید</option>
                            <option value="IRT">IRT</option>
                            @foreach($currencies as $currency)
                                <option value="{{$currency->symbol}}">{{$currency->symbol}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="filterType">نوع</label>
                        <select wire:model.lazy="filterType" class="form-control form-control-sm round select2">
                            <option value="">انتخاب کنید</option>
                            <option value="increment">افزایش اعتبار</option>
                            <option value="decrement">کاهش اعتبار</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="filterStatus">وضعیت</label>
                        <select wire:model.lazy="filterStatus" class="form-control form-control-sm round select2">
                            <option value="">انتخاب کنید</option>
                            <option value="new">جدید</option>
                            <option value="process">در حال انجام</option>
                            <option value="done">موفق</option>
                            <option value="cancel">لغو شده</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="searchPlain">جستجو...</label>
                        <input type="text" class="form-control form-control-sm round" wire:model.lazy="search"
                               placeholder="جستجو...">
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body table-responsive">
                    <table class="table data-list-view">
                        <thead>
                        <tr>
                            <th>شناسه سفارش</th>
                            <th>ارز</th>
                            <th>مقدار</th>
                            <th>نوع</th>
                            <th>وضعیت</th>
                            <th>توضیحات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($transactions as $item)
                            <tr>
                                <th>{{$item->id}}</th>
                                <th>{{$item->currency}}</th>
                                <th>{{$item->price}}</th>
                                <th>{!! $item->type_fa!!}</th>
                                <th>{!! $item->status_fa!!}</th>
                                <th>
                                    @if ($item->currency != 'IRT' && $item->type == 'decrement' && $item->status == 'done' && $item->txid)
                                        <a class="btn btn-sm btn-outline-success" href="{{$item->transaction_link}}"
                                           target="_blank">مشاهد</a>
                                    @else
                                        {{$item->description}}
                                    @endif
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                {{$transactions->links()}}
            </div>
        </div>
    </section>
</div>
