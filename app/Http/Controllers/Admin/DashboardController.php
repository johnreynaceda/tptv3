<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\TestCenter;
use App\Models\Examination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $stat = $this->loadData();

    
        $totalUsersWithPermitWithSlot = User::isNotAdmin()
        ->whereHas('permit') // Ensure the user has a permit
        ->whereHas('student_slot', function ($query) {
            $query->whereHas('slot'); // Check if the student_slot has a related slot
        })
        ->count();

        $totalUsersWithPermitButNoSlot = User::isNotAdmin()
    ->whereHas('permit') // Ensure the user has a permit
    ->whereDoesntHave('student_slot', function ($query) {
        $query->whereHas('slot'); // Exclude users with a related slot
    })
    ->count();

    

   
    $active_examination = Examination::where('is_active', 1)->first();

   
    $testCenter = $active_examination 
        ? TestCenter::totalSlots()->where('examination_id', $active_examination->id)->first() 
        : null;

        $total_slots = $testCenter ? $testCenter->totalNumberOfSlot() : 0;
        $total_occupied_slots = $testCenter ? $testCenter->totalOccupiedSlots() : 0;
        $total_available_slots = $testCenter ? $testCenter->totalAvailableSlots() : 0;

    // Return view with data (default values where necessary)
    return view('admin.dashboard', [
        'totalUsersWithPermitWithSlot' => $totalUsersWithPermitWithSlot,
        'totalUsersWithPermitButNoSlot' => $totalUsersWithPermitButNoSlot,
    'users_count' => $stat['total_users_count'],
    'examinations_count' => $stat['total_examinations_count'],
    'programs_count' => $stat['total_programs_count'],
    'total_slots' => $total_slots,
        'total_occupied_slots' => $total_occupied_slots,
        'total_available_slots' => $total_available_slots,
        'current_active_examination' => $active_examination,
    ]);
    }

    public function loadData()
    {
        $query_1 = User::isNotAdmin()->select([
            DB::raw('"total_users_count" as label'),
            DB::raw('count(*) as value'),
        ]);
        
        $query_2 = DB::table('examinations')->select([
            DB::raw('"total_examinations_count" as label'),
            DB::raw('count(*) as value'),
        ]);

        $query_3 = DB::table('programs')
            ->where('is_offered', 1)
            ->select([
                DB::raw('"total_programs_count" as label'),
                DB::raw('count(*) as value'),
            ]);

        return $query_1->unionAll($query_2)
                        ->unionAll($query_3)
                        ->get()
                        ->mapWithKeys(function ($item) {
                            return [$item->label => $item->value];
                        })->toArray();
    }
}
