<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\{Application,Examination};
class GetStartedButton extends Component
{
    public $examination;
    public function render()
    {
        return view('livewire.applicant.get-started-button');
    }

    public function clickHandler()
    {
        $this->checkIfHasApplication();
        $this->checkActiveExamination();
        Application::create([
            'user_id' => auth()->id(),
            'examination_id' => $this->examination->id,
            'submited_at' => null,
            'status' => 'filling_up',
        ]);
        auth()->user()->update([
            'step' => '2',
        ]);
        return redirect()->route('applicant.fill.application');
    }

    protected function checkIfHasApplication()
    {
        if(auth()->user()->application){
            return false;
        }
    }
    protected function checkActiveExamination()
    {
        if(!Examination::where('is_active', 1)->first()){
            return redirect()->route('applicant.home');
        }
    }
}
