<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
  use HasFactory;

  protected $fillable = [
    'category_id',
    'user_id',
    'title',
    'slug',
    'excerpt',
    'content',
    'thumbnail',
    'status',
    'published_at',
  ];

  protected $casts = [
    'published_at' => 'datetime',
  ];

  /**
   * Boot the model.
   */
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($article) {
      if (empty($article->slug)) {
        $article->slug = Str::slug($article->title);
      }
    });

    static::updating(function ($article) {
      if (empty($article->slug)) {
        $article->slug = Str::slug($article->title);
      }
    });
  }

  /**
   * Get the category that owns the article.
   */
  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  /**
   * Get the user that owns the article.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Scope a query to only include published articles.
   */
  public function scopePublished($query)
  {
    return $query->where('status', 'published');
  }

  /**
   * Scope a query to only include pending articles.
   */
  public function scopePending($query)
  {
    return $query->where('status', 'pending');
  }

  /**
   * Scope a query to only include draft articles.
   */
  public function scopeDraft($query)
  {
    return $query->where('status', 'draft');
  }

  /**
   * Check if article is published.
   */
  public function isPublished(): bool
  {
    return $this->status === 'published';
  }

  /**
   * Check if article is pending.
   */
  public function isPending(): bool
  {
    return $this->status === 'pending';
  }

  /**
   * Check if article is draft.
   */
  public function isDraft(): bool
  {
    return $this->status === 'draft';
  }

  /**
   * Publish the article.
   */
  public function publish()
  {
    $this->update([
      'status' => 'published',
      'published_at' => now(),
    ]);
  }

  /**
   * Set article to pending.
   */
  public function setPending()
  {
    $this->update([
      'status' => 'pending',
    ]);
  }

  /**
   * Draft the article.
   */
  public function draft()
  {
    $this->update([
      'status' => 'draft',
      'published_at' => null,
    ]);
  }
}
