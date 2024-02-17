<?php

namespace App\Http\Livewire\Pages\Admin;

use App\Models\Instansion;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ViewUser extends Component
{
    use WithPagination;
    public $search = '';
    public $role = 'All';
    public $instansion = '';

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // Query berdasarkan peran pengguna dan instance yang terkait
        $usersQuery = User::query();

        // Filter berdasarkan peran pengguna
        if ($this->role !== 'All') {
            $usersQuery->whereHas('roles', function ($query) {
                $query->where('name', $this->role);
            });
        }

        // // Filter berdasarkan instance yang terkait
        // if ($this->instansion !== 'All') {
        //     $usersQuery->whereHas('instansion', function ($query) {
        //         $query->where('name', $this->instansion);
        //     });
        // }


        // Ambil data pengguna yang dipaginasi
        $users = $usersQuery->paginate(10);

        // Ambil daftar instance untuk dropdown filter
        $instansions = Instansion::all();

        // Kirim data pengguna dan daftar instance ke tampilan
        return view('livewire.pages.admin.view-user', compact('users', 'instansions'));
    }

    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }



    public function demoteUser($id)
    {
        $user = User::find($id);
        $user->detachRole('admin');
        $user->attachRole('user');
        session()->flash('success', $user->name . ' has been demoted to user');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        session()->flash('success', $user->name . ' has been deleted');
    }

    public function promoteUser($id)
    {
        $user = User::find($id);
        $user->detachRole('user');
        $user->attachRole('admin');
        session()->flash('success', $user->name . ' has been promoted to admin');
    }
}
