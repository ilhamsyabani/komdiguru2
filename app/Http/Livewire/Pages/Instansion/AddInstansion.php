<?php

namespace App\Http\Livewire\Pages\Instansion;

use Livewire\Component;
use App\Models\Instansion;

class AddInstansion extends Component
{

    public $name;
    public $address;

    public function render()
    {
        return view('livewire.pages.instansion.add-instansion');
    }

    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function addInstansion()
    {
        $this->validate([
            'name' => 'required|min:3',
            'address' => 'required|unique:instansions',
        ]);

        $instansion = Instansion::create([
            'name' => $this->name,
            'address' => $this->address, // Fix: Use $this->address instead of $this->email
        ]);

        $this->resetInput();

        session()->flash('success', 'Instansion added successfully');
    }

    public function resetInput()
    {
        $this->name = null;
        $this->address = null;
    }
}
