<div class="public-home">
    <style>
        .public-home {
            font-family: 'Inter', sans-serif;
            color: #2d3748;
        }
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            border-radius: 16px;
            margin-bottom: 3rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .hero h1 { font-size: 3rem; font-weight: 800; margin-bottom: 1rem; }
        .hero p { font-size: 1.25rem; opacity: 0.9; }

        .search-container {
            max-width: 600px;
            margin: -2rem auto 3rem;
            position: relative;
            z-index: 10;
        }
        .search-container input {
            width: 100%;
            padding: 1.25rem 1.5rem;
            border-radius: 9999px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            font-size: 1.125rem;
            outline: none;
        }

        .content-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
        }

        .sidebar h3 { font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; border-bottom: 2px solid #edf2f7; padding-bottom: 0.5rem; }
        .category-list { list-style: none; padding: 0; }
        .category-item { 
            padding: 0.75rem 1rem; 
            border-radius: 8px; 
            cursor: pointer; 
            transition: background 0.2s;
            display: flex;
            justify-content: space-between;
        }
        .category-item:hover { background: #edf2f7; }
        .category-item.active { background: #4299e1; color: white; }

        .article-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }
        .article-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }
        .article-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 12px 20px rgba(0,0,0,0.1); 
        }
        .card-image { width: 100%; height: 200px; object-fit: cover; background: #f7fafc; }
        .card-content { padding: 1.5rem; flex-grow: 1; }
        .card-category { color: #4299e1; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem; }
        .card-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; line-height: 1.4; color: #1a202c; }
        .card-excerpt { color: #718096; font-size: 0.875rem; margin-bottom: 1.5rem; line-height: 1.6; }
        .card-footer { display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #a0aec0; }

        @media (max-width: 768px) {
            .content-layout { grid-template-columns: 1fr; }
            .sidebar { order: 2; }
            .hero h1 { font-size: 2rem; }
        }
    </style>

    <div class="hero">
        <h1>Narasi</h1>
        <p>Temukan Cerita, Wawasan, dan Inspirasi Terbaru.</p>
    </div>

    <div class="search-container">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari artikel menarik...">
    </div>

    <div class="content-layout">
        <aside class="sidebar">
            <h3>Kategori</h3>
            <ul class="category-list">
                <li class="category-item {{ $category === '' ? 'active' : '' }}" wire:click="$set('category', '')">
                    <span>Semua Kategori</span>
                    <span>{{ \App\Models\Article::published()->count() }}</span>
                </li>
                @foreach($categories as $cat)
                    <li class="category-item {{ $category === $cat->slug ? 'active' : '' }}" wire:click="$set('category', '{{ $cat->slug }}')">
                        <span>{{ $cat->name }}</span>
                        <span>{{ $cat->published_articles_count }}</span>
                    </li>
                @endforeach
            </ul>
        </aside>

        <main>
            <div class="article-grid">
                @forelse($articles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}" class="article-card" style="text-decoration: none;">
                        @if($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}" class="card-image" alt="{{ $article->title }}">
                        @else
                            <div class="card-image" style="display: flex; align-items: center; justify-content: center; background: #edf2f7;">
                                <svg style="width: 48px; color: #cbd5e0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="card-content">
                            <div class="card-category">{{ $article->category->name }}</div>
                            <h2 class="card-title">{{ $article->title }}</h2>
                            <p class="card-excerpt">{{ Str::limit($article->excerpt ?: strip_tags($article->content), 120) }}</p>
                            <div class="card-footer">
                                <span>Oleh {{ $article->user->name }}</span>
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div style="grid-column: span 3; text-align: center; padding: 4rem; color: #a0aec0;">
                        Tidak ada artikel yang ditemukan.
                    </div>
                @endforelse
            </div>

            <div style="margin-top: 3rem;">
                {{ $articles->links() }}
            </div>
        </main>
    </div>
</div>
