@extends('home.layouts.master')
@section('main')
    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-white-8" data-bg-img="/home/images/bg/bg6.jpg">
        <div class="container pt-60 pb-60">
            <!-- Section Content -->
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="title">{{$title}}</h2>
                        <ol class="breadcrumb text-center text-black mt-10">
                            <li><a href="#"> خانه</a></li>
                            <li class="active text-theme-colored">{{$title}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: About -->
    <section class="bg-lighter">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $text !!}
                </div>
            </div>
        </div>
    </section>
@endsection
