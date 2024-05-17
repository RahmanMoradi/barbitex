{{-- For submenu --}}
<ul class="menu-content">
    @foreach($menu as $submenu)
        <?php
            $submenuTranslation = "";
            if(isset($menu->i18n)){
                $submenuTranslation = $menu->i18n;
            }
        ?>
        <li class="{{ (url($submenu->url) == url('/').request()->getRequestUri()) ? 'active' : '' }}">
            <a href="{{ url($submenu->url) }}">
                @if (isset($submenu->icon ))
                    <i class="{{ isset($submenu->icon) ? $submenu->icon : "" }}"></i>
                @elseif(isset($submenu->image))
                    <img src="{{asset($submenu->image)}}" width="30px">
                @endif
                <span class="menu-title" data-i18n="{{ $submenuTranslation }}">{{ $submenu->name }}</span>
            </a>
            @if (isset($submenu->submenu))
                @include('panels/submenu', ['menu' => $submenu->submenu])
            @endif
        </li>
    @endforeach
</ul>
