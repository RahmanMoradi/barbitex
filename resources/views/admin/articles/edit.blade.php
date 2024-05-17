@extends('layouts/contentLayoutMaster')

@section('title', trans('edit article'))

@section('vendor-style')
    <!-- vednor css files -->
    <link rel="stylesheet" href="{{ asset('vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/tether-theme-arrows.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/tether.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/shepherd-theme-default.css') }}">
@endsection
@section('mystyle')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset('css/pages/dashboard-analytics.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/card-analytics.min.css') }}">
    {{--    <link rel="stylesheet" href="{{ asset('css/plugins/tour/tour.min.css') }}">--}}
@endsection

@section('content')
    <section id="dashboard-analytics">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form action="{{route('admin.article.update',['post'=>$post])}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body p-0 p-md-1">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="title">@lang('title')</label>
                                            <input name="title" type="text" class="form-control"
                                                   id="title" value="{{old('title') ? : $post->title}}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="image">@lang('image')</label>
                                            <input type="file" name="image">
                                        </div>
                                        @if (Helper::modules()['metaverse'])
                                            <div class="form-group">
                                                <label for="metaverse">@lang('metaverse mode')</label>
                                                <select name="metaverse" class="form-control">
                                                    <option {{!$post->metaverse ? 'selected' :''}} value="0">@lang('inactive')</option>
                                                    <option {{$post->metaverse ? 'selected' :''}} value="1">@lang('active')</option>
                                                </select>
                                            </div>
                                        @endif
                                        @if (Helper::modules()['airdrop'])
                                            <div class="form-group">
                                                <label for="airdrop">@lang('airdrop mode')</label>
                                                <select name="airdrop" class="form-control">
                                                    <option {{!$post->airdrop ? 'selected' :''}} value="0">@lang('inactive')</option>
                                                    <option {{$post->airdrop ? 'selected' :''}} value="1">@lang('active')</option>
                                                </select>
                                            </div>
                                        @endif
                                        @if (Helper::modules()['analysis'])
                                            <div class="form-group">
                                                <label for="analysis">@lang('analysis mode')</label>
                                                <select name="analysis" class="form-control">
                                                    <option {{!$post->analysis ? 'selected' :''}} value="0">@lang('inactive')</option>
                                                    <option {{$post->analysis ? 'selected' :''}} value="1">@lang('active')</option>
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="time_send">@lang('category')</label>
                                            <select name="category_id" class="form-control">
                                                <option value="">@lang('select')</option>
                                                @foreach ($categories as $category)
                                                    <option
                                                        {{$post->category_id == $category->id ? 'selected':''}} value="{{$category->id}}">{{$category->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if (Helper::modules()['vip'])
                                            <div class="form-group">
                                                <label for="vip">@lang('vip mode')</label>
                                                <select name="vip" class="form-control">
                                                    <option {{!$post->vip ? 'selected' :''}} value="0">@lang('inactive')</option>
                                                    <option {{$post->vip ? 'selected' :''}} value="1">@lang('active')</option>
                                                </select>
                                            </div>
                                        @endif
                                        @if (Helper::modules()['application'])
                                            <div class="form-group">
                                                <label for="show_app">@lang('show on app')</label>
                                                <select name="show_app" class="form-control">
                                                    <option {{!$post->show_app ? 'selected' :''}} value="0">@lang('inactive')</option>
                                                    <option {{$post->show_app ? 'selected' :''}} value="1">@lang('active')</option>
                                                </select>
                                            </div>
                                        @endif
                                        @if (Helper::modules()['discount'])
                                            <div class="form-group">
                                                <label for="discount">@lang('discount mode')</label>
                                                <select name="discount" class="form-control">
                                                    <option {{!$post->discount ? 'selected' :''}} value="0">@lang('inactive')</option>
                                                    <option {{$post->discount ? 'selected' :''}} value="1">@lang('active')</option>
                                                </select>
                                            </div>
                                        @endif
                                        @if (Helper::modules()['accreditation'])
                                            <div class="form-group">
                                                <label for="accreditation">@lang('accreditation mode')</label>
                                                <select name="accreditation" class="form-control">
                                                    <option {{!$post->accreditation ? 'selected' :''}} value="0">@lang('inactive')</option>
                                                    <option {{$post->accreditation ? 'selected' :''}} value="1">@lang('active')</option>
                                                </select>
                                            </div>
                                        @endif
                                        @if (Helper::modules()['reward'])
                                            <div class="form-group">
                                                <label for="reward">@lang('reward mode')</label>
                                                <select name="reward" class="form-control">
                                                    <option {{!$post->reward ? 'selected' :''}} value="0">@lang('inactive')</option>
                                                    <option {{$post->reward ? 'selected' :''}} value="1">@lang('active')</option>
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="meta_description">@lang('seo description')</label>
                                            <textarea class="form-control" rows="6"
                                                      name="meta_description">{{old('meta_description') ? : $post->meta_description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="meta_tag">@lang('seo tag')</label>
                                            <textarea name="meta_tag" rows="6"
                                                      class="form-control">{{old('meta_tag') ? : $post->meta_tag}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="body">@lang('description')</label>
                                        <textarea class="editor"
                                                  name="body">{{old('body') ? : $post->body}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" class="btn btn-outline-success" value="@lang('submit')">
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>

@endsection

@section('vendor-script')
    <!-- vednor files -->
    <script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/tether.min.js') }}"></script>
    {{--    <script src="{{ asset('vendors/js/extensions/shepherd.min.js') }}"></script>--}}
@endsection
@section('myscript')
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/translations/fa.js"></script>

    <script>
        var allEditors = document.querySelectorAll('.editor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor
                .create(allEditors[i], {
                    language: 'fa',
                    ckfinder: {
                        uploadUrl: `{{route('admin.ckeditor.upload',['_token'=>csrf_token()])}}`
                    }
                })
                .then(editor => {
                    editor.ui.view.editable.element.style.height = '150px';
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
@endsection
