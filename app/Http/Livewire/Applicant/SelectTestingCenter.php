<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\TestCenter;
use App\Models\Slot;
use App\Models\StudentSlot;
use WireUi\Traits\Actions;
use App\Models\{Examination, Result};

class SelectTestingCenter extends Component
{
    use Actions;
    public $time;
    public $center_id;
    public $date;
    public $room_number;
    public $seat_number;

    public function render()
    {
        return view('livewire.applicant.select-testing-center', [
            'testing_centers' => Slot::where(
                'date_of_exam',
                $this->date
            )->where('is_active', 1)->get(),
        ]);
    }

    public function updatedTime()
    {
        $this->room_number = null;
        $this->seat_number = null;
        $this->center_id = null;
        $this->date = null;
    }

    public function updatedCenterId()
    {
          // if (StudentSlot::count() == 0) {
        //     $latest_room_number = 1;
        //     $latest_room_number_in_schedule = 1;
        // } else {
        //     $latest_room_number = StudentSlot::select('room_number')
        //         ->latest()
        //         ->first()->room_number;
        //     }

        if (StudentSlot::count() == 0) {
            $latest_room_number_in_schedule = 1;
        } else {
            $latest_room_number_in_schedule = StudentSlot::whereHas('slot', function ($query) {
                $query->where('test_center_id', $this->center_id)
                ->whereDate('date_of_exam', $this->date);
            })
            ->where('time', $this->time)->latest()->first();
            if($latest_room_number_in_schedule == null)
            {
                $latest_room_number_in_schedule = 1;
            }else{
                $latest_room_number_in_schedule = $latest_room_number_in_schedule->room_number;
            }
        }

        //mods
        $number_of_seats = 50;


        $total_acquired_slots = StudentSlot::whereHas('slot', function ($query) {
            $query->where('test_center_id', $this->center_id)
            ->whereDate('date_of_exam', $this->date);
        })->where('time', $this->time)->count();

        $total_available_slots =  Slot::where('test_center_id', $this->center_id)
                ->where('date_of_exam', $this->date)
                ->first()->slots / 2;

        $total_number_of_rooms = Slot::where('test_center_id', $this->center_id)
                ->where('date_of_exam', $this->date)
                ->first()->number_of_rooms;


        if($total_acquired_slots < $total_available_slots)
        {
            $total_seats_in_room = StudentSlot::whereHas('slot', function ($query) {
                $query->where('test_center_id', $this->center_id)
                ->whereDate('date_of_exam', $this->date);
            })
            ->where('room_number', $latest_room_number_in_schedule)
            ->where('time', $this->time)->count();

            if($latest_room_number_in_schedule == $total_number_of_rooms)
            {
                $this->dialog()->error(
                    $title = 'All Rooms are full for this schedule',
                    $description = 'Please select another date or time schedule or testing center'
                );
            }else{
                if($total_seats_in_room < $number_of_seats)
                {
                    $this->room_number = $latest_room_number_in_schedule;
                    $this->seat_number = $total_seats_in_room + 1;
                }else{
                    $this->room_number = $latest_room_number_in_schedule + 1;
                    $this->seat_number = 1;
                }
            }

        }else{
            $this->dialog()->error(
                $title = 'Slot is full',
                $description = 'Please select another date or time schedule'
            );
        }

        //end mods


        // $total_slot_per_room = StudentSlot::where(
        //     'slot_id',
        //     '=',
        //     $this->center_id
        // )
        //     ->where('time', $this->time)
        //     ->whereHas('slot', function ($query) {
        //         $query->where('date_of_exam', $this->date);
        //     })
        //     // ->where('room_number', $latest_room_number)
        //     ->orderBy('created_at', 'desc');

        // $slot =
        //     Slot::where('id', $this->center_id)
        //         ->where('date_of_exam', $this->date)
        //         ->first()->slots / 2;
        // $total_slot = StudentSlot::where(
        //     'slot_id',
        //     '=',
        //     $this->center_id
        // )->where('time', $this->time);
        // if ($total_slot->count() == $slot) {
        //     $this->dialog()->error(
        //         $title = 'Slot is full',
        //         $description = 'Please select another date or time schedule'
        //     );
        // } else {

        //     if ($total_slot_per_room->count() == $slot) {
        //         $this->dialog()->error(
        //             $title = 'Slot is full',
        //             $description = 'Please select another testing center'
        //         );
        //     } else {
        //         if ($total_slot_per_room->count() == 0) {
        //             $this->room_number = 1;
        //             $this->seat_number = 1;
        //         } else {
        //             if ($total_slot_per_room->first()->seat_number < 50) {
        //                 $this->room_number = $total_slot_per_room->first()->room_number;
        //                 $this->seat_number = $total_slot_per_room->first()->seat_number + 1;
        //             } else {
        //                 $this->room_number = $total_slot_per_room->first()->room_number + 1;
        //                 $this->seat_number = 1;
        //             }
        //         }
        //     }


        // }
    }

    public function saveSlot()
    {


        $this->validate([
            'center_id' => 'required',
            'time' => 'required',
        ]);


        // if (StudentSlot::count() == 0) {
        //     $latest_room_number = 1;
        //     $latest_room_number_in_schedule = 1;
        // } else {
        //     $latest_room_number = StudentSlot::select('room_number')
        //         ->latest()
        //         ->first()->room_number;
        //     }

        if (StudentSlot::count() == 0) {
            $latest_room_number_in_schedule = 1;
        } else {
            $latest_room_number_in_schedule = StudentSlot::whereHas('slot', function ($query) {
                $query->where('test_center_id', $this->center_id)
                ->whereDate('date_of_exam', $this->date);
            })
            ->where('time', $this->time)->latest()->first();

            if($latest_room_number_in_schedule == null)
            {
                $latest_room_number_in_schedule = 1;
            }else{
                $latest_room_number_in_schedule = $latest_room_number_in_schedule->room_number;
            }
        }

          //mods
          $number_of_seats = 50;


          $total_acquired_slots = StudentSlot::whereHas('slot', function ($query) {
              $query->where('test_center_id', $this->center_id)
              ->whereDate('date_of_exam', $this->date);
          })->where('time', $this->time)->count();

          $total_available_slots =  Slot::where('test_center_id', $this->center_id)
                  ->where('date_of_exam', $this->date)
                  ->first()->slots / 2;

          $total_number_of_rooms = Slot::where('test_center_id', $this->center_id)
                  ->where('date_of_exam', $this->date)
                  ->first()->number_of_rooms;



          if($total_acquired_slots < $total_available_slots)
          {
              $total_seats_in_room = StudentSlot::whereHas('slot', function ($query) {
                  $query->where('test_center_id', $this->center_id)
                  ->whereDate('date_of_exam', $this->date);
              })
              ->where('room_number', $latest_room_number_in_schedule)
              ->where('time', $this->time)->count();

              if($latest_room_number_in_schedule == $total_number_of_rooms)
              {
                  $this->dialog()->error(
                      $title = 'All Rooms are full for this schedule',
                      $description = 'Please select another date or time schedule or testing center'
                  );
              }else{
                  if($total_seats_in_room < $number_of_seats)
                  {
                      $this->room_number = $latest_room_number_in_schedule;
                      $this->seat_number = $total_seats_in_room + 1;
                  }else{
                      $this->room_number = $latest_room_number_in_schedule + 1;
                      $this->seat_number = 1;
                  }
              }

          }else{
              $this->dialog()->error(
                  $title = 'Slot is full',
                  $description = 'Please select another date or time schedule'
              );
          }

          //end mods


        // $total_slot_per_room = StudentSlot::where(
        //     'slot_id',
        //     '=',
        //     $this->center_id
        // )
        //     ->where('time', $this->time)
        //     ->whereHas('slot', function ($query) {
        //         $query->where('date_of_exam', $this->date);
        //     })
        //     // ->where('room_number', $latest_room_number)
        //     ->orderBy('created_at', 'desc');
        // $slot =
        //     Slot::where('id', $this->center_id)
        //         ->where('date_of_exam', $this->date)
        //         ->first()->slots / 2;

        // $total_slot = StudentSlot::where(
        //     'slot_id',
        //     '=',
        //     $this->center_id
        // )->where('time', $this->time);
        // if ($total_slot->count() == $slot) {
        //     $this->dialog()->error(
        //         $title = 'Slot is full',
        //         $description = 'Please select another date or time schedule'
        //     );
        // } else {
        //     if ($total_slot_per_room->count() == $slot) {
        //         $this->dialog()->error(
        //             $title = 'Slot is full',
        //             $description = 'Please select another testing center'
        //         );
        //     } else {
        //         if ($total_slot_per_room->count() == 0) {
        //             $this->room_number = 1;
        //             $this->seat_number = 1;
        //         } else {
        //             if ($total_slot_per_room->first()->seat_number < 50) {
        //                 $this->room_number = $total_slot_per_room->first()->room_number;
        //                 $this->seat_number = $total_slot_per_room->first()->seat_number + 1;
        //             } else {
        //                 $this->room_number = $total_slot_per_room->first()->room_number + 1;
        //                 $this->seat_number = 1;
        //             }
        //         }
        //     }

        // }

        $studen_slot = StudentSlot::create([
            'user_id' => auth()->user()->id,
            'slot_id' => $this->center_id,
            'time' => $this->time,
            'room_number' => $this->room_number,
            'seat_number' => $this->seat_number,
        ]);

        auth()
            ->user()
            ->application->update([
                'student_slot_id' => $studen_slot->id,
            ]);

        $this->notification()->success(
            $title = 'Success',
            $description = 'Successfully Saved Slot'
        );

        return redirect()->route('applicant.home');
    }
}
