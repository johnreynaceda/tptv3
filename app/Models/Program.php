<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function program_choice()
    {
        return $this->hasOne(ProgramChoice::class);
    }

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Get the selected courses for this program
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
/*******  683b553f-0f19-494b-8f28-14d09baf62d9  *******/
    public function selected_courses()
    {
        return $this->hasMany(SelectedCourse::class);
    }
}
