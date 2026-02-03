# API & Routes Documentation

## Route Overview

The TPT system primarily uses web routes with Livewire for reactive functionality. API routes are minimal and used for authenticated user data.

---

## Web Routes

### Public Routes (No Authentication)

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/` | - | Redirects to dashboard |
| GET | `/admin/login` | login.admin | Admin login page |
| GET | `/auth/google` | auth.google.redirect | Initiate Google OAuth |
| GET | `/auth/google/callback` | auth.google.callBack | Google OAuth callback |
| GET | `/privacy-policy` | privacy.policy | Privacy policy page |
| GET | `/forgot-password` | forgot-password | Password reset form |

### Authenticated Routes (All Users)

| Method | URI | Name | Middleware | Description |
|--------|-----|------|------------|-------------|
| GET | `/dashboard` | dashboard | auth, verified | Role-based redirect |
| GET | `/permit/{permit}` | admin.permit | auth | View permit layout |
| GET | `/generate-pdf/{permit}` | admin.generate-pdf-permit | auth | Generate permit PDF |
| GET | `/generate-examination/{examinee_number}` | admin.generate-examination-result | auth | Generate result PDF |
| GET | `/tpt-result/{examinee_number}` | generate-examination-result | auth | View result PDF |

---

## Admin Routes

**Prefix:** `/admin`
**Middleware:** `auth:sanctum`, `is_admin`, `verified`

### Dashboard & Management

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/dashboard` | admin.dashboard | Admin dashboard |
| GET | `/campuses` | admin.campuses | Campus management |
| GET | `/examinations` | admin.examinations | Examination management |
| GET | `/programs` | admin.programs | Program management |
| GET | `/users` | admin.users | User management |
| GET | `/monitoring` | admin.monitoring | System monitoring |

### Examination Management

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/examination-with-results` | admin.examination-with-results | Exams with results |
| GET | `/examination-results/{examination}` | admin.examination-results | View/upload results |
| GET | `/examinee-result-details/{result}` | admin.examinee-result-details | Individual result |
| GET | `/manage-examination/{id}/applications` | admin.manage-examination.applications | Manage applications |
| GET | `/manage-examination/{id}/applications/slots` | admin.manage-examination.applications.slots | Manage slots |

### Reports

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/report` | admin.reports | General reports |
| GET | `/student-list-report` | admin.student-list-report | Student list |
| GET | `/registration-date-report` | admin.registration-date-report | Registration dates |
| GET | `/student-report` | admin.result-report | Result reports |
| GET | `/ranking-report` | admin.ranking-report | Student rankings |
| GET | `/qualified-students-report` | admin.qualified-students-report | Qualified students |
| GET | `/students-score-report` | admin.students-score | Score analysis |

### Exports

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/export/users-without-slot` | export.users_without_slot | Export users without slot |
| GET | `/export/users-with-slot` | export.users_with_slot | Export users with slot |
| GET | `/export/queue-users-with-permit-and-slot` | export.queue_users_with_permit_and_slot | Queued export |
| GET | `/exports` | export.list | List exports |
| GET | `/exports/download/{filename}` | export.download | Download export file |

### Permit Management

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/permit/{permit}/view` | admin.permit.view | View permit details |

---

## Applicant Routes

**Prefix:** `/applicant`
**Middleware:** `auth:sanctum`, `is_applicant`, `verified`

| Method | URI | Name | Additional Middleware | Description |
|--------|-----|------|----------------------|-------------|
| GET | `/home` | applicant.home | - | Applicant dashboard |
| GET | `/fill/application` | applicant.fill.application | step_two | Application form |
| GET | `/payment` | applicant.payment | step_three | Payment page |
| GET | `/permit` | applicant.permit-generate | step_five | View permit |
| GET | `/result` | print.result | survey.result | View result |
| GET | `/survey` | show.survey | - | Survey form |
| GET | `/select-course` | select.courses | - | Course selection |
| GET | `/select-test-center` | applicant.test-center | - | Slot selection |

---

## API Routes

**Prefix:** `/api`
**File:** `routes/api.php`

| Method | URI | Middleware | Description |
|--------|-----|------------|-------------|
| GET | `/user` | auth:sanctum | Get authenticated user |

### API Authentication

Uses Laravel Sanctum for API token authentication:

```php
// Generate token
$token = $user->createToken('api-token')->plainTextToken;

// Use in requests
Authorization: Bearer {token}
```

---

## Livewire Components (AJAX Endpoints)

Livewire components handle AJAX requests automatically. Key components:

### Admin Components

| Component | Path | Purpose |
|-----------|------|---------|
| `Admin\Applications\Table` | admin/applications | List applications |
| `Admin\Applications\View` | admin/applications | View application |
| `Admin\Applications\ViewPayment` | admin/applications | Review payment |
| `Admin\Applications\UploadResult` | admin/results | Upload results |
| `Admin\Examination\Table` | admin/examinations | List examinations |
| `Admin\Examination\Create` | admin/examinations | Create examination |
| `Admin\Examination\Update` | admin/examinations | Edit examination |
| `Admin\ManageSlot` | admin/slots | Slot management |
| `Admin\User` | admin/users | User management |

### Applicant Components

| Component | Path | Purpose |
|-----------|------|---------|
| `Applicant\GetStartedButton` | applicant/home | Start application |
| `Applicant\PersonalInfo` | applicant/fill | Personal information |
| `Applicant\SchoolInfo` | applicant/fill | School information |
| `Applicant\ProgramInfo` | applicant/fill | Program selection |
| `Applicant\ButtonSubmitApplication` | applicant/fill | Submit application |
| `Applicant\PaymentSection` | applicant/payment | Payment submission |
| `Applicant\SelectTestingCenter` | applicant/slot | Slot selection |
| `Applicant\Survey` | applicant/survey | Survey form |
| `Applicant\SelectCourses` | applicant/courses | Course selection |

### Other Components

| Component | Purpose |
|-----------|---------|
| `PermitLayout` | Render permit |
| `ViewPermit` | Display permit |
| `ExaminationResultPage` | Show results |
| `ExamineeResultDetails` | Result details |
| `CampusManagement` | Campus CRUD |

---

## Route Parameters

### Dynamic Parameters

| Parameter | Type | Example | Description |
|-----------|------|---------|-------------|
| `{permit}` | Model | `/permit/1` | Permit ID (route model binding) |
| `{examination}` | Model | `/examination-results/1` | Examination ID |
| `{result}` | Model | `/examinee-result-details/1` | Result ID |
| `{id}` | Integer | `/manage-examination/1/applications` | Examination ID |
| `{examinee_number}` | String | `/generate-examination/200001` | Examinee number |
| `{filename}` | String | `/exports/download/report.xlsx` | Export filename |

---

## Controller Methods

### HomeController

```php
class HomeController extends Controller
{
    // GET /applicant/home
    public function home()
    {
        // Returns applicant dashboard with:
        // - has_application
        // - has_result
        // - has_survey_result
        // - has_selected_course
        // - active_examination
        // - slot statistics
    }

    // GET /applicant/fill/application
    public function fillApplication()
    {
        // Returns form page with:
        // - has_available_slots
        // - has_personal_information
        // - has_school_information
        // - has_program_choice
    }

    // GET /applicant/payment
    public function payment()
    {
        // Returns payment page
    }
}
```

### DashboardController (Admin)

```php
class DashboardController extends Controller
{
    // GET /admin/dashboard
    public function dashboard()
    {
        // Returns dashboard with:
        // - users_count
        // - examinations_count
        // - programs_count
        // - slot statistics
        // - users with/without slots
        // - current_active_examination
    }
}
```

### GoogleController

```php
class GoogleController extends Controller
{
    // GET /auth/google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // GET /auth/google/callback
    public function callBack()
    {
        // Handle OAuth callback
        // Create/login user
        // Redirect to dashboard
    }
}
```

### EmailController

```php
class EmailController extends Controller
{
    // Static method called by Livewire
    public static function sendPaymentApplicationApprovalEmail(Permit $permit)
    {
        // Send approval email
    }

    // Static method called by Livewire
    public static function sendPaymentApplicationRejectionEmail($application, $remarks)
    {
        // Send rejection email
    }
}
```

### PrintPermitController

```php
class PrintPermitController extends Controller
{
    // GET /applicant/permit
    public function generate()
    {
        // Return permit view
    }
}
```

### ResultController

```php
class ResultController extends Controller
{
    // GET /applicant/result
    public function result()
    {
        // Return result view
    }
}
```

### QueuedExportController

```php
class QueuedExportController extends Controller
{
    // GET /admin/export/queue-users-with-permit-and-slot
    public function exportUsersWithPermitAndSlot()
    {
        // Queue large export job
    }

    // GET /admin/exports
    public function listExports()
    {
        // List available exports
    }

    // GET /admin/exports/download/{filename}
    public function downloadExport($filename)
    {
        // Download export file
    }
}
```

---

## Route Middleware Groups

### Web Middleware (Kernel.php)

```php
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];
```

### Route Middleware Aliases

```php
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

    // Custom middleware
    'is_admin' => \App\Http\Middleware\IsAdmin::class,
    'is_applicant' => \App\Http\Middleware\IsApplicant::class,
    'step_two' => \App\Http\Middleware\StepTwo::class,
    'step_three' => \App\Http\Middleware\StepThree::class,
    'step_five' => \App\Http\Middleware\StepFive::class,
    'survey.result' => \App\Http\Middleware\SurveyResultMiddleware::class,
];
```

---

## Request/Response Examples

### Dashboard Redirect

```
GET /dashboard

Response (Admin):
HTTP 302 → /admin/dashboard

Response (Applicant):
HTTP 302 → /applicant/home
```

### Google OAuth Flow

```
1. GET /auth/google
   Response: HTTP 302 → https://accounts.google.com/o/oauth2/...

2. Google redirects back:
   GET /auth/google/callback?code=...

   Response: HTTP 302 → /dashboard
```

### PDF Generation

```
GET /generate-pdf/{permit}

Response:
HTTP 200
Content-Type: application/pdf
Content-Disposition: inline; filename="Juan_Dela_Cruz_PERMIT.pdf"
[PDF binary content]
```

### Excel Export

```
GET /admin/export/users-with-slot

Response:
HTTP 200
Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
Content-Disposition: attachment; filename="students_with_slots_and_permit_2026.xlsx"
[Excel binary content]
```

---

## Error Responses

| Status | Description | Common Causes |
|--------|-------------|---------------|
| 401 | Unauthorized | Not authenticated |
| 403 | Forbidden | Wrong role (admin vs applicant) |
| 404 | Not Found | Invalid ID/route |
| 419 | Page Expired | CSRF token mismatch |
| 422 | Validation Error | Form validation failed |
| 500 | Server Error | Application error |

---

*Last Updated: February 2026*
