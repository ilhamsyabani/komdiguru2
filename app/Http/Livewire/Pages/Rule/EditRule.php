<?php

namespace App\Http\Livewire\Pages\Rule;

use App\Models\Rule;
use Livewire\Component;

class EditRule extends Component
{
    public $ruleId;
    public $filling_limit;
    public $alowed_time;

    public function mount($ruleId = null)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        $this->ruleId = $ruleId;
        
        if ($this->ruleId) {
            $rule = Rule::find($this->ruleId);
            if ($rule) {
                $this->filling_limit = $rule->filling_limit;
                $this->alowed_time = $rule->alowed_time;
            }
        }
    }

    public function editRule()
    {
        $this->validate([
            'filling_limit' => 'required',
            'alowed_time' => 'required',
        ]);

        $data = [
            'filling_limit' => $this->filling_limit,
            'alowed_time' => $this->alowed_time,
        ];

        if ($this->ruleId) {
            Rule::find($this->ruleId)->update($data);
            session()->flash('success', 'Rule updated successfully');
        } else {
            Rule::create($data);
            session()->flash('success', 'Rule added successfully');
        }

        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.pages.rule.edit-rule');
    }

    public function resetInput()
    {
        return redirect()->route('view-rule');;
    }
}
