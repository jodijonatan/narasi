<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleVerification extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedArticle = null;
    public $showReviewModal = false;

    public function render()
    {
        return view('livewire.admin.article-verification', [
            'pendingArticles' => Article::where('status', 'pending')
                ->where('title', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10)
        ])->layout('layouts.app');
    }

    public function review($id)
    {
        $this->selectedArticle = Article::with(['user', 'category'])->findOrFail($id);
        $this->showReviewModal = true;
    }

    public function approve($id)
    {
        $article = Article::findOrFail($id);
        $article->publish();
        
        $this->showReviewModal = false;
        $this->selectedArticle = null;
        session()->flash('message', 'Artikel berhasil diterbitkan!');
    }

    public function reject($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['status' => 'draft']);
        
        $this->showReviewModal = false;
        $this->selectedArticle = null;
        session()->flash('message', 'Artikel dikembalikan ke draft untuk direvisi.');
    }
}
