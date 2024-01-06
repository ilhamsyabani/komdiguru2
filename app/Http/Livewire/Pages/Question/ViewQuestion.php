<?php

namespace App\Http\Livewire\Pages\Question;

use App\Models\Question;
use Livewire\WithPagination;
use Livewire\Component;

class ViewQuestion extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';


    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function deleteQuestion($id)
    {
        $question = Question::find($id);
        $question->delete();
        session()->flash('success', $question->name . ' has been deleted');
    }

    public function editQuestion($id)
    {
        // Redirect to the edit category route
        return redirect()->route('edit-question', ['questionId' => $id]);
    }

    public function render()
    {
        return view('livewire.pages.question.view-question',  [
            'questions' => Question::paginate(10),
        ]);
    }
}
