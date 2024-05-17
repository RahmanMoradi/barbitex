<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use function GuzzleHttp\Psr7\str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Article::orderBy('created_at', 'desc')->get();

        return view('admin.articles.index', compact('posts'));
    }

    public function create()
    {
        $categories = ArticleCategory::all();

        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:article_categories,id',
            'image' => 'image'
        ]);
        Article::create($request->only('title', 'category_id', 'body', 'meta_tag', 'meta_description', 'vip', 'discount',
                'accreditation', 'reward', 'metaverse', 'airdrop', 'analysis', 'show_app') + [
                'image' => $request->has('image') ? $this->uploadFile('/articles/image', $request->image) : null,
                'user_id' => Auth::guard('admin')->id()
            ]);

        return redirect('wa-admin/posts');
    }

    public function remove($id)
    {
        $post = Article::where('id', $id)->first();
        Storage::disk('public')->delete($post->image);
        $post->delete();

        return back();
    }

    public function show(Article $post)
    {
        $categories = ArticleCategory::all();

        return view('admin.articles.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Article $post)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:article_categories,id',
            'image' => 'image'
        ]);
        $post->slug = null;
        if ($request->has('image')) {
            Storage::disk('public')->delete($post->image);
        }
        $post->update($request->only('title', 'body', 'meta_tag', 'meta_description', 'vip', 'discount', 'accreditation',
                'reward', 'metaverse', 'airdrop', 'analysis', 'show_app','category_id') + [
                'image' => $request->has('image') ? $this->uploadFile('/articles/image', $request->image) : $post->image
            ]);

        return redirect('wa-admin/posts');
    }
}
