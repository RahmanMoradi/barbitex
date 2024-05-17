<?php

namespace App\Livewire\Navbar;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Menus extends Component
{
    public function render()
    {
        if (Request::is('wa-admin') || Request::is('wa-admin/*')) {
            $prefix = 'wa-admin';
        } else {
            $prefix = 'panel';
        }
        $configData = Helper::applClasses();
        return view('livewire.navbar.menus', compact('configData', 'prefix'));
    }

    public function changeTheme($theme)
    {
        if (!Auth::check()) {
            flash(Lang::get('please login'))->error()->livewire($this);
            return;
        }
        Request::user()->update([
            'theme' => $theme
        ]);
        $this->dispatchBrowserEvent('changeTheme', $theme);

    }
}
