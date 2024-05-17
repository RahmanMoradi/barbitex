<div>
    <div class="card">
        <div class="card-body">
            <p class="alert alert-black">با انتخاب و خرید یکی از بسته های زیر شما میتوانید به قسمت vip سایت دسترسی داشته
                باشید!</p>
            <p class="alert alert-danger {{$selectPack ? '' : 'd-none'}}">پس از زدن دکمه پرداخت مبلغ مورد نظر از موجودی
                شما کسر میگردد و پلن مورد
                نظر برای شما فعال می شود.!</p>
        </div>
    </div>
    <section id="ecommerce-products" class="grid-view row">
        @foreach($packs as $pack)
            <div class="ecommerce-card col-md-4 m-r-1">
                <div class="card card-content bg-gradient-info">
                    <div class="card-image text-center">
                        <img class="w-100" src="{{$pack->image}}" height="150">
                    </div>
                    <div class="card-body">
                        <div class="item-wrapper">
                            <div>
                                <h6 class="item-price">{{number_format($pack->price)}} تومان </h6>
                            </div>
                        </div>
                        <div class="item-name">
                            <a class="font-large-1 text-white" href="#">{{$pack->title}}</a>
                        </div>
                        <div>
                            <p class="item-description">{{$pack->description}}</p>
                        </div>
                    </div>
                    <div class="item-options text-center" wire:loading.class="blur" wire:loading.target="buy">
                        <div class="cart">
                            <a
                                class="btn btn-block btn-primary {{$selectPack == $pack->id  ? 'd-none' : ''}}"
                                wire:click="$set('selectPack',{{$pack->id}})">
                                <i class="fa fa-check-circle"></i>
                                انتخاب
                            </a>

                            <a href="#" wire:click="pay"
                               class="btn btn-block btn-success {{$selectPack != $pack->id ? 'd-none' : ''}}">
                                <i class="fa fa-money"></i>
                                پرداخت
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
</div>
