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
        return view('livewire.result.score-result',[
            'result'=>Result::where('examinee_number',$this->examinee_number)->first()
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
