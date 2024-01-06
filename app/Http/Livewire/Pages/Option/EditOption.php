<?php

namespace App\Http\Livewire\Pages\Option;

use App\Models\Option as ModelsOption;
use App\Models\Question;
use App\Models\Option;
use Livewire\Component;

class EditOption extends Component
{
    public $optionId;
    public $option_text;
    public $question_id;

    public function mount($optionId)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        $this->optionId = $optionId;

        $option = Option::find($optionId);

        if ($option) {
            $this->question_id = $option->question_id;
            $this->option_text = $option->option_text;
        }
    }

    public function updateOption()
    {
        $this->validate([
            'question_id' => 'required',
            'option_text' => 'required',
        ]);

        $option = Option::find($this->optionId);

        if ($option) {
            $option->update([
                'option_text' => $this->option_text,
                'question_id' => $this->question_id,
            ]);

            session()->flash('success', 'Option updated successfully');
        }

        return redirect()->route('view-option');
    }

    public function render()
    {
        return view('livewire.pages.option.edit-option', [
            'questions' => Question::all(),
        ]);
    }
}
