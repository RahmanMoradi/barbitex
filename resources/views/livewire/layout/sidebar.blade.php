@if (Request::is('wa-admin') || Request::is('wa-admin/*'))
    <li class="navigation-header">
        <span>منو مدیریت</span>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin') }}">

            <i class="fa fa-dashboard"></i>
            <span class="menu-title" data-i18n="">داشبورد</span>
        </a>
    </li>
    {{--    markets--}}
    <li class="navigation-header">
        <span>مدیریت مالی</span>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/orders')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/orders') }}">
            <i class="fa fa-list"></i>
            <span class="menu-title" data-i18n="">لیست سفارشات</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/wallet/decrement')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/wallet/decrement') }}">
            <i class="fa fa-money"></i>
            <span
                class="badge badge-danger">{{$decrementCount}}</span>
            <span class="menu-title" data-i18n="" title="درخواست های منتظر بررسی">درخواست های منتظر بررسی</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/wallets')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/wallets') }}">
            <i class="fa fa-stack-exchange"></i>
            <span class="menu-title" data-i18n="">تراکنش ها</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/wallet/balance')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/wallet/balance') }}">
            <i class="fa fa-balance-scale"></i>
            <span class="menu-title" data-i18n="">موجودی کاربران</span>
        </a>
    </li>
    {{--    end markets--}}
    {{--    markets--}}
    <li class="navigation-header">
        <span>مدیریت ارزها</span>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/currencies')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/currencies') }}">
            <i class="fa fa-btc"></i>
            <span class="menu-title" data-i18n="">ارزها</span>
        </a>
    </li>
    {{--    end markets--}}
    @if (Helper::modules()['market'])
        {{--    markets--}}
        <li class="navigation-header">
            <span>مدیریت بازارها</span>
        </li>
        <li class="nav-item {{ (request()->is('wa-admin/markets')) ? 'active' : '' }}">
            <a href="{{ url('wa-admin/markets') }}">
                <i class="fa fa-shopping-bag"></i>
                <span class="menu-title" data-i18n="">بازارها</span>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('wa-admin/markets/commission')) ? 'active' : '' }}">
            <a href="{{ url('wa-admin/markets/commission') }}">
                <i class="fa fa-money"></i>
                <span class="menu-title" data-i18n="">حسابداری</span>
            </a>
        </li>
        {{--    end markets--}}
    @endif
    {{--    users --}}
    <li class="navigation-header">
        <span>مدیریت کاربران</span>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/users')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/users') }}">
            <i class="fa fa-users"></i>
            <span class="menu-title" data-i18n="">کاربران</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/documents')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/documents') }}">
            <i class="fa fa-newspaper-o"></i>
            <span
                class="badge badge-danger">{{$documentCount}}</span>
            <span class="menu-title" data-i18n="">مدارک</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/cards')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/cards') }}">
            <i class="fa fa-credit-card-alt"></i>
            <span
                class="badge badge-danger">{{$cardCount}}</span>
            <span class="menu-title" data-i18n="">کارت های بانکی</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/logs')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/logs') }}">
            <i class="fa fa-key"></i>
            <span class="menu-title" data-i18n="">@lang('user login logs')</span>
        </a>
    </li>
    @if (Helper::modules()['tournament'])
        <li class="nav-item {{ (request()->is('wa-admin/tournament')) ? 'active' : '' }}">
            <a href="{{ url('wa-admin/tournament') }}">
                <i class="fa fa-trophy"></i>
                <span class="menu-title" data-i18n="">@lang('tournament')</span>
            </a>
        </li>
    @endif
    {{--    end users--}}

    {{--    tickets --}}
    <li class="navigation-header">
        <span>مدیریت درخواست ها</span>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/tickets')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/tickets') }}">
            <i class="fa fa-support"></i>
            <span
                class="badge badge-danger">{{$ticketCount}}</span>
            <span class="menu-title" data-i18n="">پشتیبانی</span>
        </a>
    </li>
    {{--    end tickets--}}

    {{--    admins --}}
    <li class="navigation-header">
        <span>مدیریت مدیران</span>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/admins')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/admins') }}">
            <i class="fa fa-user-secret"></i>
            <span class="menu-title" data-i18n="">لیست مدیران</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/roles')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/roles') }}">
            <i class="fa fa-refresh"></i>
            <span class="menu-title" data-i18n="">نقش ها</span>
        </a>
    </li>
    {{--    end admins--}}
    {{--    articles --}}
    <li class="navigation-header">
        <span>مدیریت مقاله ها</span>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/posts')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/posts') }}">
            <i class="fa fa-edit"></i>
            <span class="menu-title" data-i18n="">لیست مقاله ها</span>
        </a>
    </li>
    {{--    end articles--}}
    @if (Helper::modules()['vip'])
        {{--    vip --}}
        <li class="navigation-header">
            <span>مدیریت vip</span>
        </li>
        <li class="nav-item {{ (request()->is('wa-admin/vip/packages')) ? 'active' : '' }}">
            <a href="{{ url('wa-admin/vip/packages') }}">
                <i class="fa fa-star"></i>
                <span class="menu-title" data-i18n="">لیست پک ها</span>
            </a>
        </li>
        {{--    end vip--}}
    @endif

    {{--    settings --}}
    <li class="navigation-header">
        <span>تنظیمات سایت</span>
    </li>
    <li class="nav-item {{ (request()->is('wa-admin/settings')) ? 'active' : '' }}">
        <a href="{{ url('wa-admin/settings?level=general') }}">
            <i class="fa fa-gears"></i>
            <span class="menu-title" data-i18n="">تنظیمات</span>
        </a>
    </li>
    {{--    end settings--}}
    {{--    ----------------------------------------end admin routes--------------------------------------------------}}
@else
    <li class="navigation-header">
        <span>منو کاربری</span>
    </li>
    <br>
    <li class="nav-item {{ (request()->is('panel')) ? 'active' : '' }}">
        <a href="{{ url('panel') }}">

            <i class="fa fa-dashboard"></i>
            <span class="menu-title" data-i18n="">پنل کاربری</span>
        </a>
    </li>
    @if(Helper::modules()['orderPlane'])
        <hr>
        <li class="nav-item {{ (request()->is('panel/order/create')) ? 'active' : '' }}">
            <a href="{{ url('panel/order/create') }}">
                <i class="fa fa-first-order"></i>
                <span class="menu-title" data-i18n="">مبادله سریع</span>
            </a>
        </li>
    @endif
    @if (Helper::modules()['market'])
        <hr>
        <li class="nav-item {{ (request()->is('market/*')) ? 'active' : '' }}">
            <a href="{{ url('market',['symbol' => null]) }}">

                <i class="fa fa-exchange"></i>
                <span class="menu-title" data-i18n="">بازار حرفه ای</span>
            </a>
        </li>
        <hr>
        <li class="nav-item {{ (request()->is('panel/market/transactions')) ? 'active' : '' }}">
            <a href="{{ url('panel/market/transactions') }}">
                <i class="fa fa-exchange"></i>
                <span class="menu-title" data-i18n="">لیست معامله ها</span>
            </a>
        </li>
    @else
        <li class="nav-item {{ (request()->is('panel/market/transactions')) ? 'active' : '' }}">
            <a href="{{ url('panel/wallet/transactions') }}">
                <i class="fa fa-exchange"></i>
                <span class="menu-title" data-i18n="">لیست معامله ها</span>
            </a>
        </li>
    @endif
    @if (Helper::modules()['wallet'])
        <hr>
        <li class="nav-item {{ (request()->is('panel/wallet')) ? 'active' : '' }}">
            <a href="{{ url('panel/wallet') }}">

                <i class="fa fa-shopping-bag"></i>
                <span class="menu-title" data-i18n="">کیف پول</span>
            </a>
        </li>
        <hr>
        @if (Helper::modules()['cart_to_cart'])
            <li class="nav-item {{ (request()->is('panel/wallet/cart_to_cart')) ? 'active' : '' }}">
                <a href="{{ url('panel/wallet/cart_to_cart') }}">

                    <i class="fa fa-credit-card"></i>
                    <span class="menu-title" data-i18n="">واریز کارت به کارت</span>
                </a>
            </li>
            <hr>
        @endif
        <li class="nav-item {{ (request()->is('panel/wallet/transactions')) ? 'active' : '' }}">
            <a href="{{ url('panel/wallet/transactions') }}">

                <i class="fa fa-list"></i>
                <span class="menu-title" data-i18n="">لیست تراکنش ها</span>
            </a>
        </li>
        <hr>
        <li class="nav-item {{ (request()->is('/panel/authentication/card')) ? 'active' : '' }}">
            <a href="{{ url('/panel/authentication/card') }}">

                <i class="fa fa-credit-card-alt"></i>
                <span class="menu-title" data-i18n="">کارت های بانکی</span>
            </a>
        </li>
        @if(Helper::modules()['portfolio'])
            <hr>
            <li class="nav-item {{ (request()->is('panel/portfolio')) ? 'active' : '' }}">
                <a href="{{ url('panel/portfolio') }}">
                    <i class="fa fa-database"></i>
                    <span class="menu-title" data-i18n="">پرتفووی</span>
                </a>
            </li>
        @endif
        <hr>
        <li class="nav-item {{ (request()->is('panel/tickets')) ? 'active' : '' }}">
            <a href="{{ url('panel/tickets') }}">

                <i class="fa fa-support"></i>
                <span class="menu-title" data-i18n="">پشتیبانی</span>
            </a>
        </li>
    @endif
    @if (Helper::modules()['vip'])
        <hr>
        <li class="nav-item {{ (request()->is('panel/vip')) ? 'active' : '' }}">
            <a href="{{ url('panel/vip') }}">

                <i class="fa fa-star"></i>
                <span class="menu-title" data-i18n="">مطالب vip</span>
            </a>
        </li>
    @endif
    @if (Helper::modules()['referrals'])
        <hr>
        <li class="nav-item {{ (request()->is('panel/referrals')) ? 'active' : '' }}">
            <a href="{{ url('panel/referrals') }}">

                <i class="fa fa-users"></i>
                <span class="menu-title" data-i18n="">دعوت از دوستان</span>
            </a>
        </li>
    @endif
@endif
