<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Examination,Result, SurveyResult, SelectedCourse, TestCenter};
class HomeController extends Controller
{
    public function home()
    {
        $has_application = auth()->user()->application;
        $active_examination = Examination::where('is_active', 1)->first();
        $examination_id = $has_application?->examination_id;
        $has_result = Result::where('examination_id',  $examination_id)->exists();
        $has_survey_result = SurveyResult::where('user_id',  auth()->user()->id)->exists();
        $has_selected_course = SelectedCourse::where('user_id',  auth()->user()->id)->exists();

        
        $testCenter = TestCenter::totalSlots()->where('examination_id', $active_examination->id)->first();
      
        // get test center
        // get teset center slots
        // get test center student slots count
        // get test center student slots occupied
        // dd($testCenter);

        // dd($testCenter->totalAvailableSlots(), $testCenter->totalNumberOfSlot());


       


        return view('applicant.home',[
            'has_application' => $has_application,
            'has_result' => $has_result,
            'has_survey_result' => $has_survey_result,
            'has_selected_course' => $has_selected_course,
            'active_examination' => $active_examination ,
            'total_slots' => $testCenter->totalNumberOfSlot(),
            'total_occupied_slots' => $testCenter->totalOccupiedSlots(),
            'total_available_slots' => $testCenter->totalAvailableSlots(),
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
