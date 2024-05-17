@extends('layouts/contentLayoutMaster')

@section('title', 'vip')

@section('vendor-style')
    {{-- vednor css files --}}
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panelAssets/app-assets/css-rtl/pages/app-ecommerce-shop.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panelAssets/app-assets/css/core/colors/palette-gradient.min.css') }}">
@endsection

@section('content')
    @if(request()->is('panel/vip'))
        <livewire:vip.vip/>
    @else
        <livewire:vip.buy/>
    @endif
@endsection
@section('vendor-script')

@endsection
@section('myscript')
    {{-- Page js files --}}
    <script src="{{ asset('js/scripts/datatables/datatable.js') }}"></script>
@endsection
