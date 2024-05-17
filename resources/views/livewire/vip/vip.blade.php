<div>
    <section id="knowledge-base-search">
        <div class="row">
            <div class="col-12">
                <div class="card knowledge-base-bg bg-gradient-dark white">
                    <div class="card-content">
                        <div class="card-body p-sm-4 p-2">
                            <h1 class="white">جستجو در مطالب vip سایت</h1>
                            <p class="card-text mb-2">اگر به دنبال مطب خاصی هستید در کادر زیر جستجو کنید</p>
                            <form>
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <input type="text" class="form-control form-control-lg" id="searchbar"
                                           placeholder="جستجو موضوع یا کلمه کلیدی" wire:model.lazy="search" wire:change="getArticles">
                                    <div class="form-control-position">
                                        <i class="feather icon-search px-1"></i>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Knowledge base Jumbotron ends -->
    <!-- Knowledge base -->
    <section id="knowledge-base-content">
        <div class="row search-content-info">
            @foreach($articles as $article)
                <div class="col-md-4 col-sm-6 col-12 search-content">
                    <div class="card">
                        <div class="card-image">
                            <img src="{{asset($article->image)}}" class="mx-auto w-100" height="180"
                                 alt="{{$article->title}}">
                        </div>
                        <div class="card-body">
                            <a wire:click="setPost({{$article}})">
                                <h4>{{$article->title}}</h4>
                                <small class="text-dark">
                                    {{\Illuminate\Support\Str::limit(strip_tags($article->body))}}
                                </small>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center">
            {{$articles->links()}}
        </div>
    </section>
    <!-- Knowledge base ends -->
    <!-- Modal -->
    <a id="showModal" data-toggle="modal" data-target="#showArticle">
    </a>
    <div class="modal bd-example-modal-lg fade" id="showArticle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $post ? $post->title: '' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! $post ? $post['body'] : ''!!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
</div>
