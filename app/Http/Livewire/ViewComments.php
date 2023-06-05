<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SurveyResult;

class ViewComments extends Component
{
    public function render()
    {
        return view('livewire.view-comments',[
            'comments' => SurveyResult::with('user.selected_courses')
            ->whereNotNull('comment')
            ->where('comment', '<>', '')->get(),
        ]);
    }
}
