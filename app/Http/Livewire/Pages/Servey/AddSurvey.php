<?php

namespace App\Http\Livewire\Pages\Servey;

use App\Models\Category;
use Livewire\Component;

class AddSurvey extends Component
{
    public $questions = [];
    public $option_id = [];
    public $category_result_id =[];
    public $category_id=[];
    
    
    public function render()
    {
        return view('livewire.pages.servey.add-survey',[
            'categories'=>Category::all(),
        ]);
    }

    public function addResult($category_id)
    {
       
    }

}
