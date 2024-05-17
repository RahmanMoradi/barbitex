<?php

namespace App\Http\Controllers\Home;

use anlutro\LaravelSettings\Facade as Setting;
use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $meta_tag = '';
        $meta_description = '';
        $meta = Article::orderByDesc('created_at')
            ->where('vip', 0)
            ->where('discount', 0)
            ->where('accreditation', 0)
            ->where('reward', 0)
            ->select('meta_tag', 'meta_description')
            ->take(12)->get();
        foreach ($meta as $key => $item) {
            $meta_tag .= $key != 0 ? ',' : '' . Str::limit($item->meta_tag, 160);
            $meta_description .= $key != 0 ? ' ' : '' . Str::limit(strip_tags($item->meta_description), 400);
        }
        $this->setSeo(Lang::get('blog'), $meta_tag, $meta_description, null);
        $articles = Article::orderByDesc('created_at')
            ->where('vip', 0)
            ->where('discount', 0)
            ->where('accreditation', 0)
            ->where('reward', 0)
            ->paginate(12);
        if (Setting::get('homeTheme') == 'v2') {
            return view('home.v2.blog.index', compact('articles'));
        }
        return view('home.blog.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::whereSlug($slug)
            ->where('discount',0)
            ->where('accreditation',0)
            ->where('reward',0)
            ->firstOrFail();
        $this->setSeo($article->title, $article->meta_tag, $article->meta_description, $article->image_url);
        $categories = ArticleCategory::all();
        $lastNews = Article::orderByDesc('created_at')->take(5)->get();
        if (Setting::get('homeTheme') == 'v2') {
            return view('home.v2.blog.show', compact('article', 'categories', 'lastNews'));
        }
        return view('home.blog.show', compact('article', 'categories', 'lastNews'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);
        $meta_tag = '';
        $meta_description = '';
        $meta = Article::orderByDesc('created_at')
            ->select('meta_tag', 'meta_description')
            ->take(12)
            ->where('discount', 0)
            ->where('accreditation', 0)
            ->where('reward', 0)
            ->where('title', 'like', "%$request->search%")
            ->orWhere('body', 'like', "%$request->search%")
            ->get();
        foreach ($meta as $key => $item) {
            $meta_tag .= $key != 0 ? ',' : '' . Str::limit($item->meta_tag, 160);
            $meta_description .= $key != 0 ? ' ' : '' . Str::limit(strip_tags($item->meta_description), 400);
        }
        $this->setSeo($request->search, $meta_tag, $meta_description, null);
        $articles = Article::orderByDesc('created_at')
            ->where('title', 'like', "%$request->search%")
            ->orWhere('body', 'like', "%$request->search%")
            ->paginate(12);

        return view('home.blog.index', compact('articles'));
    }
}
