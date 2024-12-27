<?php

namespace App\Http\Controllers;

use App\Models\Permit;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Mail\ApplicationStatus;
use App\Mail\ApplicationRejected;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    
    public static function sendPaymentApplicationApprovalEmail(Permit $permit){
        try {
            Mail::to($permit->user->email)->send(new ApplicationStatus( $permit));
            
            // Log or perform an action indicating the email was sent
            \Log::info("Email sent to {$permit->user->email} for Request ID: {$permit->id}");
        } catch (\Exception $e) {
            // Handle errors during email sending
            \Log::error("Failed to send email to {$permit->user->email}: " . $e->getMessage());
        }
       
    }

    // for rejection
    public static function sendPaymentApplicationRejectionEmail(Application $application, $remarks){
        try {
            Mail::to($application->user->email)->send(new ApplicationRejected($application, $remarks));
            
            // Log or perform an action indicating the email was sent
            \Log::info("Email sent to {$application->user->email} for Request ID: {$application->id}");
        } catch (\Exception $e) {
            // Handle errors during email sending
            \Log::error("Failed to send email to {$application->user->email}: " . $e->getMessage());
        }
      
    }
}
