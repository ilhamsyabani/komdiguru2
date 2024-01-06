<?php

namespace App\Http\Livewire\Pages\Option;

use App\Models\Option;
use Livewire\Component;
use Livewire\WithPagination;

class ViewOption extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function deleteOption($id)
    {
        $option = Option::find($id);
        $option->delete();
        session()->flash('success', $option->name . ' has been deleted');
    }

    public function editOption($id)
    {
        return redirect()->route('edit-option', ['optionId' => $id]);
    }

    public function render()
    {
        return view('livewire.pages.option.view-option',  [
            'options' => Option::paginate(10),
        ]);
    }
}
