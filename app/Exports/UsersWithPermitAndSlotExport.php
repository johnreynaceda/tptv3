<?php
namespace App\Exports;

use App\Models\User;
use App\Models\Examination;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersWithPermitAndSlotExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    use Exportable;
    //updae
    public function query()
    {
        $activeExam = Examination::where('is_active', 1)->first();

        // Use a query that matches the dashboard logic exactly
        return User::select('users.*')
            ->join('permits', 'users.id', '=', 'permits.user_id')
            ->join('student_slots', 'users.id', '=', 'student_slots.user_id')
            ->join('slots', 'student_slots.slot_id', '=', 'slots.id')
            ->join('test_centers', 'slots.test_center_id', '=', 'test_centers.id')
            ->where('users.role_id', '!=', 1)
            ->where('test_centers.examination_id', $activeExam->id)
            ->with([
                'permit',
                'personal_information',
                'school_information',
                'program_choices.program'
            ]);
    }

    public function headings(): array
    {
        return [
            'Examinee Number',
            'First Name',
            'Middle Name',
            'Last Name',
            'Extension',
            'Phone Number',
            'Email Address',
            'Sex',
            'Permanent Address',
            'Date of Birth',
            'Age',
            'Tribe',
            'Religion',
            'School Address',
            'Track or Strand',
            'First Priority Program',
            'Second Priority Program',
        ];
    }

    public function map($user): array
    {
        $info = $user->personal_information;
        $school = $user->school_information;
        $programs = $user->program_choices->sortByDesc('is_priority')->values();
        $firstProgram = isset($programs[0]) ? ($programs[0]->program->name ?? 'N/A') : 'N/A';
        $secondProgram = isset($programs[1]) ? ($programs[1]->program->name ?? 'N/A') : 'N/A';

        return [
            $user->permit->examinee_number ?? 'N/A',
            $info->first_name ?? 'N/A',
            $info->middle_name ?? 'N/A',
            $info->last_name ?? 'N/A',
            $info->extension ?? 'N/A',
            $info->phone_number ?? 'N/A',
            $user->email ?? 'N/A',
            $info->sex ?? 'N/A',
            $info->permanent_address ?? 'N/A',
            $info->formatted_date_of_birth ?? $info->date_of_birth ?? 'N/A',
            $info->age ?? 'N/A',
            $info->tribe ?? 'N/A',
            $info->religion ?? 'N/A',
            $school->previous_school_address ?? 'N/A',
            $school->track_and_strand_taken ?? 'N/A',
            $firstProgram,
            $secondProgram,
        ];
    }

    public function chunkSize(): int
    {
        return 1000; // Process 1000 records at a time
    }
}
