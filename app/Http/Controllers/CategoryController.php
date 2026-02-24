<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
  /**
   * Display a listing of the categories for admin.
   */
  public function index()
  {
    $categories = Category::withCount('articles')->latest()->paginate(20);

    return view('admin.categories.index', compact('categories'));
  }

  /**
   * Show the form for creating a new category.
   */
  public function create()
  {
    return view('admin.categories.create');
  }

  /**
   * Store a newly created category in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:categories,name',
      'description' => 'nullable|string',
    ]);

    $validated['slug'] = Str::slug($validated['name']);

    Category::create($validated);

    return redirect()->route('admin.categories.index')
      ->with('success', 'Category created successfully.');
  }

  /**
   * Show the form for editing the specified category.
   */
  public function edit(Category $category)
  {
    return view('admin.categories.edit', compact('category'));
  }

  /**
   * Update the specified category in storage.
   */
  public function update(Request $request, Category $category)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
      'description' => 'nullable|string',
    ]);

    // Handle slug changes
    if ($category->name !== $validated['name']) {
      $validated['slug'] = Str::slug($validated['name']);
    }

    $category->update($validated);

    return redirect()->route('admin.categories.index')
      ->with('success', 'Category updated successfully.');
  }

  /**
   * Remove the specified category from storage.
   */
  public function destroy(Category $category)
  {
    // Check if category has articles
    if ($category->articles()->count() > 0) {
      return redirect()->route('admin.categories.index')
        ->with('error', 'Cannot delete category with articles. Please delete or reassign articles first.');
    }

    $category->delete();

    return redirect()->route('admin.categories.index')
      ->with('success', 'Category deleted successfully.');
  }
}
