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
        // Get basic stats using optimized query
        $stats = $this->loadData();

        // Get the currently active examination
        $active_examination = Examination::where('is_active', 1)->first();

        // Default userStats in case there's no active examination
        $userStats = (object)[
            'users_with_permit_and_slot' => 0,
            'users_with_permit_only' => 0,
        ];

        if ($active_examination) {
            // Get permit and slot statistics based on the active examination only
            $userStats = DB::select(
                "SELECT
                    SUM(CASE
                        WHEN permits.id IS NOT NULL
                             AND student_slots.id IS NOT NULL
                             AND slots.test_center_id IN (
                                 SELECT id FROM test_centers WHERE examination_id = ?
                             )
                        THEN 1
                        ELSE 0
                    END) as users_with_permit_and_slot,
                    SUM(CASE
                        WHEN permits.id IS NOT NULL
                             AND (student_slots.id IS NULL
                                  OR slots.test_center_id NOT IN (
                                      SELECT id FROM test_centers WHERE examination_id = ?
                                  )
                             )
                        THEN 1
                        ELSE 0
                    END) as users_with_permit_only
                FROM users
                LEFT JOIN permits ON users.id = permits.user_id
                LEFT JOIN student_slots ON users.id = student_slots.user_id
                LEFT JOIN slots ON student_slots.slot_id = slots.id
                WHERE users.role_id = 2
                ",
                [$active_examination->id, $active_examination->id]
            )[0];

            // Load slot statistics for the active examination
            $active_examination->loadCount([
                'test_centers as total_active_slots' => function($query) {
                    $query->join('slots', 'test_centers.id', '=', 'slots.test_center_id')
                          ->where('slots.is_active', true)
                          ->select(DB::raw('SUM(slots.slots)'));
                },
                'test_centers as total_occupied_active_slots' => function($query) {
                    $query->join('slots', 'test_centers.id', '=', 'slots.test_center_id')
                          ->join('student_slots', 'slots.id', '=', 'student_slots.slot_id')
                          ->where('slots.is_active', true);
                }
            ]);
        }

        // Calculate available slots
        $total_active_slots = $active_examination ? $active_examination->total_active_slots : 0;
        $total_occupied_active_slots = $active_examination ? $active_examination->total_occupied_active_slots : 0;
        $total_available_active_slots = $total_active_slots - $total_occupied_active_slots;

        return view('admin.dashboard', [
            'totalUsersWithPermitWithSlot' => $userStats->users_with_permit_and_slot,
            'totalUsersWithPermitButNoSlot' => $userStats->users_with_permit_only,
            'users_count' => $stats['total_users_count'],
            'examinations_count' => $stats['total_examinations_count'],
            'programs_count' => $stats['total_programs_count'],
            'total_active_slots' => $total_active_slots,
            'total_occupied_active_slots' => $total_occupied_active_slots,
            'total_available_active_slots' => $total_available_active_slots,
            'current_active_examination' => $active_examination,
        ]);
    }


    public function loadData()
    {
        // Combine all count queries into a single query
        $stats = DB::select(
            "SELECT
                (SELECT COUNT(*) FROM users WHERE role_id = 2) as total_users_count,
                (SELECT COUNT(*) FROM examinations) as total_examinations_count,
                (SELECT COUNT(*) FROM programs WHERE is_offered = 1) as total_programs_count"
        )[0];

        return (array) $stats;
    }
}
