<?php

namespace App\Http\Livewire\Pages\Content;

use App\Models\Content;
use Livewire\Component;

class EditContent extends Component
{
    public $contentId;
    public $title;
    public $content;
    public $as;


    public function mount($contentId)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        $this->contentId = $contentId;

        $content = Content::find($contentId);

        if ($content) {
            $this->title = $content->title;
            $this->content = $content->content;
            $this->as = $content->as;
        }
    }

    public function updateContent()
    {
        $this->validate([
            'title' => 'required|min:3',
            'content' => 'required',
        ]);

        $content = Content::find($this->contentId);

        if ($content) {
            $content->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);


            session()->flash('success', 'Content updated successfully');
        }

        return redirect()->route('content');
    }

    public function render()
    {
        return view('livewire.pages.content.edit-content');
    }
}
