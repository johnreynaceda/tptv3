<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Permit;
use Livewire\Component;
use App\Models\ProgramChoice;

class ViewPermit extends Component
{

    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

   

    public function render()
    {

         $permit = Permit::where('user_id', $this->user->id)->first();
        $personal_information = $this->user->personal_information;
        $school_information = $this->user->school_information;
        $program_choices = ProgramChoice::where('user_id', $this->user->id)->with('program')->get();
        // return view('applicant.permit',[
        //     'permit' => $permit,
        //     'personal_information' => $personal_information,
        //     'school_information' => $school_information,
        //     'program_choices' => $program_choices,
        // ]);
        return view('livewire.view-permit',[
            'user' => $this->user,
            'permit' => $permit,
            'personal_information' => $personal_information,
            'school_information' => $school_information,
            'program_choices' => $program_choices,
        ]       
    );
    }
}
