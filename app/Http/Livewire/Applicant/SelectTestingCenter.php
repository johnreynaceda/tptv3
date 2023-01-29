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
            )->get(),
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
        $latest_room_number = StudentSlot::select('room_number')->latest()->first()->room_number;
        $total_slot = StudentSlot::where('slot_id', '=', $this->center_id)
            ->where('time', $this->time)
            ->whereHas('slot', function ($query) {
                $query->where('date_of_exam', $this->date);
            })
            ->where('room_number', $latest_room_number)
            ->orderBy('created_at', 'desc');
        $slot =
            Slot::where('id', $this->center_id)
                ->where('date_of_exam', $this->date)
                ->first()->slots / 2;

        if ($total_slot->count() <= 0) {
            $this->room_number = 1;
            $this->seat_number = 1;
        } else {
            if ($total_slot->count() == 50) {
                $this->dialog()->error(
                    $title = 'Slot is full',
                    $description = 'Please select another testing center'
                );
            } else {
                if ($total_slot->first()->seat_number < 50) {
                    $this->room_number = $total_slot->first()->room_number;
                    $this->seat_number = $total_slot->first()->seat_number + 1;
                } else {
                    $this->room_number = $total_slot->first()->room_number + 1;
                    $this->seat_number = 1;
                }
            }
        }
    }

    public function saveSlot()
    {
        $this->validate([
            'center_id' => 'required',
            'time' => 'required',
        ]);

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
