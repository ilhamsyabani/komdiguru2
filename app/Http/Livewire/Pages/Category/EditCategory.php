<?php

namespace App\Http\Livewire\Pages\Category;

use App\Models\Category;
use App\Models\Range;
use Livewire\Component;

class EditCategory extends Component
{
    public $categoryId;
    public $name;
    public $score = [];
    public $min = [];
    public $max = [];
    public $feedback = [];

    public function mount($categoryId)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        $this->categoryId = $categoryId;
 
        $category = Category::find($categoryId);

        if ($category) {
            $this->name = $category->name;

            $ranges = Range::where('category_id', $categoryId)->get();

            foreach ($ranges as $range) {
                $this->score[] = $range->score;
                $this->min[] = $range->min;
                $this->max[] = $range->max;
                $this->feedback[] = $range->feedback;
            }
        }
    }

    public function editCategory()
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


        $category = Category::find($this->categoryId);
        if ($category) {
            $category->update([
                'name' => $this->name,
            ]);

            // Use the correct relationship method to delete related ranges
            $category->ranges()->delete();

            $ranges = [];

            for ($i = 0; $i < count($this->score); $i++) {
                $ranges[] = [
                    'category_id' => $category->id,
                    'score' => $this->score[$i],
                    'min' => $this->min[$i],
                    'max' => $this->max[$i],
                    'feedback' => $this->feedback[$i],
                ];
            }

            Range::insert($ranges);

            session()->flash('success', 'Category updated successfully');
        }

        return redirect()->route('view-category');
    }

    public function render()
    {
        return view('livewire.pages.category.edit-category');
    }
}
