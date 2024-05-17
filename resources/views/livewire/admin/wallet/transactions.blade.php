<div>
    <section id="transaction">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="title">لیست تراکنش ها</h4>
                        <input type="text" class="col-md-4 form-control form-control-sm round" wire:model.lazy="search"
                               placeholder="جستجو...">
                        @if($user_id)
                            <div class="col-12">
                                <p>جمع واریزی ها:
                                    <span>{{number_format($increment)}}</span>
                                </p>
                                <p>جمع دریافتی ها:
                                    <span>{{number_format($decrement)}}</span>
                                </p>
                            </div>
                        @endif
                        <div class="row col-md-12 mt-3">
                            <div class="form-group col-md-3">
                                <label for="filterCurrency">کاربر</label>
                                <select wire:model.lazy="filterUser" data-livewire-model="filterUser" class="form-control form-control-sm round select2">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->email}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="filterCurrency">ارز</label>
                                <select wire:model.lazy="filterCurrency" data-livewire-model="filterCurrency" class="form-control form-control-sm round select2">
                                    <option value="">انتخاب کنید</option>
                                    <option value="IRT">IRT</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->symbol}}">{{$currency->symbol}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="filterType">نوع</label>
                                <select wire:model.lazy="filterType" class="form-control form-control-sm round">
                                    <option value="">انتخاب کنید</option>
                                    <option value="increment">افزایش اعتبار</option>
                                    <option value="decrement">کاهش اعتبار</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="filterStatus">وضعیت</label>
                                <select wire:model.lazy="filterStatus" class="form-control form-control-sm round">
                                    <option value="">انتخاب کنید</option>
                                    <option value="new">جدید</option>
                                    <option value="process">در حال انجام</option>
                                    <option value="done">موفق</option>
                                    <option value="cancel">لغو شده</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 p-md-1">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-hover-animation col-md-12 mx-auto">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>کاربر</th>
                                        <th>ارز</th>
                                        <th>نوع</th>
                                        <th>مبلغ</th>
                                        <th>تاریخ و ساعت ثبت</th>
                                        <th>وضعیت</th>
                                        <th>شرح</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($wallets as $wallet)
                                        <tr>
                                            <td>{{$wallet->id}}</td>
                                            <td>{{optional($wallet->user)->name}}</td>
                                            <td>
                                                {{$wallet->currency}}
                                            </td>
                                            <td>{!! $wallet->type_fa !!}</td>
                                            <td>
                                                مبلغ
                                                : {{App\Helpers\Helper::numberFormatPrecision($wallet->price,optional($wallet->currencyRelation)->decimal)}}
                                            </td>
                                            <td>{{$wallet->created_at_fa}}</td>
                                            <td>{!! $wallet->status_fa !!}</td>
                                            <td>{{$wallet->description}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                {{$wallets->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            function init() {
                // $('.select2').select2();
            }
            setTimeout(function (){
                init()
            },300)
            {{--$('.select2').on('change', function (e) {--}}
            {{--    var model = e.target.getAttribute('data-livewire-model');--}}
            {{--    var data = e.target.value--}}
            {{--    @this.set(model, data);--}}
            {{--    setTimeout(function (){--}}
            {{--        init()--}}
            {{--    },1000)--}}
            {{--});--}}
        });
    </script>
@endpush
