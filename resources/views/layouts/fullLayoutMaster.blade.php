@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN: Seo-->
{!! SEO::generate() !!}
<!-- END: Seo-->

    <title>@yield('title') - {{Setting::get('title')}}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset(Setting::get('favicon'))}}">

    {{-- Include core + vendor Styles --}}
    @include('panels/styles')
    {{-- Include page Style --}}
    @yield('mystyle')
</head>

{{-- {!! Helper::applClasses() !!} --}}
@php
    $configData = Helper::applClasses();
@endphp

<body
    class="vertical-layout vertical-menu-modern 1-column {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{($configData['theme'] === 'light') ? '' : $configData['theme'] }}
        data-menu="vertical-menu-modern  data-col="1-column" data-layout="{{ $configData['theme'] }}">

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">

            {{-- Include Startkit Content --}}
            @yield('content')

        </div>
    </div>
</div>
<!-- End: Content-->

{{-- include default scripts --}}
@include('panels/scripts')

{{-- Include page script --}}
@yield('myscript')

</body>
</html>
