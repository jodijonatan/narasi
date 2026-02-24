<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slug',
    'description',
  ];

  /**
   * Boot the model.
   */
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($category) {
      if (empty($category->slug)) {
        $category->slug = Str::slug($category->name);
      }
    });

    static::updating(function ($category) {
      if (empty($category->slug)) {
        $category->slug = Str::slug($category->name);
      }
    });
  }

  /**
   * Get the articles for the category.
   */
  public function articles()
  {
    return $this->hasMany(Article::class);
  }

  /**
   * Get published articles for the category.
   */
  public function publishedArticles()
  {
    return $this->hasMany(Article::class)->where('status', 'published');
  }
}
