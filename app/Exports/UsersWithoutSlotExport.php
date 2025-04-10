<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersWithoutSlotExport implements FromView
{
    /**
     * Generate the view for the export.
     */
    public function view(): View
    {
        $activeExam = \App\Models\Examination::where('is_active', 1)->first();

    $users = User::isNotAdmin()
        ->whereHas('permit')
        ->where(function ($query) use ($activeExam) {
            $query->whereDoesntHave('student_slot')
                ->orWhereHas('student_slot.slot.test_center', function ($q) use ($activeExam) {
                    $q->where('examination_id', '!=', $activeExam->id);
                });
        })
        ->with(['permit', 'personal_information'])
        ->get();

    return view('exports.users-without-slot', [
        'users' => $users,
    ]);
    }
}
