<?php

namespace App\Http\Livewire\Pages\Admin;

use App\Models\Instansion;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AddUser extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $instansion_id;

    public function render()
    {
        return view('livewire.pages.admin.add-user',[
            'instansions' => Instansion::all(),
        ]);
    }

    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function addUser()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'instansion_id' => $this->instansion_id,
        ]);

        $user->attachRole('reviewer');

        $this->resetInput();

        session()->flash('success', 'User added successfully');
    }

    public function resetInput()
    {
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->password_confirmation = null;
        $this->instansion_id = null;
    }
}