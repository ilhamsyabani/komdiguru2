<?php

namespace App\Http\Livewire\Pages\Question;

use App\Models\Category;
use App\Models\Option;
use App\Models\Question;
use Livewire\Component;

class AddQuestion extends Component
{
    public $category_id;
    public $question_text;
    public $option_text = [];
    

    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function addQuestion()
    {

        $this->validate([
            'category_id' => 'required',
            'question_text' => 'required',
            'option_text.*' => 'required|string',
        ]);

        $question = Question::create([
            'category_id' => $this->category_id,
            'question_text' => $this->question_text, // Fix: Use $this->address instead of $this->email
        ]);

        $option = $this->option_text;

        foreach($option as $key => $value){
            Option::create([
                'question_id' => $question->id,
                'option_text' => $value,
                'points' => $key,
            ]);
    
        }

        $this->resetInput();

        session()->flash('success', 'Instansion added successfully');
    }

    public function resetInput()
    {
        $this->category_id = null;
        $this->question_text = null;
    }

    public function render()
    {
        return view('livewire.pages.question.add-question',[
            'categories' => Category::all(),
        ]);
    }
}
