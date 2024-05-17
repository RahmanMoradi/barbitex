<div class="col-12">
    <div class="card col-8 mx-auto">
        <div class="card-header">
            <h3 class="card-title">تنظیمات لایسنس</h3>
            <div class="card-body">
                <div class="form-group">
                    <label for="rtl_username">نام کاربری شما در سایت راست چین:</label>
                    <input type="text" class="form-control" wire:model.lazy="rtl_username">
                    @error('rtl_username') <p class="text-danger">وارد کردن فیلد الزامی می باشد</p>@enderror
                </div>
                <div class="form-group">
                    <label for="id_order">شناسه سفارش شما در سایت راست چین:</label>
                    <input type="text" class="form-control" wire:model.lazy="id_order">
                    @error('id_order') <p class="text-danger">وارد کردن فیلد الزامی می باشد</p>@enderror
                </div>
                <button class="btn btn-success" wire:click="submit">ثبت لایسنس</button>
            </div>
        </div>
    </div>
</div>
