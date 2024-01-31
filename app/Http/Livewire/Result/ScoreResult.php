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

    public function scoreInterpretation($score)
    {
        if ($score >= 200 && $score <= 324) {
            return 'Low';
        } elseif ($score >= 325 && $score <= 374) {
            return 'Below Average';
        }
        // elseif ($score >= 375 && $score <= 425) {
        //     return 'Below Average';
        // }
        elseif ($score >= 375 && $score <= 474) {
            return 'Low Average';
        } elseif ($score >= 475 && $score <= 524) {
            return 'Middle Average';
        } elseif ($score >= 525 && $score <= 579) {
            return 'High Average';
        } elseif ($score >= 580 && $score <= 679) {
            return 'Above Average';
        }
        // elseif ($score >= 626 && $score <= 675) {
        //     return 'Above Average';
        // }
        elseif ($score >= 680 && $score <= 800) {
            return 'Outstanding';
        } else {
            return 'Invalid Score';
        }
    }
}
