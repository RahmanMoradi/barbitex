<?php

namespace App\Livewire\Vip;

use App\Models\Article\Article;
use Livewire\Component;

class Vip extends Component
{
    public $search, $post;

    public function mount()
    {
        $this->search = '';
        $this->post = null;
    }

    public function render()
    {
        $articles = $this->getArticles();
        return view('livewire.vip.vip', compact('articles'));
    }

    public function getArticles()
    {
        if ($this->search && $this->search != '') {
            return Article::where('vip', 1)
                ->where('title', 'LIKE', '%' . $this->search . '%')
                ->orWhere('body', 'LIKE', '%' . $this->search . '%')
                ->orderByDesc('created_at')
                ->paginate(12);
        } else {
            return Article::where('vip', 1)
                ->orderByDesc('created_at')
                ->paginate(12);
        }
    }

    public function setPost(Article $article)
    {
        $this->post = $article;
        $this->dispatchBrowserEvent('showModal');
    }
}
