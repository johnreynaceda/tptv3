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
        $users = User::isNotAdmin()
            ->whereHas('permit') // Users with permits
            ->whereDoesntHave('student_slot', function ($query) {
                $query->whereHas('slot'); // Without slots
            })
            ->with(['permit', 'personal_information']) // Load related permit and personal information
            ->get();

        return view('exports.users-without-slot', [
            'users' => $users,
        ]);
    }
}
