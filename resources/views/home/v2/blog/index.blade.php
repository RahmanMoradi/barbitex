@extends('home.v2.layouts.master')
@section('main')
    <div class="main-content-wrapper">
        <section data-settings="particles-1"
                 class="main-section crumina-flying-balls particles-js bg-1 medium-padding120">
            <div class="container">
                <div class="row align-center">
                    <div class="col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12 mb60">
                        <header class="crumina-module crumina-heading heading--h2 heading--with-decoration">
                            <div class="heading-sup-title">خبر ها</div>
                            <h2 class="heading-title heading--half-colored">با تاج کوین به روز باشید</h2>
                            <div class="heading-text">
                                آخرین اخبار در حوضه ارز دیجیتال
                            </div>
                        </header>
                    </div>
                </div>
            </div>
        </section>

        <section class="medium-padding120">
            <div class="container">
                <div class="row pb60">
                    <!-- Blog posts-->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @foreach($articles as $article)
                            <article class="hentry post post-standard has-post-thumbnail">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <div class="post__date">
                                            <time class="published" datetime="2018-02-03 12:00:00">
                                                {{$article->created_at_fa}}
                                            </time>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="post-thumb">
                                            <img src="{{$article->image_url}}" alt="post">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="post__content">

                                            <a href="{{route('home.blog.show',['slug'=>$article->slug])}}" class="h3 post__title entry-title">
                                                {{$article->title}}
                                            </a>

                                            <p class="post__text">
                                                {{$article->short_body}}
                                            </p>

                                            <div class="post-additional-info">
                                                <a href="{{route('home.blog.show',['slug'=>$article->slug])}}"
                                                   class="btn btn--large btn--secondary btn--transparent btn--with-icon btn--icon-right">
                                                    بیشتر
                                                    <svg class="woox-icon icon-arrow-right">
                                                        <use xlink:href="#icon-arrow-right"></use>
                                                    </svg>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <!-- End Blog posts-->
                </div>
                <hr class="divider">
                {!! $articles->links() !!}
            </div>
        </section>

    </div>
@endsection
