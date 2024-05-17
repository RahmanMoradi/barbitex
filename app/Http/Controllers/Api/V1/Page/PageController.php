<?php

namespace App\Http\Controllers\Api\V1\Page;

use anlutro\LaravelSettings\Facade as Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use function Symfony\Component\String\s;

class PageController extends Controller
{
    public function page(Request $request)
    {
        $page = $request->get('page');
        $text = $this->getText(strtolower($page));
        return $this->response(1, $text, [], Lang::get('page information'));
    }

    private function getText($page)
    {
        switch ($page) {
            case 'about':
                return Setting::get('about');
            case 'contact':
                return Setting::get('contact');
            case 'ask':
                return Setting::get('ask');
            case 'terms':
                return Setting::get('terms');
            case 'help':
                return Setting::get('help');
            case 'wage':
                return Setting::get('wage');
            case 'cooperation':
                return Setting::get('cooperation');
        }
    }
}
