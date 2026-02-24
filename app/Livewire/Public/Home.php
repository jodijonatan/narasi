<?php

namespace App\Livewire\Public;

use App\Models\Article;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Article::published()->with(['user', 'category']);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category) {
            $query->whereHas('category', function($q) {
                $q->where('slug', $this->category);
            });
        }

        return view('livewire.public.home', [
            'articles' => $query->latest('published_at')->paginate(9),
            'categories' => Category::withCount('publishedArticles')->get()
        ])->layout('layouts.app');
    }
}
