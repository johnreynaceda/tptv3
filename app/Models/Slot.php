<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function test_center()
    {
        return $this->belongsTo(TestCenter::class);
    }

    public function student_slots()
    {
        return $this->hasMany(StudentSlot::class);
    }

    //sum of student slots
    public function scopeTotalSlots($query)
    {
        return $query->withCount('student_slots');
    }
}
