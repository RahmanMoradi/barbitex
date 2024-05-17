@include('market.layouts.header')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="d-md-none">
        @include('panels.sidebar')
    </div>
    <div class="content-wrapper">
        @yield('main')
    </div>
</div>

@include('market.layouts.footer')
