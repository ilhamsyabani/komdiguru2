<?php

namespace App\Http\Livewire\Pages\Question;

use App\Models\Category;
use App\Models\Option;
use App\Models\Question;
use Livewire\Component;

class EditQuestion extends Component
{
    public $questionId;
    public $option_text = [];
    public $category_id;
    public $question_text;

    public function mount($questionId)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        $this->questionId = $questionId;

        $question = Question::find($questionId);

        if ($question) {
            $this->category_id = $question->category_id;
            $this->question_text = $question->question_text;

            $options = $question->options;
            $this->option_text = $options->pluck('option_text')->toArray();
        }
    }

    public function updateQuestion()
    {
        $this->validate([
            'category_id' => 'required',
            'question_text' => 'required',
            'option_text.*' => 'required|string',
        ]);
    
        $question = Question::find($this->questionId);
    
        if ($question) {
            $question->update([
                'category_id' => $this->category_id,
                'question_text' => $this->question_text,
            ]);
    
            // Update or create options
            foreach ($this->option_text as $key => $optionText) {
                Option::updateOrCreate(
                    ['question_id' => $question->id, 'points' => $key + 1],
                    ['option_text' => $optionText]
                );
            }
    
            session()->flash('success', 'Question updated successfully');
        }
    
        return redirect()->route('view-question');
    }
    

    public function render()
    {
        return view('livewire.pages.question.edit-question', [
            'categories' => Category::all(),
        ]);
    }
}
