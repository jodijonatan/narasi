<div class="verification-container">
    <style>
        .verification-container {
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            font-family: 'Inter', sans-serif;
        }
        .header {
            margin-bottom: 2rem;
        }
        .title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
        }
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-primary { background: #4299e1; color: white; }
        .btn-secondary { background: #edf2f7; color: #4a5568; }
        .btn-danger { background: #f56565; color: white; }
        .btn-success { background: #48bb78; color: white; }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            width: 95%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
        }
        .article-preview h1 { font-size: 2rem; margin-bottom: 1rem; }
        .article-meta { color: #718096; margin-bottom: 2rem; display: flex; gap: 1rem; }
        .article-body { line-height: 1.8; color: #2d3748; font-size: 1.1rem; }
        .thumbnail-full { width: 100%; height: 300px; object-fit: cover; border-radius: 8px; margin-bottom: 2rem; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1rem; border-bottom: 2px solid #e2e8f0; }
        td { padding: 1rem; border-bottom: 1px solid #e2e8f0; }
    </style>

    <div class="header">
        <h2 class="title">Verifikasi Artikel</h2>
        <p style="color: #718096;">Tinjau artikel yang menunggu persetujuan sebelum diterbitkan.</p>
    </div>

    @if (session()->has('message'))
        <div style="background: #c6f6d5; color: #2f855a; padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">
            {{ session('message') }}
        </div>
    @endif

    <div style="margin-bottom: 1rem;">
        <input type="text" wire:model.live="search" placeholder="Cari artikel pending..." style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px; width: 300px;">
    </div>

    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Tanggal Kirim</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendingArticles as $article)
                <tr>
                    <td><strong>{{ $article->title }}</strong></td>
                    <td>{{ $article->user->name }}</td>
                    <td>{{ $article->category->name }}</td>
                    <td>{{ $article->updated_at->format('d M Y H:i') }}</td>
                    <td>
                        <button wire:click="review({{ $article->id }})" class="btn btn-primary">Tinjau</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem; color: #a0aec0;">Tidak ada artikel yang menunggu verifikasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 1rem;">
        {{ $pendingArticles->links() }}
    </div>

    @if($showReviewModal && $selectedArticle)
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="article-preview">
                    @if($selectedArticle->thumbnail)
                        <img src="{{ Storage::url($selectedArticle->thumbnail) }}" class="thumbnail-full">
                    @endif
                    <h1>{{ $selectedArticle->title }}</h1>
                    <div class="article-meta">
                        <span>Oleh: <strong>{{ $selectedArticle->user->name }}</strong></span>
                        <span>Kategori: <strong>{{ $selectedArticle->category->name }}</strong></span>
                    </div>
                    <div class="article-body">
                        {!! nl2br(e($selectedArticle->content)) !!}
                    </div>
                </div>

                <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 1rem;">
                    <button wire:click="$set('showReviewModal', false)" class="btn btn-secondary">Tutup</button>
                    <button wire:click="reject({{ $selectedArticle->id }})" class="btn btn-danger">Tolak (Revisi)</button>
                    <button wire:click="approve({{ $selectedArticle->id }})" class="btn btn-success">Setujui & Terbitkan</button>
                </div>
            </div>
        </div>
    @endif
</div>
