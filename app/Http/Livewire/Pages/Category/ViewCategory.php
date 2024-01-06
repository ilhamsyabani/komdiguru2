<?php

namespace App\Http\Livewire\Pages\Category;

use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Component;

class ViewCategory extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.pages.category.view-category', [
            'categories' => Category::paginate(10),
        ]);
    }

    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        session()->flash('success', $category->name . ' has been deleted');
    }

    // Update to navigate to the edit form
    public function editCategory($id)
    {
        // Redirect to the edit category route
        return redirect()->route('edit-category', ['categoryId' => $id]);
    }
}
