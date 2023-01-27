<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Examination,Application,ProgramChoice,Permit};
class PrintPermitController extends Controller
{
    public function generate()
    {
        $permit = Permit::where('user_id', auth()->user()->id)->first();
        $personal_information = auth()->user()->personal_information;
        $school_information = auth()->user()->school_information;
        $program_choices = ProgramChoice::where('user_id', auth()->user()->id)->with('program')->get();
        return view('applicant.permit',[
            'permit' => $permit,
            'personal_information' => $personal_information,
            'school_information' => $school_information,
            'program_choices' => $program_choices,
        ]);
    }
}
