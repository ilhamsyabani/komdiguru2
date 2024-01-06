<?php

namespace App\Http\Livewire\Pages\Category;

use App\Models\Range;
use App\Models\Category; // Fix: Correct the model name
use Livewire\Component;

class AddCategory extends Component
{
    public $name;
    public $score = [];
    public $min = [];
    public $max = [];
    public $feedback = [];

    public function render()
    {
        return view('livewire.pages.category.add-category');
    }

    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function addCategory()
    {
        $this->validate([
            'name' => 'required|min:3',
            'score' => 'required|array|min:1',
            'score.*' => 'required|string',
            'min' => 'required|array|min:1',
            'min.*' => 'required|numeric',
            'max' => 'required|array|min:1',
            'max.*' => 'required|numeric',
            'feedback' => 'required|array|min:1',
            'feedback.*' => 'required|string',
        ]);

        $category = Category::create([
            'name' => $this->name,
        ]);

        $ranges = [];

        for ($i = 0; $i < count($this->score); $i++) {
            $ranges[] = [
                'category_id' => $category->id, // Fix: Use $category->id instead of $this->id
                'score' => $this->score[$i],
                'min' => $this->min[$i],
                'max' => $this->max[$i],
                'feedback' => $this->feedback[$i],
            ];
        }

        Range::insert($ranges);

        $this->resetInput();

        session()->flash('success', 'Category added successfully');
    }

    public function resetInput()
    {
        $this->name = null;
        $this->score = [];
        $this->min = [];
        $this->max = [];
        $this->feedback = [];
    }
}
