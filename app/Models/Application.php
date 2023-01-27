<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function student_slot()
    {
        return $this->belongsTo(StudentSlot::class);
    }
}
