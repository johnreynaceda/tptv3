<?php

namespace App\Http\Livewire\Result;

use Livewire\Component;
use App\Models\{Permit,Result};
class ScoreResult extends Component
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
        $result = Result::where('examinee_number', $this->examinee_number)->first();

        $view = ($result && $result->esm_raw_score !== null)
            ? 'livewire.result.score-result-2026'
            : 'livewire.result.score-result';

        return view($view, [
            'result' => $result
        ]);
    }

    public function stanineInterpretation($score)
    {
        if ($score == 9) {
            return 'Outstanding';
        } elseif ($score == 8 || $score == 7) {
            return 'Above Average';
        } elseif ($score == 6) {
            return 'High Average';
        } elseif ($score == 5) {
            return 'Middle Average';
        } elseif ($score == 4) {
            return 'Low Average';
        } elseif ($score == 3 || $score == 2) {
            return 'Below Average';
        } elseif ($score == 1) {
            return 'Low';
        } else {
            return 'Invalid Score';
        }
    }
}
