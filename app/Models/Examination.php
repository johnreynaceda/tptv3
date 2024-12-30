<?php

namespace App\Models;

use App\Models\Permit;
use App\Models\TestCenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examination extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    

    // has permits  
    public function permits()
    {
        return $this->hasMany(Permit::class);
    }

    public function test_centers(){
        return $this->hasMany(TestCenter::class);
    }

    public function totalSlots()
    {
        return $this->test_centers->sum(function ($testCenter) {
            return $testCenter->slots->sum('slots');
        });
    }

    /**
     * Get the total available slots for the examination.
     *
     * @return int
     */
    public function totalAvailableSlots()
    {
        return $this->test_centers->sum(function ($testCenter) {
            return $testCenter->totalAvailableSlots();
        });
    }

    /**
     * Get the total number of activated slots for the examination.
     *
     * @return int
     */
    public function totalActivatedSlots()
    {
        return $this->test_centers->sum(function ($testCenter) {
            return $testCenter->slots->where('is_active', true)->sum('slots');
        });
    }

    /**
     * Get the total number of non-activated slots for the examination.
     *
     * @return int
     */
    public function totalNonActivatedSlots()
    {
        return $this->test_centers->sum(function ($testCenter) {
            return $testCenter->slots->where('is_active', false)->sum('slots');
        });
    }

    /**
     * Check if there are available slots for activation.
     *
     * @return bool
     */
    public function hasAvailableSlotsForActivation()
    {
        return $this->totalNonActivatedSlots() > 0;
    }

    /**
     * Get the total number of occupied slots for the examination.
     *
     * @return int
     */
    public function totalOccupiedSlots()
    {
        return $this->test_centers->sum(function ($testCenter) {
            return $testCenter->slots->sum(function ($slot) {
                return $slot->student_slots->count();
            });
        });
    }

    /**
     * Get the total number of vacant slots for the examination.
     *
     * @return int
     */
    public function totalVacantSlots()
    {
        return $this->totalSlots() - $this->totalOccupiedSlots();
    }

    /**
     * Check if the examination has no vacant slots.
     *
     * @return bool
     */
    public function hasNoVacantSlots()
    {
        return $this->totalVacantSlots() <= 0;
    }
    public function totalActiveSlots()
    {
        return $this->test_centers->sum(function ($testCenter) {
            return $testCenter->slots->where('is_active', true)->sum('slots');
        });
    }

    /**
     * Total occupied slots for active slots.
     *
     * @return int
     */
    public function totalOccupiedActiveSlots()
{
    return $this->test_centers->sum(function ($testCenter) {
        return $testCenter->slots
            ->where('is_active', true)
            ->sum(function ($slot) {
                return $slot->student_slots ? $slot->student_slots->count() : 0;
            });
    });
}


    /**
     * Total available active slots.
     *
     * @return int
     */
    public function totalAvailableActiveSlots()
    {
        return $this->totalActiveSlots() - $this->totalOccupiedActiveSlots();
    }

    /**
     * Check if there are available active slots.
     *
     * @return bool
     */
    public function hasAvailableActiveSlots()
    {
        return $this->totalAvailableActiveSlots() > 0;
    }

    /**
     * Check if there are no available active slots.
     *
     * @return bool
     */
    public function hasNoAvailableActiveSlots()
    {
        return $this->totalAvailableActiveSlots() <= 0;
    }

}
