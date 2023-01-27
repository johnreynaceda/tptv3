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
        return $this->belongsTo(Slot::class);
    }
}
