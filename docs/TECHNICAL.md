# Technical Specifications

## Technology Stack

### Backend
| Technology | Version | Purpose |
|------------|---------|---------|
| PHP | ^8.0.2 | Server-side language |
| Laravel | ^9.11 | PHP Framework |
| MySQL/MariaDB | 5.7+/10.3+ | Database |
| Composer | 2.x | PHP dependency manager |

### Frontend
| Technology | Version | Purpose |
|------------|---------|---------|
| Livewire | ^2.5 | Reactive PHP components |
| Alpine.js | ^3.0.6 | Lightweight JS framework |
| Tailwind CSS | ^3.1.0 | CSS framework |
| WireUI | ^1.7 | Tailwind component library |
| Laravel Mix | ^6.0.6 | Asset compilation |

### Authentication
| Package | Purpose |
|---------|---------|
| Laravel Jetstream | Auth scaffolding, profile management |
| Laravel Fortify | Backend authentication logic |
| Laravel Sanctum | API token authentication |
| Laravel Socialite | OAuth (Google) integration |

### Data Processing
| Package | Purpose |
|---------|---------|
| Maatwebsite Excel | Excel import/export |
| Spatie Browsershot | PDF generation via Puppeteer |
| barryvdh/laravel-dompdf | DOM-based PDF generation |
| milon/barcode | QR code generation |

---

## Architecture Overview

### MVC + Livewire Pattern

```
┌─────────────────────────────────────────────────────────────────┐
│                       REQUEST FLOW                               │
└─────────────────────────────────────────────────────────────────┘

        HTTP Request
             │
             ▼
    ┌─────────────────┐
    │     Routes      │  routes/web.php, routes/api.php
    │    (web.php)    │
    └────────┬────────┘
             │
             ▼
    ┌─────────────────┐
    │   Middleware    │  Authentication, Role checks, Step validation
    │                 │
    └────────┬────────┘
             │
             ├─────────────────────────────────┐
             ▼                                 ▼
    ┌─────────────────┐               ┌─────────────────┐
    │   Controller    │               │    Livewire     │
    │                 │               │   Component     │
    └────────┬────────┘               └────────┬────────┘
             │                                 │
             ▼                                 ▼
    ┌─────────────────┐               ┌─────────────────┐
    │     Model       │               │     Model       │
    │   (Eloquent)    │               │   (Eloquent)    │
    └────────┬────────┘               └────────┬────────┘
             │                                 │
             ▼                                 ▼
    ┌─────────────────────────────────────────────────────┐
    │                    DATABASE                          │
    └─────────────────────────────────────────────────────┘
             │                                 │
             ▼                                 ▼
    ┌─────────────────┐               ┌─────────────────┐
    │   Blade View    │               │  Livewire View  │
    │                 │◀──────────────│                 │
    └─────────────────┘               └─────────────────┘
             │
             ▼
        HTTP Response
```

---

## Directory Structure Details

### App Directory

```
app/
├── Actions/
│   └── Fortify/
│       ├── CreateNewUser.php          # User registration logic
│       ├── PasswordValidationRules.php # Password rules trait
│       ├── ResetUserPassword.php       # Password reset
│       ├── UpdateUserPassword.php      # Password update
│       └── UpdateUserProfileInformation.php
│
├── Console/
│   └── Kernel.php                      # Scheduled tasks
│
├── Exceptions/
│   └── Handler.php                     # Exception handling
│
├── Exports/                            # Maatwebsite Excel exports
│   ├── AllResultExport.php
│   ├── PermitReport.php
│   ├── QualifiedStudentsExport.php
│   ├── RegistrationDateExport.php
│   ├── ResultAllExport.php
│   ├── ResultPerProgramExport.php
│   ├── UserExport.php
│   ├── UserSheetExport.php
│   ├── UsersWithoutSlotExport.php
│   └── UsersWithPermitAndSlotExport.php
│
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   └── DashboardController.php
│   │   ├── Controller.php
│   │   ├── EmailController.php          # Email sending
│   │   ├── GoogleController.php         # Google OAuth
│   │   ├── HomeController.php           # Applicant home
│   │   ├── PrintPermitController.php    # Permit generation
│   │   ├── QueuedExportController.php   # Large exports
│   │   └── ResultController.php         # Result viewing
│   │
│   ├── Livewire/
│   │   ├── Admin/
│   │   │   ├── Applications/
│   │   │   │   ├── GenerateReport/
│   │   │   │   │   ├── AllReadyToExam.php
│   │   │   │   │   └── DownloadResult.php
│   │   │   │   ├── Table.php
│   │   │   │   ├── UploadResult.php
│   │   │   │   ├── View.php
│   │   │   │   └── ViewPayment.php
│   │   │   ├── Examination/
│   │   │   │   ├── Create.php
│   │   │   │   ├── Table.php
│   │   │   │   └── Update.php
│   │   │   ├── ProgramOffers/
│   │   │   │   ├── Create.php
│   │   │   │   ├── Table.php
│   │   │   │   └── Update.php
│   │   │   ├── ManageSlot.php
│   │   │   ├── Monitoring.php
│   │   │   ├── QualifiedStudentsReport.php
│   │   │   ├── RankingResult.php
│   │   │   ├── RegistrationDateReport.php
│   │   │   ├── Report.php
│   │   │   ├── ResultReport.php
│   │   │   ├── StudentListReport.php
│   │   │   ├── StudentScores.php
│   │   │   └── User.php
│   │   ├── Applicant/
│   │   │   ├── ButtonSubmitApplication.php
│   │   │   ├── GetStartedButton.php
│   │   │   ├── Menu.php
│   │   │   ├── PaymentSection.php
│   │   │   ├── PersonalInfo.php
│   │   │   ├── ProgramInfo.php
│   │   │   ├── ResubmitPayment.php
│   │   │   ├── SchoolInfo.php
│   │   │   ├── SelectCourses.php
│   │   │   ├── SelectTestingCenter.php
│   │   │   ├── Survey.php
│   │   │   ├── UpdatePhoto.php
│   │   │   └── UpdateProgramChoice.php
│   │   ├── Auth/
│   │   │   └── ForgotPassword.php
│   │   ├── Result/
│   │   │   ├── ScoreGuide.php
│   │   │   ├── ScoreResult.php
│   │   │   └── SingleScoreGuide.php
│   │   ├── CampusManagement.php
│   │   ├── ExaminationResultPage.php
│   │   ├── ExaminationResultPdf.php
│   │   ├── ExaminationWithResultPage.php
│   │   ├── ExamineeResultDetails.php
│   │   ├── FooterSignature.php
│   │   ├── GeneratePdf.php
│   │   ├── PermitLayout.php
│   │   ├── ViewComments.php
│   │   ├── ViewOnlyPermit.php
│   │   └── ViewPermit.php
│   │
│   ├── Middleware/
│   │   ├── ApplicationSubmitted.php
│   │   ├── Authenticate.php
│   │   ├── EncryptCookies.php
│   │   ├── IsAdmin.php
│   │   ├── IsApplicant.php
│   │   ├── PreventRequestsDuringMaintenance.php
│   │   ├── RedirectIfAuthenticated.php
│   │   ├── StepFive.php
│   │   ├── StepFour.php
│   │   ├── StepOne.php
│   │   ├── StepThree.php
│   │   ├── StepTwo.php
│   │   ├── SurveyResultMiddleware.php
│   │   ├── TrimStrings.php
│   │   ├── TrustHosts.php
│   │   ├── TrustProxies.php
│   │   └── VerifyCsrfToken.php
│   │
│   └── Kernel.php
│
├── Imports/
│   └── ExaminationResultImport.php     # Excel result import
│
├── Mail/
│   ├── ApplicationRejected.php
│   └── ApplicationStatus.php
│
├── Models/
│   ├── Application.php
│   ├── Campus.php
│   ├── Examination.php
│   ├── Payment.php
│   ├── Permit.php
│   ├── PersonalInformation.php
│   ├── Program.php
│   ├── ProgramChoice.php
│   ├── Proof.php
│   ├── Result.php
│   ├── Role.php
│   ├── SchoolInformation.php
│   ├── SelectedCourse.php
│   ├── Slot.php
│   ├── StudentSlot.php
│   ├── SurveyResult.php
│   ├── TestCenter.php
│   ├── Type.php
│   └── User.php
│
├── Providers/
│   ├── AppServiceProvider.php
│   ├── AuthServiceProvider.php
│   ├── BroadcastServiceProvider.php
│   ├── EventServiceProvider.php
│   ├── FortifyServiceProvider.php
│   ├── JetstreamServiceProvider.php
│   └── RouteServiceProvider.php
│
└── View/
    └── Components/                     # Blade components
```

---

## Model Relationships

### User Model

```php
class User extends Authenticatable
{
    // Belongs To
    public function role() { return $this->belongsTo(Role::class); }

    // Has One
    public function application() { return $this->hasOne(Application::class); }
    public function personal_information() { return $this->hasOne(PersonalInformation::class); }
    public function school_information() { return $this->hasOne(SchoolInformation::class); }
    public function payment() { return $this->hasOne(Payment::class); }
    public function permit() { return $this->hasOne(Permit::class); }
    public function student_slot() { return $this->hasOne(StudentSlot::class); }
    public function survey_result() { return $this->hasOne(SurveyResult::class); }

    // Has Many
    public function program_choices() { return $this->hasMany(ProgramChoice::class); }
    public function selected_courses() { return $this->hasMany(SelectedCourse::class); }

    // Helper Methods
    public function is_admin(): bool { return $this->role_id === 1; }
    public function scopeIsNotAdmin($query) { return $query->where('role_id', '!=', 1); }
}
```

### Examination Model

```php
class Examination extends Model
{
    // Has Many
    public function applications() { return $this->hasMany(Application::class); }
    public function results() { return $this->hasMany(Result::class); }
    public function permits() { return $this->hasMany(Permit::class); }
    public function test_centers() { return $this->hasMany(TestCenter::class); }

    // Slot Calculation Methods
    public function totalSlots() { /* sum of all slots */ }
    public function totalAvailableSlots() { /* available slots */ }
    public function totalOccupiedSlots() { /* occupied slots */ }
    public function totalVacantSlots() { /* vacant slots */ }
    public function totalActiveSlots() { /* active slots only */ }
    public function totalAvailableActiveSlots() { /* available active */ }
    public function hasAvailableActiveSlots() { /* boolean */ }
}
```

### Complete Relationship Map

```
User (1) ─────────────────────────────────────────────────────────────┐
  │                                                                   │
  ├──▶ Role (N:1)                                                     │
  ├──▶ PersonalInformation (1:1)                                      │
  ├──▶ SchoolInformation (1:1)                                        │
  ├──▶ Payment (1:1) ──▶ Proof (1:N)                                  │
  ├──▶ Application (1:1) ──▶ Examination (N:1)                        │
  │                      ──▶ StudentSlot (N:1)                        │
  ├──▶ Permit (1:1) ──▶ Examination (N:1)                             │
  │                  ──▶ Result (1:1 via examinee_number)             │
  ├──▶ StudentSlot (1:1) ──▶ Slot (N:1)                               │
  ├──▶ ProgramChoice (1:N) ──▶ Program (N:1)                          │
  ├──▶ SurveyResult (1:1)                                             │
  └──▶ SelectedCourse (1:N) ──▶ Program (N:1)                         │
                                                                       │
Examination (1) ──────────────────────────────────────────────────────┤
  ├──▶ Application (1:N)                                               │
  ├──▶ Permit (1:N)                                                    │
  ├──▶ Result (1:N)                                                    │
  └──▶ TestCenter (1:N) ──▶ Campus (N:1)                               │
                        ──▶ Slot (1:N) ──▶ StudentSlot (1:N)           │
                                                                       │
Campus (1) ───────────────────────────────────────────────────────────┤
  ├──▶ Program (1:N)                                                   │
  └──▶ TestCenter (1:N)                                                │
                                                                       │
Program (1) ──────────────────────────────────────────────────────────┘
  ├──▶ Campus (N:1)
  ├──▶ ProgramChoice (1:N)
  └──▶ SelectedCourse (1:N)
```

---

## Middleware Stack

### Custom Middleware

| Middleware | Purpose | Location |
|------------|---------|----------|
| `IsAdmin` | Check if user is admin (role_id=1) | Admin routes |
| `IsApplicant` | Check if user is applicant (role_id=2) | Applicant routes |
| `StepTwo` | Verify user.step = '2' | Fill application |
| `StepThree` | Verify user.step = '3' | Payment page |
| `StepFive` | Verify user.step = '5' | Permit page |
| `SurveyResultMiddleware` | Check survey completed | Result viewing |
| `ApplicationSubmitted` | Check application status | Various |

### Middleware Registration (Kernel.php)

```php
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'is_admin' => \App\Http\Middleware\IsAdmin::class,
    'is_applicant' => \App\Http\Middleware\IsApplicant::class,
    'step_two' => \App\Http\Middleware\StepTwo::class,
    'step_three' => \App\Http\Middleware\StepThree::class,
    'step_five' => \App\Http\Middleware\StepFive::class,
    'survey.result' => \App\Http\Middleware\SurveyResultMiddleware::class,
    // ...
];
```

---

## Service Providers

| Provider | Purpose |
|----------|---------|
| `AppServiceProvider` | Application bootstrapping |
| `AuthServiceProvider` | Authorization policies |
| `EventServiceProvider` | Event-listener bindings |
| `FortifyServiceProvider` | Fortify authentication views |
| `JetstreamServiceProvider` | Jetstream configuration |
| `RouteServiceProvider` | Route model bindings |

---

## Configuration Files

### Key Configurations

**config/app.php**
```php
'name' => env('APP_NAME', 'TPT'),
'env' => env('APP_ENV', 'production'),
'debug' => (bool) env('APP_DEBUG', false),
'timezone' => 'Asia/Manila',  // Philippine timezone
```

**config/services.php**
```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

**config/mail.php**
```php
'default' => env('MAIL_MAILER', 'smtp'),
'mailers' => [
    'smtp' => [
        'transport' => 'smtp',
        'host' => env('MAIL_HOST'),
        'port' => env('MAIL_PORT'),
        'encryption' => env('MAIL_ENCRYPTION'),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
    ],
],
```

---

## PDF Generation

### Two Methods Available

**1. Browsershot (Puppeteer) - Primary**
```php
use Spatie\Browsershot\Browsershot;

$htmlContent = View::make('livewire.permit-layout', [
    'permit' => $permit
])->render();

$pdfContent = Browsershot::html($htmlContent)
    ->setOption('args', ['--disable-web-security'])
    ->pdf();
```

**2. DomPDF (Fallback)**
```php
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('permits.layout', ['permit' => $permit]);
return $pdf->download('permit.pdf');
```

### Requirements for Browsershot
- Node.js installed
- Puppeteer npm package: `npm install puppeteer`
- Chrome/Chromium browser accessible

---

## Excel Import/Export

### Export Example
```php
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersWithPermitAndSlotExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::whereHas('permit')
            ->whereHas('student_slot')
            ->with(['personal_information', 'permit', 'student_slot.slot'])
            ->get()
            ->map(function ($user) {
                return [
                    'Examinee Number' => $user->permit->examinee_number,
                    'Name' => $user->personal_information->fullName(),
                    'Room' => $user->student_slot->room_number,
                    'Seat' => $user->student_slot->seat_number,
                ];
            });
    }

    public function headings(): array
    {
        return ['Examinee Number', 'Name', 'Room', 'Seat'];
    }
}
```

### Import Example
```php
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExaminationResultImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Result([
            'examination_id' => $this->examinationId,
            'examinee_number' => $row['examinee_number'],
            'math_raw_score' => $row['math_raw_score'],
            'math_standard_score' => $row['math_standard_score'],
            // ... other fields
        ]);
    }
}
```

---

## Email System

### Mailable Classes

**ApplicationRejected**
```php
class ApplicationRejected extends Mailable
{
    public $application;
    public $remarks;

    public function build()
    {
        return $this->subject('Application Payment Rejected')
            ->view('emails.application-reject');
    }
}
```

### Email Controller
```php
class EmailController extends Controller
{
    public static function sendPaymentApplicationApprovalEmail(Permit $permit)
    {
        $user = $permit->user;
        Mail::to($user->email)->send(new ApplicationStatus($permit));
    }

    public static function sendPaymentApplicationRejectionEmail($application, $remarks)
    {
        Mail::to($application->user->email)
            ->send(new ApplicationRejected($application, $remarks));
    }
}
```

---

## Security Considerations

### Authentication
- Session-based authentication via Laravel Sanctum
- Optional Two-Factor Authentication (2FA)
- Google OAuth as primary login method
- Password hashing using bcrypt

### Authorization
- Role-based access control (Admin/Applicant)
- Middleware protection for all routes
- Step-based middleware prevents unauthorized access

### Data Validation
- Form requests with validation rules
- Livewire component validation
- Unique constraints on database level

### File Upload Security
- Allowed file types: jpeg, png, pdf, jpg
- Files stored in `storage/app/public/proofs/`
- Symbolic link for public access

---

## Artisan Commands

### Common Commands
```bash
# Database
php artisan migrate              # Run migrations
php artisan migrate:fresh --seed # Fresh database with seeders
php artisan db:seed              # Run seeders

# Cache
php artisan cache:clear          # Clear cache
php artisan config:clear         # Clear config cache
php artisan view:clear           # Clear view cache
php artisan route:clear          # Clear route cache

# Storage
php artisan storage:link         # Create storage symbolic link

# Queues
php artisan queue:work           # Process queue jobs
php artisan queue:listen         # Listen for queue jobs

# Development
php artisan serve                # Start development server
php artisan tinker               # Interactive shell

# Database Snapshots (Spatie)
php artisan snapshot:create name # Create snapshot
php artisan snapshot:load name   # Load snapshot
php artisan snapshot:list        # List snapshots
```

---

## Environment Variables (.env)

```env
# Application
APP_NAME=TPT
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tptv3
DB_USERNAME=root
DB_PASSWORD=

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"

# Google OAuth
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=https://your-domain.com/auth/google/callback

# Queue
QUEUE_CONNECTION=database

# Filesystem
FILESYSTEM_DISK=public
```

---

*Last Updated: February 2026*
