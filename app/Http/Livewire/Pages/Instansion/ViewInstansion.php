<?php

namespace App\Http\Livewire\Pages\Instansion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Instansion;

class ViewInstansion extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.pages.instansion.view-instansion', [
            'instansions' => Instansion::paginate(10),
        ]);
    }

    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function toggleActive($id)
    {
        $instansion = Instansion::find($id);

        if (!$instansion) {
            session()->flash('error', 'Instansion not found.');
            return;
        }

        try {
            $instansion->update(['isActive' => !$instansion->isActive]);
            session()->flash('success', 'instansion ' . ($instansion->isActive ? '1' : '0') . ' successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating instansion status.');
        }
    }

    public function deleteInstansion($id)
    {
        $instansion = Instansion::find($id);
        $instansion->delete();
        session()->flash('success', $instansion->name . ' has been deleted');
    }

}
