<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Examination,Result, SurveyResult, SelectedCourse, TestCenter};

class HomeController extends Controller
{
    // public function home()
    // {




    //     // ]);

    //     $has_application = auth()->user()->application;
    // $active_examination = Examination::where('is_active', 1)->first();

    // // Ensure the active examination exists
    // if (!$active_examination) {
    //     return view('applicant.home', [
    //         'has_application' => $has_application,
    //         'has_result' => false,
    //         'has_survey_result' => false,
    //         'has_selected_course' => false,
    //         'active_examination' => null,
    //         'total_slots' => 0,
    //         'total_occupied_slots' => 0,
    //         'total_available_slots' => 0,
    //     ]);
    // }

    // $examination_id = $has_application?->examination_id;
    // $has_result = Result::where('examination_id', $examination_id)->exists();
    // $has_survey_result = SurveyResult::where('user_id', auth()->user()->id)->exists();
    // $has_selected_course = SelectedCourse::where('user_id', auth()->user()->id)->exists();

    // // Attempt to get the test center for the active examination
    // $testCenter = TestCenter::totalSlots()
    //     ->where('examination_id', $active_examination->id)
    //     ->first();

    // // Handle cases where no test center is found
    // $total_slots = $testCenter ? $testCenter->totalNumberOfSlot() : 0;
    // $total_occupied_slots = $testCenter ? $testCenter->totalOccupiedSlots() : 0;
    // $total_available_slots = $testCenter ? $testCenter->totalAvailableSlots() : 0;
    // $has_available_slots = $testCenter ? $testCenter->hasAvailableSlots() : 0;



    // return view('applicant.home', [
    //     'has_available_slots'=>$has_available_slots,
    //     'has_application' => $has_application,
    //     'has_result' => $has_result,
    //     'has_survey_result' => $has_survey_result,
    //     'has_selected_course' => $has_selected_course,
    //     'active_examination' => $active_examination,
    //     'total_slots' => $total_slots,
    //     'total_occupied_slots' => $total_occupied_slots,
    //     'total_available_slots' => $total_available_slots,
    // ]);
    // }
     public function home()
{
    $user = Auth::user();
    $has_application = $user->application;
    $active_examination = Examination::where('is_active', 1)->first();

    // 🔹 Case 1: No active examination — still pass all variables
    if (!$active_examination) {
        return view('applicant.home', [
            'has_application'       => $has_application,
            'has_result'            => false,
            'user_has_result'       => false,
            'has_survey_result'     => false,
            'has_selected_course'   => false,
            'active_examination'    => null,
            'total_slots'           => 0,
            'total_occupied_slots'  => 0,
            'total_available_slots' => 0,
            'has_available_slots'   => false,
            'show_results'          => false,
        ]);
    }

    // 🔹 Check if user already has a result in this active exam (via examinee number)
    $examinee_number = optional($user->permit)->examinee_number_updated
        ?? optional($user->permit)->examinee_number;

    $has_result_global = $examinee_number
        ? $active_examination->results()
            ->where('examinee_number', $examinee_number)
            ->exists()
        : false;

    // 🔹 Other per-user flags
    $has_survey_result   = SurveyResult::where('user_id', $user->id)->exists();
    $has_selected_course = SelectedCourse::where('user_id', $user->id)->exists();

    // 🔹 Slot counts
    $total_slots           = $active_examination->totalSlots();
    $total_occupied_slots  = $active_examination->totalOccupiedSlots();
    $total_available_slots = $active_examination->totalAvailableActiveSlots();
    $has_available_slots   = $total_available_slots > 0;

    // 🔹 User-specific result flag (redundant but clearer for Blade)
    $user_has_result = $has_result_global;

    // 🔹 Return view with complete data
    return view('applicant.home', [
        'has_application'       => $has_application,
        'has_result'            => $has_result_global,
        'user_has_result'       => $user_has_result,
        'has_survey_result'     => $has_survey_result,
        'has_selected_course'   => $has_selected_course,
        'active_examination'    => $active_examination,
        'total_slots'           => $total_slots,
        'total_occupied_slots'  => $total_occupied_slots,
        'total_available_slots' => $total_available_slots,
        'has_available_slots'   => $has_available_slots,
        'show_results'          => (bool) $active_examination->show_results,
    ]);
}




    public function fillApplication()
    {

        $active_examination = Examination::where('is_active', 1)->first();

        $has_available_slots = $active_examination
        ? $active_examination->totalAvailableActiveSlots() > 0
        : false;

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
