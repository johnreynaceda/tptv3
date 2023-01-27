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
}
