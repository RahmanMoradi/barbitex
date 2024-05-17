@extends('home.layouts.master')
@section('main')
    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-white-8" data-bg-img="/home/images/bg/bg6.jpg">
        <div class="container pt-60 pb-60">
            <!-- Section Content -->
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="title">{{$article->title}}</h2>
                        <ol class="breadcrumb text-center text-black mt-10">
                            <li><a href="{{url('/')}}"> خانه</a></li>
                            <li><a href="{{url('blog')}}">وبلاگ</a></li>
                            <li class="active text-theme-colored">{{$article->title}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Blog -->
    <section>
        <div class="container mt-30 mb-30 pt-30 pb-30">
            <div class="row">
                <div class="col-md-9">
                    <div class="blog-posts single-post">
                        <article class="post clearfix mb-0">
                            <div class="entry-header">
                                <div class="post-thumb thumb">
                                    <img src="{{$article->image_url}}" alt="{{$article->title}}"
                                         class="img-responsive img-fullwidth">
                                </div>
                            </div>
                            <div class="entry-content">
                                <div class="entry-meta media no-bg no-border mt-15 pb-20">
                                    <div
                                        class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                                        <ul>
                                            <li class="font-16 text-white font-weight-600">{{\Morilog\Jalali\Jalalian::forge($article->created_at)->format('d')}}</li>
                                            <li class="font-12 text-white text-uppercase"> {{\Morilog\Jalali\Jalalian::forge($article->created_at)->format('M')}}</li>
                                        </ul>
                                    </div>
                                    <div class="media-body pr-15">
                                        <div class="event-content pull-left flip">
                                            <h3 class="entry-title text-white text-uppercase pt-0 mt-0"><a
                                                    href="{{route('home.blog.show',['slug'=>$article->slug])}}">{{$article->title}}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                {!! $article->body !!}
                                <div class="mt-30 mb-0">
                                    <h5 class="pull-left flip mt-10 mr-20 text-theme-colored">اشتراک گذاری:</h5>
                                    <ul class="styled-icons icon-circled m-0">
                                        <li><a href="#" data-bg-color="#3A5795"><i
                                                    class="fa fa-facebook text-white"></i></a></li>
                                        <li><a href="#" data-bg-color="#55ACEE"><i class="fa fa-twitter text-white"></i></a>
                                        </li>
                                        <li><a href="#" data-bg-color="#A11312"><i class="fa fa-google-plus text-white"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                        <div class="tagline p-0 pt-20 mt-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="tags">
                                        <p class="mb-0"><i class="fa fa-tags text-theme-colored"></i>
                                            <span>تگ ها:</span>{{$article->meta_tags}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="author-details media-post">
                            <a href="{{url('/')}}" class="post-thumb mb-0 pull-left flip pr-20"><img class="img-thumbnail"
                                                                                                     alt=""
                                                                                                     src="{{asset(Setting::get('logo'))}}"></a>
                            <div class="post-right">
                                <h5 class="post-title mt-0 mb-0"><a href="{{url('/')}}"
                                                                    class="font-18">{{Setting::get('title')}}</a></h5>
{{--                                <p>{!! Setting::get('about') !!}</p>--}}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="sidebar sidebar-left mt-sm-30">
                        {{--                    <div class="widget">--}}
                        {{--                        <h5 class="widget-title line-bottom">جستجو</h5>--}}
                        {{--                        <div class="search-form">--}}
                        {{--                            <form>--}}
                        {{--                                <div class="input-group">--}}
                        {{--                                    <input type="text" placeholder="Click to Search" class="form-control search-input">--}}
                        {{--                                    <span class="input-group-btn">--}}
                        {{--                      <button type="submit" class="btn search-button"><i class="fa fa-search"></i></button>--}}
                        {{--                      </span>--}}
                        {{--                                </div>--}}
                        {{--                            </form>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        <div class="widget">
                            <h5 class="widget-title line-bottom"> دسته بندی</h5>
                            <div class="categories">
                                <ul class="list list-border angle-double-right">
                                    @foreach($categories as $category)
                                        <li><a href="#">{{$category->title}}<span>({{optional($category->posts)->count()}})</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="widget">
                            <h5 class="widget-title line-bottom">آخرین اخبار</h5>
                            <div class="latest-posts">
                                @foreach ($lastNews as $news)
                                    <article class="post media-post clearfix pb-0 mb-10">
                                        <a class="post-thumb" href="{{route('home.blog.show',['slug'=>$news->slug])}}"><img
                                                src="{{$news->image_url}}" alt="{{$news->title}}" height="50"></a>
                                        <div class="post-right">
                                            <h5 class="post-title mt-0"><a
                                                    href="{{route('home.blog.show',['slug'=>$news->slug])}}">{{Str::limit($news->title,20)}}</a>
                                            </h5>
                                            <p>{{Str::limit($news->short_body,20)}}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
