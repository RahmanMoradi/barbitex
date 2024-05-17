<?php

namespace App\Providers\Custom;

use App\Models\Article\Article;
use App\Models\Traid\Market\Market;
use Illuminate\Support\Facades\Blade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use anlutro\LaravelSettings\Facade as Setting;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @param Request $request
     *
     * @return void
     */
    public function boot(Request $request)
    {

        View::composer('*', function ($view) {
            $markets = Cache::remember('markets', 50000, function () {
                return Market::where('status', 1)->get();
            });
            $articles = Cache::remember('articles', 50000, function () {
                return Article::latest()->where('vip', 0)->paginate(3);
            });
            $view->with('markets', $markets);
            $view->with('articlesFooter', $articles);
        });

        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->role == 2;
        });
        Blade::if('user', function () {
            return Auth::check() && Auth::user()->role == 1;
        });
        Blade::directive('role', function ($roles) {
            eval("\$roles = [$roles];");
            $roles = json_encode($roles);
            return "<?php if(auth()->check() && auth()->user()->hasRoles($roles)){ ?>";
        });
        Blade::directive('endrole', function () {
            return "<?php }; ?>";
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
