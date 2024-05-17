@extends('home.v2.layouts.master')
@section('main')
    <!-- Section: About -->
    <div class="main-content-wrapper medium-padding120">
        <section class="pt-mobile-80">
            <div class="container">
                <div class="row medium-padding100">
                    <div class="col-md-12">
                        {!! $text !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
