<?php

namespace App\Http\Controllers\Home;

use anlutro\LaravelSettings\Facade as Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function show($page)
    {
        $text = '';
        $title = '';

        if ($page == 'درباره-ما') {
            $title = Lang::get('about us');
            $text = Setting::get('about');
        } elseif ($page == 'تماس-با-ما') {
            $title = Lang::get('contact us');
            $text = Setting::get('contact');
        } elseif ($page == 'قوانین-و-مقررات') {
            $title = Lang::get('terms and conditions');
            $text = Setting::get('terms');
        } elseif ($page == 'سوالات-متداول') {
            $title = Lang::get('asks');
            $text = Setting::get('ask');
        } elseif ($page == 'راهنمای-استفاده') {
            $title = Lang::get('help');
            $text = Setting::get('help');
        } elseif ($page == 'کارمزد') {
            $title = Lang::get('wage');
            $text = Setting::get('wage');
        } elseif ($page == 'دانلود-اپلیکیشن') {
            $title = Lang::get('application download');
            $text = Setting::get('applicationPage');
        } else {
            abort(404);
        }
        $this->setSeo($title, '', Str::limit($text, 400), null);
        if (Setting::get('homeTheme') == 'v2') {
            return view('home.v2.page.show', compact('title', 'text'));
        }
        return view('home.page.show', compact('title', 'text'));
    }
}
