<div class="category-manager-container">
    <style>
        .category-manager-container {
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
        .form-section {
            background: #f7fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .form-group label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #4a5568;
        }
        .form-group input, .form-group textarea {
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        .form-group input:focus {
            border-color: #4299e1;
            outline: none;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
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
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th {
            text-align: left;
            padding: 1rem;
            background: #edf2f7;
            color: #4a5568;
            font-weight: 600;
        }
        td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .alert-success {
            background: #c6f6d5;
            color: #2f855a;
        }
        .search-input {
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 1rem;
            width: 300px;
        }
    </style>

    <div class="header">
        <h2 class="title">Manajemen Kategori</h2>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="form-section">
        <h3>{{ $isEditing ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h3>
        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" wire:model.live="name" placeholder="Contoh: Teknologi">
                    @error('name') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Slug (Otomatis)</label>
                    <input type="text" wire:model="slug" readonly style="background: #f1f5f9;">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Deskripsi</label>
                    <textarea wire:model="description" rows="3"></textarea>
                    @error('description') <span style="color:red; font-size:12px;">{{ $message }}</span> @enderror
                </div>
            </div>
            <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary">
                    {{ $isEditing ? 'Update Kategori' : 'Simpan Kategori' }}
                </button>
                @if($isEditing)
                    <button type="button" wire:click="resetFields" class="btn btn-secondary">Batal</button>
                @endif
            </div>
        </form>
    </div>

    <div class="table-container">
        <div style="display: flex; justify-content: flex-end;">
            <input type="text" wire:model.live="search" placeholder="Cari kategori..." class="search-input">
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>{{ Str::limit($category->description, 50) }}</td>
                        <td class="actions">
                            <button wire:click="edit({{ $category->id }})" class="btn btn-secondary" style="padding: 0.4rem 0.8rem;">Edit</button>
                            <button onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()" 
                                    wire:click="delete({{ $category->id }})" class="btn btn-danger" style="padding: 0.4rem 0.8rem;">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 1rem;">
            {{ $categories->links() }}
        </div>
    </div>
</div>
