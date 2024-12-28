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
use Spatie\Browsershot\Browsershot;
use App\Models\Permit;
use Illuminate\Support\Facades\View;
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
    return view('welcome');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->middleware('guest')->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callBack'])->middleware('guest')->name('auth.google.callBack');


Route::get('/forgot-password', function () {
    return view('auth.password-forgot');
})->name('forgot-password');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
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
        Route::get('/permit/{permit}', PermitLayout::class)->name('admin.permit');

        Route::get('/generate-pdf/{permit}', function (Permit $permit) {


            // ---------------
              //  VERSION 1
            //
            
            // $filePath = storage_path('app/public/example.pdf'); // Save to storage/app/public
            
            // Browsershot::url('https://spatie.be/docs/browsershot/v4/usage/creating-pdfs') // Use named route for your custom route
            //     ->setOption('args', ['--no-sandbox']) // Required for some server environments
            //     ->save($filePath); // Save the PDF
            
            // return response()->download($filePath)->deleteFileAfterSend(true); // Provide the file as a downloadable response
            // ---------------
              //  VERSION 2
            //  
      
            
            //     $pdfContent = Browsershot::url('https://spatie.be/docs/browsershot/v4/usage/creating-pdfs') // Use named route for your custom route}')
            //     ->setOption('args', ['--no-sandbox']) // Required for some server environments
            //     ->pdf(); // Generate the PDF as binary content
            
            // // Return PDF content as API response
            // return response($pdfContent, 200, [
            //         'Content-Type' => 'application/pdf',
            //         'Content-Disposition' => 'inline; filename="example.pdf"',
            //     ]);
                
                // ---------------
                //    VERSION 3


                  
                $pdfContent = Browsershot::html(
                    View::make('livewire.permit-layout', ['permit' => $permit])->render()
                )
                ->setOption('args', ['--no-sandbox']) 
                ->setIncludePath('$PATH:/root/.nvm/versions/node/v22.12.0/bin/npm')
                    ->pdf(); 
            
                return response($pdfContent, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="permit.pdf"',
                ]);


        })->name('admin.generate-pdf-permit');
    });

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

Route::get('/test-rejection-email', function () {
    $application =  App\Models\Application::with('user.personal_information')->findOrFail(20);
    $remarks = "Your payment reference number is invalid.";
    EmailController::sendPaymentApplicationRejectionEmail($application, $remarks);

    return "Rejection email sent to " . $application->user->email;
});




// Route::get('/generate-pdf', GeneratePdf::class);
// Route::get('/generate-pdf', function () {
//     $filePath = storage_path('app/public/example.pdf'); // Save to storage/app/public
//     Browsershot::url('https://spatie.be/docs/browsershot/v4/usage/creating-pdfs')
//         ->setOption('args', ['--no-sandbox']) // Required for some server environments
//         ->save($filePath); // Save the PDF

//     return response()->download($filePath); // Provide the file as a downloadable response
// });
