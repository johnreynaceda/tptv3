<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\{Application,Examination};
class Menu extends Component
{
    public function getApplicationProperty()
    {
        return Application::where('user_id',auth()->user()->id)->first();
    }

    public function getExaminationProperty()
    {
        return Examination::where('is_active',1)->first();
    }
    public function render()
    {
        return view('livewire.applicant.menu');
    }

    public function startApplication()
    {
        if ($this->examination->is_active) {
            Application::create([
                'user_id'=>auth()->user()->id,
                'examination_id'=>$this->examination->id
            ]);
        }
    }

    public function fillUpPersonalInfomation()
    {
        if ($this->application->status=='submitted') {
            dd('You have already submitted your personal information');
        }else{
            return redirect()->route('applicant.personal-information');
        }
    }

    
}
