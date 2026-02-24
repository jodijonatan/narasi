<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CategoryManager extends Component
{
    use WithPagination;

    public $name, $slug, $description, $categoryId;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|min:3|unique:categories,name',
        'description' => 'nullable|max:255',
    ];

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function render()
    {
        return view('livewire.admin.category-manager', [
            'categories' => Category::where('name', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10)
        ])->layout('layouts.app');
    }

    public function resetFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->categoryId = null;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'slug' => $this->slug ?: Str::slug($this->name),
            'description' => $this->description,
        ]);

        session()->flash('message', 'Category created successfully.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3|unique:categories,name,' . $this->categoryId,
            'description' => 'nullable|max:255',
        ]);

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
            'slug' => $this->slug ?: Str::slug($this->name),
            'description' => $this->description,
        ]);

        session()->flash('message', 'Category updated successfully.');
        $this->resetFields();
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'Category deleted successfully.');
    }
}
