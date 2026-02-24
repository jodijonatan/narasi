<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $categories = [
      [
        'name' => 'Technology',
        'slug' => 'technology',
        'description' => 'Articles about technology and innovation',
      ],
      [
        'name' => 'Lifestyle',
        'slug' => 'lifestyle',
        'description' => 'Articles about lifestyle and living',
      ],
      [
        'name' => 'Business',
        'slug' => 'business',
        'description' => 'Articles about business and entrepreneurship',
      ],
      [
        'name' => 'Health',
        'slug' => 'health',
        'description' => 'Articles about health and wellness',
      ],
      [
        'name' => 'Travel',
        'slug' => 'travel',
        'description' => 'Articles about travel and adventure',
      ],
    ];

    foreach ($categories as $category) {
      Category::create($category);
    }
  }
}
