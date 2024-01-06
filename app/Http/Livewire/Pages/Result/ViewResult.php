<?php

namespace App\Http\Livewire\Pages\Result;

use App\Models\Result;
use Livewire\Component;
use Livewire\WithPagination;

class ViewResult extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.pages.result.view-result',[
            'results' => Result::paginate(10),
        ]);
    }

    public function viewResult($id)
    {
        return redirect()->route('detail.result', ['result'=> $id]);
        //return redirect()->route('survey.results', ['result_id'=> $id]);
    }

    public function deleteResult()
    {

    }
}
