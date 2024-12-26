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

    
    $totalUsersWithPermit = User::isNotAdmin()->whereHas('permit')->count();

   
    $active_examination = Examination::where('is_active', 1)->first();

   
    $testCenter = $active_examination 
        ? TestCenter::totalSlots()->where('examination_id', $active_examination->id)->first() 
        : null;

    

    // Return view with data (default values where necessary)
    return view('admin.dashboard', [
        'totalUsersWithPermit' => $totalUsersWithPermit,
    'users_count' => $stat['total_users_count'],
    'examinations_count' => $stat['total_examinations_count'],
    'programs_count' => $stat['total_programs_count'],
    'total_slots' => $testCenter->totalNumberOfSlot() ?? null,
    'total_occupied_slots' => $testCenter->totalOccupiedSlots() ?? null,
    'total_available_slots' => $testCenter->totalAvailableSlots() ?? null,
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
