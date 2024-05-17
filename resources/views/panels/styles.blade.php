{{-- Vendor Styles --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600">
<link rel="stylesheet" href="{{ asset('vendors/css/vendors.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/ui/prism.min.css') }}">
{{-- Theme Styles --}}
@yield('vendor-style')
@yield('mystyle-chart')
{{-- Theme Styles --}}
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-extended.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/colors.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/components.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/themes/dark-layout.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/themes/semi-dark-layout.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/custom-rtl.min.css') }}">
<link rel="stylesheet" href="{{asset('fonts/iranYekan/iranYekan.css')}}">
{{-- {!! Helper::applClasses() !!} --}}
@php
    $configData = Helper::applClasses();
@endphp
{{-- Layout Styles works when don't use customizer --}}
{{-- @if($configData['theme'] == 'dark-layout')
        <link rel="stylesheet" href="{{ asset(mix('css/themes/dark-layout.css')) }}">
@endif
@if($configData['theme'] == 'semi-dark-layout')
        <link rel="stylesheet" href="{{ asset(mix('css/themes/semi-dark-layout.css')) }}">
@endif --}}
{{-- Customizer Styles --}}
{{-- Page Styles --}}
<link rel="stylesheet" href="{{ asset('css/core/menu/menu-types/horizontal-menu.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/core/menu/menu-types/vertical-menu.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/core/colors/palette-gradient.min.css') }}">

<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/extensions/toastr.min.css') }}">
<link rel="shortcut icon" type="image/x-icon" href="{{asset(Setting::get('favicon'))}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@livewireStyles
@livewireScripts
