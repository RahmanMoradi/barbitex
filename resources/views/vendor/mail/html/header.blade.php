<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{asset(Setting::get('logo'))}}" class="logo" alt="{{Setting::get('title')}}">
            {{ $slot }}
        </a>
    </td>
</tr>
