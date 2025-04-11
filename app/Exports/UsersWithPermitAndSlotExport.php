<?php
namespace App\Exports;

use App\Models\User;
use App\Models\Examination;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersWithPermitAndSlotExport implements FromView
{
    public function view(): View
    {
        $activeExam = Examination::where('is_active', 1)->first();

        $users = User::isNotAdmin()
            ->whereHas('permit.examination', fn ($q) => $q->where('id', $activeExam->id))
            ->whereHas('student_slot.slot.test_center', fn ($q) => $q->where('examination_id', $activeExam->id))
            ->with(['permit', 'personal_information'])
            ->limit(100) // TEMP LIMIT
            ->get();

        return view('exports.users-with-slot', [
            'users' => $users,
        ]);
    }
}
