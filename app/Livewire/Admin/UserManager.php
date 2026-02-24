<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.admin.user-manager', [
            'users' => User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10)
        ])->layout('layouts.app');
    }

    public function changeRole($userId, $newRole)
    {
        $user = User::findOrFail($userId);
        $user->update(['role' => $newRole]);
        session()->flash('message', "Role user {$user->name} berhasil diubah menjadi {$newRole}.");
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        if ($user->id === auth()->id()) {
            session()->flash('error', "Anda tidak dapat menghapus akun Anda sendiri!");
            return;
        }
        $user->delete();
        session()->flash('message', "User berhasil dihapus.");
    }
}
