@extends('layouts/contentLayoutMaster')

@section('title', "درخواست شماره  $id")

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('vendors/css/vendors-rtl.min.css')}}">
@endsection

@section('mystyle')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset('css/pages/app-chat.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/core/colors/palette-gradient.min.css') }}">
@endsection
@section('content')
    <livewire:ticket.ticket :id="$id" viewType="admin"/>
@endsection

@section('myscript')
    <!-- Page js files -->
    <script src="{{ asset('js/scripts/pages/app-chat.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('body').addClass('chat-application')
        });
    </script>
    <script>
        $(document).ready(function () {
            console.log(52314)
            var element = document.getElementById('chats')
            element.scrollTop = element.scrollHeight
        });
    </script>
@stop

