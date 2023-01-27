<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Application,PersonalInformation,SchoolInformation,ProgramChoice,User};
class ResultController extends Controller
{
    public function result()
    {

        return view('applicant.result',[
            'user_application'=>auth()->user()->application,
            'user_personal_information'=>auth()->user()->personal_information,
            'user_school_information'=>auth()->user()->school_information,
            'user_program_choices'=> ProgramChoice::where('user_id', auth()->user()->id)->get()
        ]);
    }
}
