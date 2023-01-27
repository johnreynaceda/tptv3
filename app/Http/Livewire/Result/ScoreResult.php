<?php

namespace App\Http\Livewire\Result;

use Livewire\Component;
use App\Models\{Permit,Result};
class ScoreResult extends Component
{
    public $examinee_number;
    public function mount()
    {
        $this->examinee_number = auth()->user()->permit->examinee_number;
    }
    public function render()
    {
        return view('livewire.result.score-result',[
            'result'=>Result::where('examinee_number',$this->examinee_number)->first()
        ]);
    }

    public function scoreInterpretation($score)
    {
        if ($score >= 200 && $score <= 325) {
            return 'Low';
        } elseif ($score >= 326 && $score <= 375) {
            return 'Below Average';
        } elseif ($score >= 376 && $score <= 425) {
            return 'Below Average';
        } elseif ($score >= 426 && $score <= 475) {
            return 'Low Average';
        } elseif ($score >= 476 && $score <= 525) {
            return 'Middle Average';
        } elseif ($score >= 526 && $score <= 575) {
            return 'High Average';
        } elseif ($score >= 576 && $score <= 625) {
            return 'Above Average';
        } elseif ($score >= 626 && $score <= 675) {
            return 'Above Average';
        } elseif ($score >= 676 && $score <= 800) {
            return 'Outstanding';
        } else {
            return 'Invalid Score';
        }
    }
}
