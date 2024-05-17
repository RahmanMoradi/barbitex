<div class="card-body">
    <p class="">
        تنظیمات سطوح کاربری
    </p>
    <div class="col-12 border-primary p-2">
        <div class="table-responsive">
            <p>تنظیمات سطح بندی کاربران</p>
            <p class="alert alert-warning">درصد وارد شده از قیمت ثبت شده تتر برای سطوح مختلف کسر میگردد</p>
            <form id="formSetting" action="{{route('admin.setting.store.userLevel')}}" method="post">
                @csrf
                <table class="table table-bordered table-hover">
                    <tbody class="text-center">
                    <tr style="background-color: #e55400;color: #FFF5EF">
                        <th>میزان مجاز خرید کاربران برنزی(روزانه):</th>
                        <th>
                            <input type="text" class="form-control" name="userLevel[bronze][maxDayBuy]"
                                   value="{{Setting::get('userLevel.bronze.maxDayBuy')}}">
                        </th>
                    </tr>
                    <tr style="background-color: #a9a3a3">
                        <th>شروع سطح نقره ای از جمع خرید:</th>
                        <th>
                            <input type="text" class="form-control" name="userLevel[silver][sumPrice]"
                                   value="{{Setting::get('userLevel.silver.sumPrice')}}">
                        </th>
                    </tr>
                    <tr style="background-color: #a9a3a3">
                        <th>میزان مجاز خرید کاربران نقره ای(روزانه):</th>
                        <th>
                            <input type="text" class="form-control" name="userLevel[silver][maxDayBuy]"
                                   value="{{Setting::get('userLevel.silver.maxDayBuy')}}">
                        </th>
                    </tr>

                    <tr style="background-color: #ffae00">
                        <th>شروع سطح طلایی از جمع خرید:</th>
                        <th>
                            <input type="text" class="form-control" name="userLevel[gold][sumPrice]"
                                   value="{{Setting::get('userLevel.gold.sumPrice')}}">
                        </th>
                    </tr>
                    <tr style="background-color: #ffae00">
                        <th>میزان مجاز خرید کاربران طلایی(روزانه):</th>
                        <th>
                            <input type="text" class="form-control" name="userLevel[gold][maxDayBuy]"
                                   value="{{Setting::get('userLevel.gold.maxDayBuy')}}">
                        </th>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" value="ثبت تنظیمات" class="btn btn-outline-success">
            </form>
        </div>
    </div>
</div>
