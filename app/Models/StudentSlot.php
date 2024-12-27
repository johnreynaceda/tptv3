<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSlot extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function application()
    {
        return $this->hasOne(Application::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class, 'slot_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function generateQrData()
{
    if (!$this->slot) {
        return 'No Slot Assigned';
    }

    return "Name: " . (optional($this->user)->name ?? 'Unknown') .
           "\nExam Number: " . (optional($this->application)->examinee_number ?? 'N/A') .
           "\nDate: " . (optional($this->slot)->date_of_exam ?? 'N/A') .
           "\nRoom: " . ($this->room_number ?? 'N/A') .
           "\nSeat: " . ($this->seat_number ?? 'N/A');
}


}
