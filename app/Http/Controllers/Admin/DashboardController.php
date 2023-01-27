<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $stat = $this->loadData();
        return view('admin.dashboard',[
            'users_count'=>$stat['total_users_count'],
            'examinations_count' => $stat['total_examinations_count'],
            'programs_count' => $stat['total_programs_count'],
            'current_active_examination'=> \App\Models\Examination::where('is_active',1)->first(),
        ]);
    }

    public function loadData()
    {
        $query_1 = DB::table('users')->select([
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
