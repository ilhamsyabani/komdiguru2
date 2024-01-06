<?php

namespace App\Http\Livewire\Pages\Rule;

use App\Models\Rule;
use Livewire\Component;

class ViewRule extends Component
{
    public function render()
    {
        return view('livewire.pages.rule.view-rule', [
            'rules' => Rule::all(),
        ]);
    }

    public function mount()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function editRule($id)
    {
        return redirect()->route('edit-rule', ['ruleId' => $id]);
    }

    public function changeStatus($id)
    {
        $rule = Rule::find($id);

        if (!$rule) {
            session()->flash('error', 'Rule not found.');
            return;
        }

        try {
            $rule->update(['status' => !$rule->status]);
            session()->flash('success', 'Rule ' . ($rule->status ? 'disabled' : 'enabled') . ' successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating rule status.');
        }
    }
}
