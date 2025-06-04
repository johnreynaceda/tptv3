<?php

namespace App\Models;

use App\Models\Examination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'show_result'=> 'boolean',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}
