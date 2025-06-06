<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    EmailController,
    GoogleController,
    HomeController,
    PrintPermitController,
    ResultController
};
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Livewire\ViewPermit;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationRejected;
use App\Mail\ApplicationStatus;
use App\Http\Livewire\GeneratePdf;
use App\Http\Livewire\PermitLayout;
use App\Http\Livewire\ViewOnlyPermit;
use Spatie\Browsershot\Browsershot;
use App\Models\Permit;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersWithoutSlotExport;
use App\Exports\UsersWithPermitAndSlotExport;
use App\Http\Livewire\CampusManagement;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// login admin
Route::get('/admin/login', function () {return view('auth.login-admin');})->name('login.admin')->middleware('guest');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->middleware('guest')->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callBack'])->name('auth.google.callBack');


Route::get('/forgot-password', function () {
    return view('auth.password-forgot');
})->name('forgot-password');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    
     logger('DASHBOARD user:', [
        'auth' => auth()->check(),
        'id' => optional(auth()->user())->id,
        'email' => optional(auth()->user())->email,
        'role_id' => optional(auth()->user())->role_id,
        'email_verified_at' => optional(auth()->user())->email_verified_at,
    ]);
    Route::get('/dashboard', function () {
        switch (auth()->user()->role_id) {
            case 1:
                return redirect()->route('admin.dashboard');
                break;
            case 2:
                return redirect()->route('applicant.home');
                break;
        }
    })->name('dashboard');
});

Route::prefix('/admin')
    ->middleware([
        'auth:sanctum',
        'is_admin',
        config('jetstream.auth_session'),
        'verified',
    ])
    ->group(function () {
        Route::get('/dashboard', [
            DashboardController::class,
            'dashboard',
        ])->name('admin.dashboard');
        Route::get('/campuses', function () {
            return view('admin.campuses');
        })->name('admin.campuses');
        // Route::get('/campuses', CampusManagement::class)->name('campuses.index');
        Route::get('/examinations', function () {
            return view('admin.examinations');
        })->name('admin.examinations');
        Route::get('/monitoring', function () {
            return view('admin.monitoring');
        })->name('admin.monitoring');
        Route::get('/report', function () {
            return view('admin.reports');
        })->name('admin.reports');
        Route::get('/student-list-report', function () {
            return view('admin.student-list-report');
        })->name('admin.student-list-report');
        Route::get('/registration-date-report', function () {
            return view('admin.registration-date-report');
        })->name('admin.registration-date-report');
        Route::get('/student-report', function () {
            return view('admin.result-report');
        })->name('admin.result-report');
        Route::get('/ranking-report', function () {
            return view('admin.ranking-report');
        })->name('admin.ranking-report');
        Route::get('/qualified-students-report', function () {
            return view('admin.qualified-students-report');
        })->name('admin.qualified-students-report');
        Route::get('/students-score-report', function () {
            return view('admin.students-score');
        })->name('admin.students-score');
        Route::get('/programs', function () {
            $campuses = \App\Models\Campus::all('id', 'name');
            return view('admin.programs', ['campuses' => $campuses]);
        })->name('admin.programs');
        Route::get('/manage-examination/{id}/applications', function ($id) {
            return view('admin.manage-examination.applications', [
                'examination_id' => $id,
            ]);
        })->name('admin.manage-examination.applications');
        Route::get('/manage-examination/{id}/applications/slots', function (
            $id
        ) {
            return view('admin.manage-examination.slot', [
                'examination_id' => $id,
            ]);
        })->name('admin.manage-examination.applications.slots');
        Route::get('/users', function () {
            return view('admin.users');
        })->name('admin.users');

        //view permit
        // Route::get('/permit/{user}', ViewPermit::class)->name('admin.permit');
        Route::get('/permit/{permit}/view', ViewOnlyPermit::class)->name('admin.permit.view');
        Route::get('/export/users-without-slot', function () {
            $filename = 'student_with_permit_but_no_slot_' . now()->year . '.xlsx'; // Include the current year
            return Excel::download(new UsersWithoutSlotExport, $filename);
        })->name('export.users_without_slot');

        Route::get('/export/users-with-slot', function () {
             $filename = 'students_with_slots_and_permit_' . now()->year . '.xlsx';
            
             return Excel::download(new UsersWithPermitAndSlotExport, $filename);

// To:
// return Excel::download(new UsersWithPermitAndSlotExport, $filename, \Maatwebsite\Excel\Excel::CSV);

        })->name('export.users_with_slot');

        // Queued export routes
        Route::get('/export/queue-users-with-permit-and-slot', [App\Http\Controllers\QueuedExportController::class, 'exportUsersWithPermitAndSlot'])->name('export.queue_users_with_permit_and_slot');
        Route::get('/exports', [App\Http\Controllers\QueuedExportController::class, 'listExports'])->name('export.list');
        Route::get('/exports/download/{filename}', [App\Http\Controllers\QueuedExportController::class, 'downloadExport'])->name('export.download');

    });

    Route::get('/permit/{permit}', PermitLayout::class)->name('admin.permit');
    Route::get('/generate-pdf/{permit}', function (Permit $permit) {


        $htmlContent = View::make('livewire.permit-layout', ['permit' => $permit])->render();

        // Generate the PDF from the HTML content
        $pdfContent = Browsershot::html($htmlContent)
            ->setOption('args', ['--disable-web-security'])
            ->pdf();

            $fullName = $permit->user->personal_information->fullName();
            $safeFullName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $fullName).'PERMIT';

        // Return the PDF content as a response
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $safeFullName . '.pdf"',
        ]);

})->name('admin.generate-pdf-permit');

Route::prefix('/applicant')
    ->middleware([
        'auth:sanctum',
        'is_applicant',
        config('jetstream.auth_session'),
        'verified',
    ])
    ->group(function () {
        Route::get('/home', [HomeController::class, 'home'])->name(
            'applicant.home'
        );
        Route::get('/fill/application', [
            HomeController::class,
            'fillApplication',
        ])
            ->name('applicant.fill.application')
            ->middleware('step_two');
        Route::get('/payment', [HomeController::class, 'payment'])
            ->name('applicant.payment')
            ->middleware('step_three');

        Route::get('/permit', [PrintPermitController::class, 'generate'])
            ->name('applicant.permit-generate')
            ->middleware('step_five');
        Route::get('/result', [ResultController::class, 'result'])->name(
            'print.result'
        )->middleware('survey.result');

        Route::get('/survey', function () {
            if (App\Models\SurveyResult::where('user_id', auth()->user()->id)->exists() && App\Models\SelectedCourse::where('user_id', auth()->user()->id)->exists()) {
                return redirect()->route('applicant.home');
            } elseif (App\Models\SurveyResult::where('user_id', auth()->user()->id)->exists() && !App\Models\SelectedCourse::where('user_id', auth()->user()->id)->exists()) {
                return redirect()->route('select.courses');
            } else {
                return view('applicant.survey');
            }
        })->name('show.survey');

        Route::get('/select-course', function () {
            if (!App\Models\SurveyResult::where('user_id', auth()->user()->id)->exists()) {
                return redirect()->route('show.survey');
            } elseif (App\Models\SelectedCourse::where('user_id', auth()->user()->id)->exists()) {
                return redirect()->route('applicant.home');
            } else {
                return view('applicant.select-courses');
            }
        })->name('select.courses');

        Route::get('/select-test-center', function () {
            if (auth()->user()->application->student_slot_id != null) {
                return redirect()->back();
            } else {
                return view('applicant.select-test-center');
            }
        })->name('applicant.test-center');
    });

Route::get('/secret/pass', function () {
    $permit = App\Models\Permit::where('examinee_number', 200681)->first();
    $user = App\Models\User::where('id', $permit->user_id)->first();
    Auth::login($user);
})->name('secret.pass');


// email layout test
Route::get('/email', function () {
    $permit =  App\Models\Permit::findOrFail(20);
    $user =  App\Models\User::findOrFail(9);
    $application = $user->application;
    EmailController::sendPaymentApplicationApprovalEmail($permit);
    return "Rejection email sent to " . $application->user->email;
    // return view('emails.application-reject', ['application' => $application]);
    // return view('emails.application-approve', ['permit' => $permit]);
});

Route::get('/test-email', function () {
    // $application =  App\Models\Application::with('user.personal_information')->first();
    // $remarks = "Your payment reference number is invalid.";
    // EmailController::sendPaymentApplicationRejectionEmail($application, $remarks);

    $permit = App\Models\Permit::first();
    $email = $permit->user->email;
    EmailController::sendPaymentApplicationApprovalEmail($permit);

    return "Email was sent ";
    // return "Email was sent " . $email;
});


Route::get('/yow', function () {
  return 'yow';
});





// Route::get('/generate-pdf', GeneratePdf::class);
// Route::get('/generate-pdf', function () {
//     $filePath = storage_path('app/public/example.pdf'); // Save to storage/app/public
//     Browsershot::url('https://spatie.be/docs/browsershot/v4/usage/creating-pdfs')
//         ->setOption('args', ['--no-sandbox']) // Required for some server environments
//         ->save($filePath); // Save the PDF

//     return response()->download($filePath); // Provide the file as a downloadable response
// });


Route::get('/xss-test', function () {
    $student = PersonalInformation::find(1); // or use your test student's ID
    return view('xss-test', compact('student'));
});
