<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function test_centers()
    {
        return $this->hasMany(TestCenter::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    /**
     * Get the total number of slots for the campus.
     *
     * @return int
     */
    public function totalSlots()
    {
        return $this->test_centers->sum(function ($testCenter) {
            return $testCenter->slots->sum('slots');
        });
    }

    /**
     * Get the total number of rooms for the campus.
     *
     * @return int
     */
    public function totalRooms()
    {
        return $this->test_centers->sum(function ($testCenter) {
            return $testCenter->slots->sum('number_of_rooms');
        });
    }
}
