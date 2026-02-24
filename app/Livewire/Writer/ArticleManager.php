<?php

namespace App\Livewire\Writer;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class ArticleManager extends Component
{
    use WithPagination, WithFileUploads;

    public $title, $slug, $content, $categoryId, $excerpt, $thumbnail, $status = 'draft', $articleId;
    public $isEditing = false;
    public $showCreateModal = false;
    public $search = '';

    protected $rules = [
        'title' => 'required|min:5|max:255',
        'content' => 'required|min:20',
        'categoryId' => 'required|exists:categories,id',
        'excerpt' => 'nullable|max:500',
        'thumbnail' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function render()
    {
        return view('livewire.writer.article-manager', [
            'articles' => Article::where('user_id', Auth::id())
                ->where('title', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10),
            'categories' => Category::all()
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetFields();
        $this->showCreateModal = true;
    }

    public function resetFields()
    {
        $this->title = '';
        $this->slug = '';
        $this->content = '';
        $this->categoryId = '';
        $this->excerpt = '';
        $this->thumbnail = null;
        $this->status = 'draft';
        $this->articleId = null;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        $thumbnailPath = null;
        if ($this->thumbnail) {
            $thumbnailPath = $this->thumbnail->store('thumbnails', 'public');
        }

        Article::create([
            'user_id' => Auth::id(),
            'category_id' => $this->categoryId,
            'title' => $this->title,
            'slug' => $this->slug ?: Str::slug($this->title),
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'thumbnail' => $thumbnailPath,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Article created successfully.');
        $this->showCreateModal = false;
        $this->resetFields();
    }

    public function edit($id)
    {
        $article = Article::where('user_id', Auth::id())->findOrFail($id);
        $this->articleId = $id;
        $this->title = $article->title;
        $this->slug = $article->slug;
        $this->content = $article->content;
        $this->categoryId = $article->category_id;
        $this->excerpt = $article->excerpt;
        $this->status = $article->status;
        $this->isEditing = true;
        $this->showCreateModal = true;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:20',
            'categoryId' => 'required|exists:categories,id',
            'excerpt' => 'nullable|max:500',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $article = Article::where('user_id', Auth::id())->findOrFail($this->articleId);
        
        $data = [
            'category_id' => $this->categoryId,
            'title' => $this->title,
            'slug' => $this->slug ?: Str::slug($this->title),
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'status' => $this->status,
        ];

        if ($this->thumbnail) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = $this->thumbnail->store('thumbnails', 'public');
        }

        $article->update($data);

        session()->flash('message', 'Article updated successfully.');
        $this->showCreateModal = false;
        $this->resetFields();
    }

    public function delete($id)
    {
        $article = Article::where('user_id', Auth::id())->findOrFail($id);
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();
        session()->flash('message', 'Article deleted successfully.');
    }

    public function submitForReview($id)
    {
        $article = Article::where('user_id', Auth::id())->findOrFail($id);
        $article->update(['status' => 'pending']);
        session()->flash('message', 'Article submitted for review.');
    }
}
