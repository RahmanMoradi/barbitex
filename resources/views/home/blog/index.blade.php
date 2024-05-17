@extends('home.layouts.master')
@section('main')
    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-white-8" data-bg-img="/home/images/bg/bg6.jpg">
        <div class="container pt-60 pb-60">
            <!-- Section Content -->
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="title">وبلاگ</h2>
                        <ol class="breadcrumb text-center text-black mt-10">
                            <li><a href="/"> خانه</a></li>
                            <li class="active text-theme-colored">وبلاگ</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container mt-30 mb-30 pt-30 pb-30">
            <div class="row blog-posts">
            @foreach($articles as $article)
                <!-- Blog Item Start -->
                    <div class="col-md-3">
                        <article class="post clearfix mb-30 bg-lighter">
                            <div class="entry-header">
                                <div class="post-thumb thumb">
                                    <a href="{{route('home.blog.show',['slug'=>$article->slug])}}">
                                        <img src="{{$article->image_url}}" alt="{{$article->title}}"
                                             class="img-responsive img-fullwidth" style="height: 144px">
                                    </a>
                                </div>
                            </div>
                            <div class="entry-content border-1px p-20 pr-10">
                                <div class="entry-meta media mt-0 no-bg no-border">
                                    <div class="media-body">
                                        <div class="event-content pull-left flip">
                                            <h4 class="entry-title text-white text-uppercase m-0 mt-5">
                                                <a href="{{route('home.blog.show',['slug'=>$article->slug])}}">{{$article->title}}</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-10">{{$article->short_body}}</p>
                                <a href="{{route('home.blog.show',['slug'=>$article->slug])}}"
                                   class="btn-read-more"> اطلاعات بیشتر</a>
                                <div class="clearfix"></div>
                            </div>
                        </article>
                    </div>
                    <!-- Blog Item End -->
            @endforeach
            <!-- Blog Masonry -->
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <nav>
                        <ul class="pagination theme-colored xs-pull-center m-0">
                            {{$articles->links()}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

@endsection
