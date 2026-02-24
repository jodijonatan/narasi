<div class="article-detail">
    <style>
        .article-detail {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            font-family: 'Inter', sans-serif;
            line-height: 1.8;
            color: #2d3748;
        }
        .header { margin-bottom: 3rem; text-align: center; }
        .back-link { 
            display: inline-flex; 
            align-items: center; 
            margin-bottom: 2rem; 
            color: #4a5568; 
            text-decoration: none; 
            font-weight: 600; 
            transition: color 0.2s;
        }
        .back-link:hover { color: #4299e1; }
        
        .categoryBadge {
            background: #ebf8ff;
            color: #2b6cb0;
            padding: 0.25rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 1rem;
            display: inline-block;
        }
        
        .title { font-size: 3rem; font-weight: 800; line-height: 1.2; color: #1a202c; margin-bottom: 1.5rem; }
        .meta { 
            display: flex; 
            justify-content: center; 
            gap: 1.5rem; 
            color: #718096; 
            font-size: 1rem; 
            margin-bottom: 2rem; 
            border-top: 1px solid #edf2f7; 
            border-bottom: 1px solid #edf2f7; 
            padding: 1rem 0;
        }
        
        .thumbnail-container { margin-bottom: 3rem; }
        .thumbnail { width: 100%; height: auto; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        
        .content { font-size: 1.25rem; }
        .content p { margin-bottom: 1.5rem; }
        
        .footer { margin-top: 4rem; padding-top: 2rem; border-top: 1px solid #edf2f7; }
        .author-box { display: flex; align-items: center; gap: 1rem; background: #f7fafc; padding: 1.5rem; border-radius: 12px; }
        .author-info h4 { margin: 0; font-size: 1.125rem; color: #1a202c; }
        .author-info p { margin: 0; font-size: 0.875rem; color: #718096; }

        @media (max-width: 640px) {
            .title { font-size: 2rem; }
            .article-detail { padding: 1rem; }
        }
    </style>

    <a href="{{ route('home') }}" class="back-link">
        <svg style="width: 20px; height: 20px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Beranda
    </a>

    <article>
        <header class="header">
            <span class="categoryBadge">{{ $article->category->name }}</span>
            <h1 class="title">{{ $article->title }}</h1>
            <div class="meta">
                <span>Oleh <strong>{{ $article->user->name }}</strong></span>
                <span>Terbit pada {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
            </div>
        </header>

        @if($article->thumbnail)
            <div class="thumbnail-container">
                <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="thumbnail">
            </div>
        @endif

        <div class="content">
            {!! nl2br(e($article->content)) !!}
        </div>

        <footer class="footer">
            <div class="author-box">
                <div style="width: 50px; height: 50px; background: #4299e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.25rem;">
                    {{ substr($article->user->name, 0, 1) }}
                </div>
                <div class="author-info">
                    <h4>{{ $article->user->name }}</h4>
                    <p>Penulis di Narasi</p>
                </div>
            </div>
        </footer>
    </article>
</div>
