<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Examination,Result, SurveyResult, SelectedCourse, TestCenter};
class HomeController extends Controller
{
    public function home()
    {

        

        // $has_application = auth()->user()->application;
        // $active_examination = Examination::where('is_active', 1)->first();
        // $examination_id = $has_application?->examination_id;
        // $has_result = Result::where('examination_id',  $examination_id)->exists();
        // $has_survey_result = SurveyResult::where('user_id',  auth()->user()->id)->exists();
        // $has_selected_course = SelectedCourse::where('user_id',  auth()->user()->id)->exists();

        
        // $testCenter = TestCenter::totalSlots()->where('examination_id', $active_examination->id)->first();
      
      


        // return view('applicant.home',[

        //     'has_application' => $has_application,
        //     'has_result' => $has_result,
        //     'has_survey_result' => $has_survey_result,
        //     'has_selected_course' => $has_selected_course,
        //     'active_examination' => $active_examination ,
        //     'total_slots' => $testCenter->totalNumberOfSlot() ??0 ,
        //     'total_occupied_slots' => $testCenter->totalOccupiedSlots()??0,
        //     'total_available_slots' => $testCenter->totalAvailableSlots() ?? 0,
        // ]);

        $has_application = auth()->user()->application;
    $active_examination = Examination::where('is_active', 1)->first();

    // Ensure the active examination exists
    if (!$active_examination) {
        return view('applicant.home', [
            'has_application' => $has_application,
            'has_result' => false,
            'has_survey_result' => false,
            'has_selected_course' => false,
            'active_examination' => null,
            'total_slots' => 0,
            'total_occupied_slots' => 0,
            'total_available_slots' => 0,
        ]);
    }

    $examination_id = $has_application?->examination_id;
    $has_result = Result::where('examination_id', $examination_id)->exists();
    $has_survey_result = SurveyResult::where('user_id', auth()->user()->id)->exists();
    $has_selected_course = SelectedCourse::where('user_id', auth()->user()->id)->exists();

    // Attempt to get the test center for the active examination
    $testCenter = TestCenter::totalSlots()
        ->where('examination_id', $active_examination->id)
        ->first();

    // Handle cases where no test center is found
    $total_slots = $testCenter ? $testCenter->totalNumberOfSlot() : 0;
    $total_occupied_slots = $testCenter ? $testCenter->totalOccupiedSlots() : 0;
    $total_available_slots = $testCenter ? $testCenter->totalAvailableSlots() : 0;
    $has_available_slots = $testCenter ? $testCenter->hasAvailableSlots() : 0;

    

    return view('applicant.home', [
        'has_available_slots'=>$has_available_slots,
        'has_application' => $has_application,
        'has_result' => $has_result,
        'has_survey_result' => $has_survey_result,
        'has_selected_course' => $has_selected_course,
        'active_examination' => $active_examination,
        'total_slots' => $total_slots,
        'total_occupied_slots' => $total_occupied_slots,
        'total_available_slots' => $total_available_slots,
    ]);
    }

    public function fillApplication()
    {
        $active_examination = Examination::where('is_active', 1)->first();
        $testCenter = TestCenter::totalSlots()
        ->where('examination_id', $active_examination->id)
        ->first();

        $has_available_slots = $testCenter ? $testCenter->hasAvailableSlots() : 0;

        return view('applicant.fill-application',[
            'has_available_slots'=>$has_available_slots,
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
