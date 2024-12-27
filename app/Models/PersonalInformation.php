<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fullName(): string
{
    $middleName = $this->middle_name ? " {$this->middle_name}" : ''; // Include middle name if it exists
    return "{$this->last_name}, {$this->first_name}{$middleName}";
}

}
