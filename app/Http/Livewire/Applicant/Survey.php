<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;

use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Hash;
use App\Models\SurveyResult;
use DB;

class Survey extends Component
{
    use Actions;
    public $question_1;
    public $question_2;
    public $question_3;
    public $question_4;
    public $question_5;
    public $question_6;
    public $question_7;
    public $question_8;
    public $question_9;
    public $question_10;
    public $comment;

    public function save()
    {
        $has_survey_result = SurveyResult::where('user_id',  auth()->user()->id)->exists();
        $this->validate([
            'question_1' => 'required',
            'question_2' => 'required',
            'question_3' => 'required',
            'question_4' => 'required',
            'question_5' => 'required',
            'question_6' => 'required',
            'question_7' => 'required',
            'question_8' => 'required',
            'question_9' => 'required',
            'question_10' => 'required',
        ],
        [
            'question_1.required' => 'Please answer this question.',
            'question_2.required' => 'Please answer this question.',
            'question_3.required' => 'Please answer this question.',
            'question_4.required' => 'Please answer this question.',
            'question_5.required' => 'Please answer this question.',
            'question_6.required' => 'Please answer this question.',
            'question_7.required' => 'Please answer this question.',
            'question_8.required' => 'Please answer this question.',
            'question_9.required' => 'Please answer this question.',
            'question_10.required' => 'Please answer this question.',
        ]);

        DB::beginTransaction();
        if($has_survey_result)
        {
            $this->dialog()->error(
                $title = 'Operation Failed!',
                $description = 'You already participated in this survey.'
            );
        }else{
            $surveyResult = SurveyResult::create([
                'user_id' => auth()->user()->id,
                'question_one' => $this->question_1,
                'question_two' => $this->question_2,
                'question_three' => $this->question_3,
                'question_four' => $this->question_4,
                'question_five' => $this->question_5,
                'question_six' => $this->question_6,
                'question_seven' => $this->question_7,
                'question_eight' => $this->question_8,
                'question_nine' => $this->question_9,
                'question_ten' => $this->question_10,
                'comment' => $this->comment,
            ]);
            DB::commit();
            $this->dialog()->success(
                $title = 'Success',
                $description = 'Thank you for participating in the survey.'
            );
        }

        return redirect()->route('select.courses');
    }
    public function render()
    {
        return view('livewire.applicant.survey');
    }
}
