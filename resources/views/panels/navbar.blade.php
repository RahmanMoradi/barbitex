@if($configData["mainLayoutType"] == 'horizontal')
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu {{ $configData['navbarColor'] }} navbar-fixed">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item"><a class="navbar-brand" href="{{url('panel')}}">
                        <div class="brand-logo"></div>
                    </a></li>
            </ul>
        </div>

        @else
            <nav
                class="{{Request::is('market/*') || Request::is('v2/market/*') ? 'header-navbar navbar-expand-lg navbar navbar-with-menu  navbar-brand-center '.$configData['navbarColor'] :'header-navbar navbar-expand-lg navbar navbar-with-menu ' .$configData['navbarClass'] .' '.$configData['navbarColor']}}">
                @endif
                <div class="navbar-wrapper">
                    <div class="navbar-container content">
                        <livewire:navbar.menus/>
                    </div>
                </div>
            </nav>
            <!-- END: Header-->
            <livewire:layout.loading/>
