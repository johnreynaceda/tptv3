<?php

namespace App\Models;

use App\Models\Examination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestCenter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function exmaination()
    {
        return $this->belongsTo(Examination::class);
    }

    //scope with relations
    public function scopeWithRelations($query)
    {
        return $query->with(['campus', 'slots']);
    }

    //scope total slots
    public function scopeTotalSlots($query)
    {
        return $query->withCount('slots');
    }

    // sum of student slots
    public function scopeTotalStudentSlots($query)
    {
        return $query->withCount(['slots as total_student_slots' => function ($query) {
            $query->select('slots')->sum('slots');
        }]);
    }

    public function totalOccupiedSlots()
    {
        return $this->slots->sum(function ($slot) {
            return $slot->student_slots->count();
        });
    }

    public function hasAvailableSlots()
{
    return $this->totalAvailableSlots() > 0;
}


    public function totalNumberOfSlot()
    {
        return $this->slots->sum('slots');
    }
    public function totalAvailableSlots()
    {
        return $this->totalNumberOfSlot() - $this->totalOccupiedSlots();
    }
}
