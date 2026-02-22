<?php

namespace App\Http\Livewire\Result;

use Livewire\Component;
use App\Models\{Permit,Result};

class ScoreGuide extends Component
{
    public $examinee_number;

    public function mount()
    {
        if (auth()->user()->permit != null) {
            $this->examinee_number = auth()->user()->permit->examinee_number_updated;
        }
    }

    public function render()
    {
        $result = Result::where('examinee_number', $this->examinee_number)->first();

        $view = ($result && $result->esm_raw_score !== null)
            ? 'livewire.result.score-guide-2026'
            : 'livewire.result.score-guide';

        return view($view);
    }
}
