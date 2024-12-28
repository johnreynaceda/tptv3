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

public function getFormattedDateOfBirthAttribute()
{
    if (!$this->date_of_birth) {
        return ''; // Return an empty string or a default message if null
    }

    return \Carbon\Carbon::createFromFormat('Y-m-d', $this->date_of_birth)->format('F j, Y');
}

}
