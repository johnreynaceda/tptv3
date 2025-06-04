<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Application,PersonalInformation,SchoolInformation,ProgramChoice,User,SelectedCourse,Permit,Result};

class ResultController extends Controller
{
    public function result()
    {
        $examinee_number = null;
        $result = null;
        $resultsVisible = false;
        $currentExamination = null;

        // Get the examinee number from permit if available
        if(auth()->user()->permit != null) {
            $examinee_number = auth()->user()->permit->examinee_number_updated;
            $result = Result::where('examinee_number', $examinee_number)->first();

            // Get the current examination associated with the user's application
            if (auth()->user()->application) {
                $currentExamination = auth()->user()->application->examination;

                // Check if results should be shown based on the show_results flag
                if ($currentExamination && $currentExamination->show_results) {
                    $resultsVisible = true;
                }
            }
        }

        return view('applicant.result', [
            'user_application' => auth()->user()->application,
            'user_personal_information' => auth()->user()->personal_information,
            'user_school_information' => auth()->user()->school_information,
            'user_program_choices' => ProgramChoice::where('user_id', auth()->user()->id)->get(),
            'user_new_program_choices' => SelectedCourse::where('user_id', auth()->user()->id)->get(),
            'examinee_number' => $examinee_number,
            'result' => $result,
            'resultsVisible' => $resultsVisible,
            'examination' => $currentExamination,
        ]);
    }

    public function scoreInterpretation($score)
    {
        if ($score >= 200 && $score <= 324) {
            return 'Low';
        } elseif ($score >= 325 && $score <= 374) {
            return 'Below Average';
        }
        // elseif ($score >= 375 && $score <= 425) {
        //     return 'Below Average';
        // }
        elseif ($score >= 375 && $score <= 474) {
            return 'Low Average';
        } elseif ($score >= 475 && $score <= 524) {
            return 'Middle Average';
        } elseif ($score >= 525 && $score <= 579) {
            return 'High Average';
        } elseif ($score >= 580 && $score <= 679) {
            return 'Above Average';
        }
        // elseif ($score >= 626 && $score <= 675) {
        //     return 'Above Average';
        // }
        elseif ($score >= 680 && $score <= 800) {
            return 'Outstanding';
        } else {
            return 'Invalid Score';
        }
    }

    /**
     * Determine the qualitative interpretation of a score
     *
     * @param int $score The standard score to interpret
     * @return string The qualitative interpretation
     */

}
