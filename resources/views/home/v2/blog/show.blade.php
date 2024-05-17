@extends('home.v2.layouts.master')
@section('main')
    <div class="main-content-wrapper">
        <section data-settings="particles-1"
                 class="main-section crumina-flying-balls particles-js bg-1 medium-padding120">
            <div class="container">
                <div class="row align-center">
                    <div class="col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12">
                        <header class="crumina-module crumina-heading heading--h2 heading--with-decoration">
                            <div class="heading-sup-title">دسته بندی خبر</div>
                            <h2 class="heading-title heading--half-colored">{{$article->title}}</h2>
                            <div class="heading-text">{{$article->short_body}}</div>
                        </header>

                        <div class="post-details-wrap">
                            <div class="post__date">
                                <a href="#"
                                   class="number">{{\Morilog\Jalali\Jalalian::forge($article->created_at)->format('d')}}</a>
                                <time class="published" datetime="2018-03-14 12:00:00">
                                    {{\Morilog\Jalali\Jalalian::forge($article->created_at)->format('M')}},
                                    <span>{{\Morilog\Jalali\Jalalian::forge($article->created_at)->format('Y')}}</span>
                                </time>
                            </div>

                            <div class="author-block">
                                <div class="avatar avatar60">
                                    <img src="{{asset(Setting::get('logo'))}}" alt="avatar">
                                </div>
                                <div class="author-content">
                                    <div class="author-prof">نویسنده</div>
                                    <a href="#" class="author-name">{{Setting::get('title')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="medium-padding120">
            <div class="container">
                <div class="row pb60">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <article class="hentry post post-standard has-post-thumbnail video">
                            <div class="post-thumb">
                                <img src="{{$article->image_url}}" alt="post">
                                <div class="overlay overlay-blog"></div>
                            </div>
                        </article>
                    </div>

                    <!-- Blog posts-->
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <article class="hentry post post-standard has-post-thumbnail video post-standard-details">
                            <div class="post__content">

                                <header class="crumina-module crumina-heading heading--h4 heading--with-decoration">
                                    <h4 class="heading-title">{{$article->title}}</h4>
                                    <div class="heading-text">{{$article->short_bodt}}</div>
                                </header>
                                <p class="post__text">{!! $article->body !!}</p>
                            </div>
                        </article>
                    </div>
                    <!-- End Blog posts-->

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">

                        <aside aria-label="sidebar" class="sidebar sidebar-left">
                            <aside class="widget w-latest-news">
                                <img class="primary-dots" src="img/dots-5.png" alt="dots">
                                <h5 class="widget-title">جدیدترین مطالب</h5>
                                <ul class="latest-news-list">
                                    @foreach($lastNews as $news)
                                        <li>
                                            <article itemscope="" itemtype="http://schema.org/NewsArticle"
                                                     class="latest-news-item">

                                                <div class="post__date">
                                                    <time class="published" datetime="2018-03-08 12:00:00">
                                                        <span
                                                            class="number">{{\Morilog\Jalali\Jalalian::forge($news->created_at)->format('d')}}</span> {{\Morilog\Jalali\Jalalian::forge($news->created_at)->format('M')}}
                                                        , {{\Morilog\Jalali\Jalalian::forge($news->created_at)->format('Y')}}
                                                    </time>
                                                </div>

                                                <a href="{{route('home.blog.show',['slug'=>$news->slug])}}"
                                                   class="h6 post__title entry-title">{{$news->title}}</a>
                                            </article>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>
                        </aside>
                    </div>

                </div>
            </div>
        </section>

    </div>
@endsection
