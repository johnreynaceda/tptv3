<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Examination,Result};
class HomeController extends Controller
{
    public function home()
    {
        $has_application = auth()->user()->application;
        $active_examination = Examination::where('is_active', 1)->first();
        $examination_id = $has_application?->examination_id;
        $has_result = Result::where('examination_id',  $examination_id)->exists();
        return view('applicant.home',[
            'has_application' => $has_application,
            'has_result' => $has_result,
            'active_examination' => $active_examination ,
        ]);
    }

    public function fillApplication()
    {
        return view('applicant.fill-application',[
            'has_personal_information' => auth()->user()->personal_information ? 1 : 0,
            'has_school_information' => auth()->user()->school_information ? 1 : 0,
            'has_program_choice' => \App\Models\ProgramChoice::where('user_id', auth()->user()->id)->count() ? 1 : 0,
        ]);
    }

    public function payment()
    {
        return view('applicant.payment');
    }

}
