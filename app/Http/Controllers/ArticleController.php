<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
  /**
   * Display a listing of the published articles.
   */
  public function index()
  {
    $articles = Article::published()
      ->with(['category', 'user'])
      ->latest('published_at')
      ->paginate(10);

    return view('articles.index', compact('articles'));
  }

  /**
   * Display the specified article.
   */
  public function show(Article $article)
  {
    // Only allow published articles to be viewed by public
    if ($article->status !== 'published') {
      abort(404);
    }

    return view('articles.show', compact('article'));
  }

  /**
   * Display a listing of the articles for admin.
   */
  public function adminIndex()
  {
    $articles = Article::with(['category', 'user'])
      ->latest()
      ->paginate(20);

    return view('admin.articles.index', compact('articles'));
  }

  /**
   * Show the form for creating a new article.
   */
  public function create()
  {
    $categories = Category::all();
    return view('admin.articles.create', compact('categories'));
  }

  /**
   * Store a newly created article in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'category_id' => 'required|exists:categories,id',
      'excerpt' => 'nullable|string|max:500',
      'content' => 'required|string',
      'status' => ['required', Rule::in(['draft', 'published'])],
    ]);

    $validated['user_id'] = auth()->id();
    $validated['slug'] = Str::slug($validated['title']);

    // Handle duplicate slug
    $originalSlug = $validated['slug'];
    $counter = 1;
    while (Article::where('slug', $validated['slug'])->exists()) {
      $validated['slug'] = $originalSlug . '-' . $counter++;
    }

    if ($validated['status'] === 'published') {
      $validated['published_at'] = now();
    }

    Article::create($validated);

    return redirect()->route('admin.articles.index')
      ->with('success', 'Article created successfully.');
  }

  /**
   * Show the form for editing the specified article.
   */
  public function edit(Article $article)
  {
    $categories = Category::all();
    return view('admin.articles.edit', compact('article', 'categories'));
  }

  /**
   * Update the specified article in storage.
   */
  public function update(Request $request, Article $article)
  {
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'category_id' => 'required|exists:categories,id',
      'excerpt' => 'nullable|string|max:500',
      'content' => 'required|string',
      'status' => ['required', Rule::in(['draft', 'published'])],
    ]);

    // Handle slug changes
    if ($article->title !== $validated['title']) {
      $newSlug = Str::slug($validated['title']);

      // Handle duplicate slug
      $originalSlug = $newSlug;
      $counter = 1;
      while (Article::where('slug', $newSlug)->where('id', '!=', $article->id)->exists()) {
        $newSlug = $originalSlug . '-' . $counter++;
      }

      $validated['slug'] = $newSlug;
    }

    // Handle published status changes
    if ($validated['status'] === 'published' && $article->status !== 'published') {
      $validated['published_at'] = now();
    } elseif ($validated['status'] === 'draft') {
      $validated['published_at'] = null;
    }

    $article->update($validated);

    return redirect()->route('admin.articles.index')
      ->with('success', 'Article updated successfully.');
  }

  /**
   * Remove the specified article from storage.
   */
  public function destroy(Article $article)
  {
    $article->delete();

    return redirect()->route('admin.articles.index')
      ->with('success', 'Article deleted successfully.');
  }

  /**
   * Publish the specified article.
   */
  public function publish(Article $article)
  {
    $article->publish();

    return redirect()->route('admin.articles.index')
      ->with('success', 'Article published successfully.');
  }

  /**
   * Draft the specified article.
   */
  public function draft(Article $article)
  {
    $article->draft();

    return redirect()->route('admin.articles.index')
      ->with('success', 'Article drafted successfully.');
  }
}
