<?php

namespace App\Livewire\Home;

use App\Models\Article\Article;
use Livewire\Component;

class Slider extends Component
{
    public function render()
    {
        $posts = Article::where('vip', 0)
            ->where('discount', 0)
            ->where('accreditation', 0)
            ->where('reward', 0)->paginate(6);
        return view('livewire.home.slider', compact('posts'));
    }
}
