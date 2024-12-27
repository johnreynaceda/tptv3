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

    public function scopeOrderByExamineeNumber($query)
{
    $query->leftJoin('permits', 'applications.user_id', '=', 'permits.user_id')
          ->orderByRaw('CASE WHEN permits.examinee_number IS NULL THEN 1 ELSE 0 END, permits.examinee_number ASC')
          ->select('applications.*'); // Explicitly select only the `applications` table columns
}

    



}
