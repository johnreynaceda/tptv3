<?php

namespace App\Models;

use App\Models\Permit;
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

    

}
