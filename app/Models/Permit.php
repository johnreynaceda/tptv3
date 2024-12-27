<?php

namespace App\Models;

use App\Models\Examination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function result()
    {
        return $this->hasOne(Result::class,'examinee_number','examinee_number_updated');
    }

    public function generateQrData()
    {
        $examineeName = optional($this->user)->personal_information->fullName() ?? 'Unknown';
        $examineeNumber = $this->examinee_number ?? 'N/A';
    
        // Check if the student_slot exists
        $studentSlot = optional($this->user->application)->student_slot;
    
        // Format exam date
        $examDate = optional($studentSlot?->slot)->date_of_exam 
            ? \Carbon\Carbon::parse($studentSlot->slot->date_of_exam)->format('F d, Y') 
            : 'Not Assigned';
    
        // Use the time string directly
        $examTime = $studentSlot?->time ?? 'Not Assigned';
    
        $roomNumber = $studentSlot?->room_number ?? 'Not Assigned';
        $seatNumber = $studentSlot?->seat_number ?? 'Not Assigned';
    
        // Create a simple readable format
        return "Examinee Name: $examineeName\n" .
               "Examinee Number: $examineeNumber\n" .
               "Exam Date: $examDate\n" .
               "Exam Time: $examTime\n" .
               "Room Number: $roomNumber\n" .
               "Seat Number: $seatNumber";
    }
    
    

    public function getExamDate()
{
    return optional(optional($this->student_slot)->slot)->date_of_exam ?? 'Not Assigned';
}



public function examination(){
    return $this->belongsTo(Examination::class);
}



}
