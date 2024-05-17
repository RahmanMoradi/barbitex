<div class="navbar-collapse" id="navbar-mobile">
    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
        <ul class="nav navbar-nav">
            <li class="nav-item mobile-menu d-xl-none mr-auto">
                <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                    <i class="ficon feather icon-menu"></i>
                </a>
            </li>
        </ul>
        <ul class="nav navbar-nav bookmark-icons">
            <li class="nav-item d-none d-md-block">
                <a class="nav-link" href="{{url($prefix)}}"
                   data-toggle="tooltip" data-placement="top"
                   title="پنل کاربری">
                    <i class="ficon feather icon-home"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a class="nav-link" href="{{url($prefix.'/tickets')}}"
                   data-toggle="tooltip" data-placement="top"
                   title="پشتیبانی">
                    <i class="ficon feather icon-message-square"></i>
                </a>
            </li>
            @if (\App\Helpers\Helper::modules()['market'])
                <li class="dropdown nav-item d-none d-md-block">
                    <a class="dropdown-toggle nav-link dropdown-user-link" href="#"
                       data-toggle="dropdown">
                        <i class="ficon  fa fa-exchange"></i>
                        <span>بازارها</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach($markets as $market)
                            <a class="dropdown-item"
                               href="{{route('market.market',['market_symbol' => $market->symbol])}}">
                                {{$market->symbol}}
                            </a>
                        @endforeach
                    </div>
                </li>
            @endif
        </ul>
    </div>
    <ul class="nav navbar-nav float-right">
        <li class="nav-item d-none d-lg-block">
            <a class="nav-link nav-link-expand">
                <i class="ficon feather icon-maximize"></i>
            </a>
        </li>
        <li class="nav-item">
            @if ($configData['theme'] === 'light')
                <a class="nav-link"
                   wire:click.prevent="changeTheme('dark')"
                   href="#">
                    <i class="ficon feather icon-moon"></i>
                </a>
            @else
                <a class="nav-link"
                   wire:click.prevent="changeTheme('light')"
                   href="#">
                    <i class="ficon feather icon-sun"></i>
                </a>
            @endif
        </li>
        @livewire('navbar.notifications')
        <li class="dropdown dropdown-user nav-item" wire:ignore>
            <a class="dropdown-toggle nav-link dropdown-user-link" href="#"
               data-toggle="dropdown">
                <div class="user-nav d-sm-flex d-none">
                    <span class="user-name text-bold-600">{{Auth::check() ? Auth::user()->name : ''}}</span>
                    <span class="user-status">{{Auth::check() ? Auth::user()->mobile : ''}}</span>
                </div>
                <span>
                                            <img class="round"
                                                 src="{{asset(Setting::get('favicon'))}}"
                                                 alt="{{Setting::get('title')}}" height="40" width="40"/>
                                        </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @if ($prefix == 'panel')
                    <a class="dropdown-item" href="{{url($prefix.'/authentication/profile')}}">
                        <i class="feather icon-user"></i>
                        پروفایل
                    </a>
                @endif
                @if ($prefix == 'panel')
                    <a class="dropdown-item"
                       href="{{url($prefix.'/authentication/two-factor-authentication')}}">
                        <i class="feather icon-check-square"></i>
                        ورود دو مرحله ای
                    </a>
                    <a class="dropdown-item" href="{{url($prefix.'/authentication/password')}}">
                        <i class="feather icon-hash"></i>
                        تغییر رمز
                    </a>
                @else
                    <a class="dropdown-item"
                       href="{{url($prefix.'/admin/'.auth()->guard('admin')->id())}}">
                        <i class="feather icon-check-square"></i>
                        ورود دو مرحله ای
                    </a>
                    <a class="dropdown-item" href="{{url($prefix.'/admin/'.auth()->guard('admin')->id())}}">
                        <i class="feather icon-hash"></i>
                        تغییر رمز
                    </a>
                @endif
                <a class="dropdown-item"
                   href="{{url($prefix.'/notifications')}}">
                    <i class="feather icon-alert-circle"></i>
                    اعلان ها
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('auth/panel/logout')}}">
                    <i class="feather icon-power"></i>
                    خروج
                </a>
            </div>
        </li>
    </ul>
</div>
