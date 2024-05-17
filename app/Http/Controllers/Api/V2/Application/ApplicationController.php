<?php

namespace App\Http\Controllers\Api\V2\Application;

use anlutro\LaravelSettings\Facade as Setting;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ApplicationController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->where('show_app', 1)
            ->where('vip', 0)
            ->where('discount', 0)
            ->where('accreditation', 0)
            ->where('reward', 0);
        $per_page = request()->get('per_page') ? request()->get('per_page') : $this::PER_PAGE;
        $list = ArticleResource::collection($articles->paginate($per_page))->response()->getData(true);
        $slides = $list['data'];

        $version = Setting::get('application.version');
        $force_download = Setting::get('application.force_download');
        $link = Setting::get('application.link');
        $data = [
            'version' => $version,
            'force' => $force_download,
            'link' => $link,
            'auth_img' => asset(Setting::get('authImage')),
            'title' => Lang::get('download the new version'),
            'description' => Lang::get('download the new version of the app'),
            'wallet' => isset(Helper::modules()['wallet']) ?? false,
            'market' => isset(Helper::modules()['market']) ?? false,
            'marketOrder' => isset(Helper::modules()['marketOrder']) ?? false,
            'orderPlane' => isset(Helper::modules()['orderPlane']) ?? false,
            'portfolio' => isset(Helper::modules()['portfolio']) ?? false,
            'referrals' => isset(Helper::modules()['referrals']) ?? false,
            'vip' => isset(Helper::modules()['vip']) ?? false,
            'discount' => isset(Helper::modules()['discount']) ?? false,
            'accreditation' => isset(Helper::modules()['accreditation']) ?? false,
            'reward' => isset(Helper::modules()['reward']) ?? false,
            'cooperation' => isset(Helper::modules()['cooperation']) ?? false,
            'metaverse' => isset(Helper::modules()['metaverse']) ?? false,
            'airdrop' => isset(Helper::modules()['airdrop']) ?? false,
            'analysis' => isset(Helper::modules()['analysis']) ?? false,
            'message' => Setting::get('application.home_message'),
            'slides' => $slides,
            'popup' => [
                'id' => Setting::get('application.text_id'),
                'image' => asset(Setting::get('application.bg-message')),
                'link' => url('/'),
                'title' => Setting::get('application.title'),
                'message' => Setting::get('application.message')
            ],
        ];
        return $this->response(1, $data, [], Lang::get('download the new version'));
    }
}
