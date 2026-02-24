<div class="user-manager-container">
    <style>
        .user-manager-container {
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            font-family: 'Inter', sans-serif;
        }
        .header { margin-bottom: 2rem; }
        .title { font-size: 1.5rem; font-weight: 700; color: #1a202c; }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            font-size: 0.875rem;
        }
        .btn-danger { background: #f56565; color: white; }
        .btn-secondary { background: #edf2f7; color: #4a5568; }

        .select-role {
            padding: 0.4rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: white;
            font-size: 0.875rem;
        }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1rem; border-bottom: 2px solid #e2e8f0; color: #4a5568; }
        td { padding: 1rem; border-bottom: 1px solid #e2e8f0; }
        
        .alert { padding: 1rem; border-radius: 6px; margin-bottom: 1rem; font-weight: 600; }
        .alert-success { background: #c6f6d5; color: #2f855a; }
        .alert-danger { background: #fed7d7; color: #c53030; }
    </style>

    <div class="header">
        <h2 class="title">Manajemen Pengguna</h2>
        <p style="color: #718096;">Kelola akun pengguna dan hak akses mereka.</p>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div style="margin-bottom: 1rem;">
        <input type="text" wire:model.live="search" placeholder="Cari nama atau email..." style="padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px; width: 300px;">
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <select class="select-role" wire:change="changeRole({{ $user->id }}, $event.target.value)">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User/Penulis</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <button onclick="confirm('Hapus user ini?') || event.stopImmediatePropagation()" 
                                wire:click="deleteUser({{ $user->id }})" class="btn btn-danger">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 1rem;">
        {{ $users->links() }}
    </div>
</div>
