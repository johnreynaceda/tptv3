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
    public function stanineInterpretation($stanine)
    {
        if ($stanine == 9) return 'Outstanding';
        if ($stanine == 8) return 'Above Average';
        if ($stanine == 7) return 'Above Average';
        if ($stanine == 6) return 'High Average';
        if ($stanine == 5) return 'Middle Average';
        if ($stanine == 4) return 'Low Average';
        if ($stanine == 3) return 'Below Average';
        if ($stanine == 2) return 'Below Average';
        if ($stanine == 1) return 'Low';
        return '';
    }
}
