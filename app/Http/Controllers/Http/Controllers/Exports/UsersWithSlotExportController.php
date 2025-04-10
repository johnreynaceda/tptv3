<?php

namespace App\Http\Controllers\Exports;

use App\Models\User;
use App\Models\Examination;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Spatie\SimpleExcel\SimpleExcelWriter;

class UsersWithSlotExportController extends Controller
{
    public function export()
    {
        $activeExamId = Examination::where('is_active', 1)->value('id');

        $fileName = 'users_with_slot_' . now()->format('Ymd_His') . '.csv';
        $writer = SimpleExcelWriter::streamDownload($fileName);
        

        // // Write CSV headers
        // $writer->addRow([
        //     'Examinee Number', 'First Name', 'Middle Name', 'Last Name', 'Extension',
        //     'Phone Number', 'Email Address', 'Sex', 'Permanent Address',
        //     'Date of Birth', 'Age', 'Tribe', 'Religion', 'School Address',
        //     'Track or Strand', 'First Priority Program', 'Second Priority Program',
        // ]);

        // User::query()
        //     ->whereHas('permit')
        //     ->whereHas('student_slot.slot.test_center', function ($query) use ($activeExamId) {
        //         $query->where('examination_id', $activeExamId);
        //     })
        //     ->where('role_id', 2)
        //     ->with(['permit', 'personal_information', 'program_choices.program'])
        //     ->lazyById(1000)
        //     ->each(function ($user) use ($writer) {
        //         $info = $user->personal_information;

        //         $age = '';
        //         if ($info && $info->date_of_birth) {
        //             $age = Carbon::parse($info->date_of_birth)->age;
        //         }

        //         $firstPriority = $user->program_choices->firstWhere('is_priority', true)?->program->name ?? '';
        //         $secondPriority = $user->program_choices->firstWhere('is_priority', false)?->program->name ?? '';

        //         $writer->addRow([
        //             $user->permit->examinee_number ?? 'N/A',
        //             $info->first_name ?? '',
        //             $info->middle_name ?? '',
        //             $info->last_name ?? '',
        //             $info->extension ?? '',
        //             $info->phone_number ?? '',
        //             $user->email ?? '',
        //             $info->sex ?? '',
        //             $info->permanent_address ?? '',
        //             $info->date_of_birth ?? '',
        //             $age,
        //             $info->tribe ?? '',
        //             $info->religion ?? '',
        //             $info->school_address ?? '',
        //             $info->track_or_strand ?? '',
        //             $firstPriority,
        //             $secondPriority,
        //         ]);
        //     });

        // return $writer->toBrowser();
    }
}
