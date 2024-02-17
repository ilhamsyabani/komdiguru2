<?php

namespace App\Http\Livewire\Pages\Content;

use App\Models\Content;
use Livewire\Component;

class ShowContent extends Component
{
    public function render()
    {
        return view('livewire.pages.content.show-content',[
            'contents' => Content::all(),
        ]);
    }

    public function editContent($id)
    {
        // Redirect to the edit category route
        return redirect()->route('edit-content', ['contentId' => $id]);
    }
}
