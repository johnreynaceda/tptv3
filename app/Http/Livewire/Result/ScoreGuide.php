<?php

namespace App\Http\Livewire\Result;

use Livewire\Component;
use App\Models\{Permit,Result};

class ScoreGuide extends Component
{
    public $examinee_number;
    public function mount()
    {
        if(auth()->user()->permit != null)
        {
            $this->examinee_number = auth()->user()->permit->examinee_number_updated;
        }

    }
    public function render()
    {
        return view('livewire.result.score-guide',[
            'result'=>Result::where('examinee_number',$this->examinee_number)->first()
        ]);
    }
}
