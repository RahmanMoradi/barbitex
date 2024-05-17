<!DOCTYPE html>
<!--
Template Name: webazin market v6
Author: webazin
Website: https://webazin.net/
Contact: hello@pixinvent.com
Follow: www.twitter.com/webazin
Like: www.facebook.com/webazin
Purchase: https://webazin.net/
Renew Support: https://webazin.org/panel

-->
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="@yield('title')">
    <meta name="keywords"
          content="@yield('title')">
    <meta name="author" content="webazin.net">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset(Setting::get('favicon'))}}">
    <link href="/panelAssets/app-assets/images/fonts.googleapis.css" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/vendors/css/vendors-rtl.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/css-rtl/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/css-rtl/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/css-rtl/colors.min.css">
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/css-rtl/components.min.css">
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/css-rtl/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/css-rtl/themes/semi-dark-layout.min.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
          href="/panelAssets/app-assets/css-rtl/core/menu/menu-types/horizontal-menu.min.css">
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/css-rtl/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/css-rtl/pages/faq.min.css">
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/vendors/css/extensions/nouislider.min.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/panelAssets/app-assets/css-rtl/custom-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style-rtl.css">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="/Home3/fonts/iranyekan/css/style.css">
    <!-- END: Custom CSS-->
    @yield('css')
    <style>
        [data-theme="dark"] {
            --primary-color: rgb(107, 106, 134);
            --secondary-color: #818cab;
            --font-color: #e1e1ff;
            --bg-color: #2e4da2;
            --heading-color: #63656d;
            --color: white;
        }
    </style>
    @livewireStyles
</head>
<!-- END: Head-->
@php
    $configData = Helper::applClasses();
@endphp
<!-- BEGIN: Body-->
<body class="horizontal-layout horizontal-menu 2-columns  navbar-floating footer-static  {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }}  {{($configData['theme'] === 'light') ? '' : $configData['theme'] }}  {{ $configData['navbarType'] }} {{ $configData['sidebarClass'] }} {{ $configData['footerType'] }}"
      data-open="hover"
      data-menu="horizontal-menu" data-col="2-columns" data-layout="{{ $configData['theme'] }}">

<!-- BEGIN: Header-->
@include('panels.navbar')
<style>
    .horizontal-menu .content .content-wrapper {
        margin-top: -60px !important;
    }
</style>
