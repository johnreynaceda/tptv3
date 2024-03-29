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

    public function selected_courses()
    {
        return $this->hasMany(SelectedCourse::class);
    }
}
