<div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-content p-md-2 p-1">
                    <div class="card-body px-0 py-2 border block-element">

                        <div id="Calculator" class="row" style="justify-content: center; padding: 0px 10px;">
                            <div class="col-lg-8 col-xs-12 col-sm-10">
                                <div class="row bit_main-controller">
                                    <div class="col-lg-4 col-sm-4 col-12 mt-2 mt-sm-0">
                                        <select wire:model.lazy="symbol" class="form-control">
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency->symbol}}">{{$currency->name}}</option>
                                            @endforeach
                                        </select>
                                        <label>ارز</label>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-12">
                                        <div class="text-field--group">
                                            <input wire:model.lazy="qty" style="font-family: system-ui;font-size: 14px;"
                                                   type="text" id="unit" autocomplete="off" class="form-control">
                                            <label>واحد</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-12">
                                        <div class="text-field--group">
                                            <input wire:model.lazy="price" type="text" id="price" autocomplete="off"
                                                   class="form-control">
                                            <label>تومان</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-1 btn-crypto">
                                <button class="btn waves-effect waves-light btn-outline-success"
                                        wire:click="submit('buy')">
                                    <span>درخواست خرید</span>
                                </button>
                                <button class="btn waves-effect waves-light btn-outline-danger"
                                        wire:click="submit('sell')">
                                    <span>فروش</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
