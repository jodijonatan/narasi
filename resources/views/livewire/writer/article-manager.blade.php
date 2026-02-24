<div class="article-manager-container">
    <style>
        .article-manager-container {
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            font-family: 'Inter', sans-serif;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-primary {
            background: #4299e1;
            color: white;
        }
        .btn-primary:hover {
            background: #3182ce;
        }
        .btn-secondary {
            background: #edf2f7;
            color: #4a5568;
        }
        .btn-danger {
            background: #f56565;
            color: white;
        }
        .btn-success {
            background: #48bb78;
            color: white;
        }
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-draft { background: #e2e8f0; color: #4a5568; }
        .status-pending { background: #fefcbf; color: #b7791f; }
        .status-published { background: #c6f6d5; color: #2f855a; }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .form-group label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #4a5568;
        }
        .form-group input, .form-group textarea, .form-group select {
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
        }
        .thumbnail-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
            margin-top: 0.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            text-align: left;
            padding: 1rem;
            border-bottom: 2px solid #e2e8f0;
            color: #4a5568;
        }
        td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
    </style>

    <div class="header">
        <h2 class="title">Manajemen Artikel Saya</h2>
        <button wire:click="create" class="btn btn-primary">+ Tulis Artikel</button>
    </div>

    @if (session()->has('message'))
        <div style="background: #c6f6d5; color: #2f855a; padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">
            {{ session('message') }}
        </div>
    @endif

    <div style="margin-bottom: 1rem;">
        <input type="text" wire:model.live="search" placeholder="Cari artikel..." style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px; width: 300px;">
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $article->title }}</div>
                            <div style="font-size: 0.75rem; color: #718096;">{{ $article->slug }}</div>
                        </td>
                        <td>{{ $article->category->name }}</td>
                        <td>
                            <span class="status-badge status-{{ $article->status }}">
                                {{ $article->status }}
                            </span>
                        </td>
                        <td>{{ $article->created_at->format('d M Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <button wire:click="edit({{ $article->id }})" class="btn btn-secondary" style="padding: 0.4rem 0.8rem;">Edit</button>
                                @if($article->status === 'draft')
                                    <button wire:click="submitForReview({{ $article->id }})" class="btn btn-success" style="padding: 0.4rem 0.8rem;">Kirim</button>
                                @endif
                                <button onclick="confirm('Hapus artikel ini?') || event.stopImmediatePropagation()" 
                                        wire:click="delete({{ $article->id }})" class="btn btn-danger" style="padding: 0.4rem 0.8rem;">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1rem;">
        {{ $articles->links() }}
    </div>

    <!-- Create/Edit Modal -->
    @if($showCreateModal)
        <div class="modal-overlay">
            <div class="modal-content">
                <h3>{{ $isEditing ? 'Edit Artikel' : 'Tulis Artikel Baru' }}</h3>
                <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: span 2;">
                            <label>Judul Artikel</label>
                            <input type="text" wire:model.live="title" placeholder="Masukkan judul yang menarik...">
                            @error('title') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Kategori</label>
                            <select wire:model="categoryId">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('categoryId') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Thumbnail Artikel</label>
                            <input type="file" wire:model="thumbnail">
                            @if ($thumbnail)
                                <img src="{{ $thumbnail->temporaryUrl() }}" class="thumbnail-preview">
                            @endif
                            @error('thumbnail') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label>Ringkasan (Excerpt)</label>
                            <textarea wire:model="excerpt" rows="2" placeholder="Ringkasan singkat artikel..."></textarea>
                            @error('excerpt') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label>Konten Artikel</label>
                            <textarea wire:model="content" rows="10" placeholder="Tulis isi artikel di sini..."></textarea>
                            @error('content') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                        <button type="button" wire:click="$set('showCreateModal', false)" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Update Artikel' : 'Simpan Draft' }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
