<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
