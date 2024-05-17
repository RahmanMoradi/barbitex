<div>
    <section id="calculator" style="background: #eceff5">
        <div class="container pt-30 pb-30">
            <!-- Section Content -->
            <div class="section-content">
                <div class="row">
                    <div id="app" class="col-md-12 text-center">
                        <div class="form-group form-inline"
                             style="display: flex; justify-content: center; align-items: center;">
                            <select class="form-control border-radius" wire:model.lazy="currency">
                                @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}">{{$currency->symbol}}</option>
                                @endforeach
                            </select>
                            <input type="text" placeholder="مقدار"
                                   class="form-control border-radius" wire:model.lazy="qty">
                            <input type="text"
                                   placeholder="تومان"
                                   class="form-control border-radius" wire:model.lazy="price">
                            <a href="/panel" class="btn btn-default border-radius"
                               style="height: 44px;width: 100px">
                                خرید
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
