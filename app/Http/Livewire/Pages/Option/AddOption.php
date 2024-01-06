<?php

namespace App\Http\Livewire\Pages\Option;

use App\Models\Option;
use App\Models\Question;
use Livewire\Component;

class AddOption extends Component
{
    public $option_text;
    public $question_id;

    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function addOption()
    {
        $this->validate([
            'option_text' => 'required',
            'question_id' => 'required',
        ]);

        $question = Option::create([
            'option_text' => $this->option_text,
            'question_id' => $this->question_id, // Fix: Use $this->address instead of $this->email
        ]);

        $this->resetInput();

        session()->flash('success', 'Instansion added successfully');
    }

    public function resetInput()
    {
        $this->option_text = null;
        $this->question_id = null;
    }

    public function render()
    {
        return view('livewire.pages.option.add-option',[
            'questions'=>Question::all(),
        ]);
    }
}
