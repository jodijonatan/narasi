<?php

namespace App\Livewire\Public;

use App\Models\Article;
use Livewire\Component;

class ArticleDetail extends Component
{
    public $article;

    public function mount($slug)
    {
        $this->article = Article::published()
            ->with(['user', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.article-detail')
            ->layout('layouts.app');
    }
}
