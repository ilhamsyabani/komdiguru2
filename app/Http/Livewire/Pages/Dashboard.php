<?php

namespace App\Http\Livewire\Pages;

use App\Models\Content;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.pages.dashboard',[
            'content' => Content::find(2),
        ]);
    }

    public function mount()
    {
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user')) {
            Auth::user()->attachRole('user');
        }
    }
}