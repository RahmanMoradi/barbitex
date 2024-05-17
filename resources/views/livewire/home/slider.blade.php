<div class="row mt-50">
    <div class="col-12 mx-auto text-center">
        <div class="owl-carousel-3col">
            @foreach($posts as $post)
                <div class="item">
                    <img src="{{asset($post->image)}}" height="168" width="362" style="border-radius: 5px"
                         alt="">
                </div>
            @endforeach
        </div>
    </div>
</div>
