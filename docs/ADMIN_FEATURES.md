# Admin Features Documentation

## Admin Dashboard Overview

The admin panel provides comprehensive management tools for examinations, applications, slots, users, and reports.

**Access:** `/admin/dashboard`
**Middleware:** `is_admin` (checks `role_id === 1`)

---

## Dashboard Statistics

The admin dashboard displays real-time statistics:

```
┌─────────────────────────────────────────────────────────────────┐
│                     ADMIN DASHBOARD                              │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐              │
│  │ Total Users │  │Examinations │  │  Programs   │              │
│  │    1,250    │  │     12      │  │     45      │              │
│  └─────────────┘  └─────────────┘  └─────────────┘              │
│                                                                  │
│  Current Active Examination: TPT 2026 - Batch 1                 │
│                                                                  │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐              │
│  │Active Slots │  │  Occupied   │  │  Available  │              │
│  │    500      │  │    423      │  │     77      │              │
│  └─────────────┘  └─────────────┘  └─────────────┘              │
│                                                                  │
│  ┌─────────────────────────────┐  ┌─────────────────────────────┐│
│  │ With Permit & Slot: 400    │  │ With Permit Only: 23       ││
│  └─────────────────────────────┘  └─────────────────────────────┘│
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

**Controller:** `App\Http\Controllers\Admin\DashboardController@dashboard`

---

## Feature Modules

### 1. Examination Management

**Route:** `/admin/examinations`
**Livewire Components:**
- `Admin/Examination/Table.php` - List all examinations
- `Admin/Examination/Create.php` - Create new examination
- `Admin/Examination/Update.php` - Edit examination

**Features:**
- Create new examination
- Set examination as active/inactive (only ONE can be active)
- Enable/disable result visibility (`show_results`)
- View examination statistics

**Database:** `examinations` table

```php
// Example: Setting an examination as active
$examination->update(['is_active' => true]);

// Deactivate others
Examination::where('id', '!=', $examination->id)
    ->update(['is_active' => false]);
```

---

### 2. Application Management

**Route:** `/admin/manage-examination/{id}/applications`
**Livewire Components:**
- `Admin/Applications/Table.php` - List applications
- `Admin/Applications/View.php` - View application details
- `Admin/Applications/ViewPayment.php` - Review payment proofs

**Features:**

#### View All Applications
- Sortable by examinee number, name, status
- Filter by status (pending, approved, rejected)
- Search by name or email

#### Payment Review Process

```
┌─────────────────────────────────────────────────────────────────┐
│                    PAYMENT REVIEW                                │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Applicant: Juan Dela Cruz                                       │
│  Email: juan@example.com                                         │
│  Reference #: 12345678                                           │
│  Submitted: January 15, 2026                                     │
│                                                                  │
│  Proof Documents:                                                │
│  ┌─────────────────────┐                                        │
│  │   [View Receipt 1]  │                                        │
│  │   [View Receipt 2]  │                                        │
│  └─────────────────────┘                                        │
│                                                                  │
│  Actions:                                                        │
│  ┌───────────────┐  ┌───────────────┐                           │
│  │   APPROVE     │  │    REJECT     │                           │
│  └───────────────┘  └───────────────┘                           │
│                                                                  │
│  [If Reject - Enter Remarks]                                     │
│  ┌─────────────────────────────────────────────────────────────┐│
│  │ Rejection reason: ___________________________________      ││
│  └─────────────────────────────────────────────────────────────┘│
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

#### Approve Payment
```php
// Creates permit with examinee number
$permit = Permit::create([
    'user_id' => $user->id,
    'examination_id' => $examination->id,
    'examinee_number' => $this->generateExamineeNumber(),
]);

// Update user step
$user->update(['step' => '5']);

// Send approval email
EmailController::sendPaymentApplicationApprovalEmail($permit);
```

#### Reject Payment
```php
$user->update([
    'is_declined' => true,
    'remarks' => $rejectionReason,
]);

// Send rejection email
EmailController::sendPaymentApplicationRejectionEmail($application, $remarks);
```

---

### 3. Slot Management

**Route:** `/admin/manage-examination/{id}/applications/slots`
**Livewire Component:** `Admin/ManageSlot.php`

**Features:**

#### Test Center Management
- Create test centers for examination
- Assign campus to test center
- View slot statistics per center

#### Slot Configuration
```
┌─────────────────────────────────────────────────────────────────┐
│                    SLOT MANAGEMENT                               │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Test Center: Tagbilaran Campus - Main Building                  │
│                                                                  │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │ Slot 1                                                    │  │
│  │ Date: Feb 15, 2026 | Time: 8:00 AM                        │  │
│  │ Capacity: 50 | Occupied: 45 | Available: 5                │  │
│  │ Status: [ACTIVE]                                          │  │
│  │ Actions: [Deactivate] [Edit]                              │  │
│  └───────────────────────────────────────────────────────────┘  │
│                                                                  │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │ Slot 2                                                    │  │
│  │ Date: Feb 15, 2026 | Time: 1:00 PM                        │  │
│  │ Capacity: 50 | Occupied: 50 | Available: 0 (FULL)         │  │
│  │ Status: [ACTIVE]                                          │  │
│  └───────────────────────────────────────────────────────────┘  │
│                                                                  │
│  [+ Add New Slot]                                                │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

#### Slot Activation/Deactivation
- `is_active = true`: Slot available for selection
- `is_active = false`: Slot hidden from applicants

**Key Methods (Examination Model):**
```php
// Total slots across all test centers
$examination->totalSlots();

// Available active slots
$examination->totalAvailableActiveSlots();

// Occupied slots
$examination->totalOccupiedSlots();

// Check if slots available
$examination->hasAvailableActiveSlots();
```

---

### 4. Campus & Program Management

**Routes:**
- `/admin/campuses` - Campus management
- `/admin/programs` - Program management

**Livewire Components:**
- `CampusManagement.php`
- `Admin/ProgramOffers/Table.php`
- `Admin/ProgramOffers/Create.php`
- `Admin/ProgramOffers/Update.php`

**Features:**

#### Campus Management
- Add/Edit/Delete campuses
- View programs per campus

#### Program Management
- Create programs linked to campus
- Set program as offered/not offered (`is_offered`)
- Add program descriptions

---

### 5. User Management

**Route:** `/admin/users`
**Livewire Component:** `Admin/User.php`

**Features:**
- View all applicants (role_id = 2)
- Search by name, email
- Filter by application status
- View user details
- Reset user password (if needed)

---

### 6. Result Management

**Routes:**
- `/admin/examination-with-results` - List examinations with results
- `/admin/examination-results/{examination}` - Upload/view results
- `/admin/examinee-result-details/{result}` - Individual result details

**Livewire Components:**
- `ExaminationWithResultPage.php`
- `ExaminationResultPage.php`
- `ExamineeResultDetails.php`
- `Admin/Applications/UploadResult.php`

#### Result Import Process

```
┌─────────────────────────────────────────────────────────────────┐
│                    UPLOAD RESULTS                                │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Examination: TPT 2026 - Batch 1                                 │
│                                                                  │
│  [Select Excel File]                                             │
│                                                                  │
│  Expected Format:                                                │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │ examinee_number | math_raw | math_std | eng_raw | ...    │   │
│  │ 200001          | 45       | 7        | 40      | ...    │   │
│  │ 200002          | 38       | 5        | 42      | ...    │   │
│  └──────────────────────────────────────────────────────────┘   │
│                                                                  │
│  [Upload Results]                                                │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

**Import Class:** `App\Imports\ExaminationResultImport`

**Excel Columns:**
| Column | Field |
|--------|-------|
| examinee_number | Examinee Number |
| math_raw_score | Math Raw Score |
| math_standard_score | Math Stanine (1-9) |
| english_raw_score | English Raw Score |
| english_standard_score | English Stanine |
| filipino_raw_score | Filipino Raw Score |
| filipino_standard_score | Filipino Stanine |
| science_raw_score | Science Raw Score |
| science_standard_score | Science Stanine |
| social_studies_raw_score | Social Studies Raw |
| social_studies_standard_score | Social Studies Stanine |
| total_raw_score | Total Raw Score |
| total_standard_score | Total Stanine |

#### Enable Results Visibility
```php
// After uploading results, admin enables visibility
$examination->update(['show_results' => true]);
```

---

### 7. Reports & Exports

**Routes:**
- `/admin/report` - General reports
- `/admin/student-list-report` - Student list
- `/admin/registration-date-report` - Registration by date
- `/admin/student-report` - Result reports
- `/admin/ranking-report` - Student rankings
- `/admin/qualified-students-report` - Qualified students
- `/admin/students-score-report` - Score analysis

**Export Classes (app/Exports/):**

| Export Class | Description | File Format |
|--------------|-------------|-------------|
| `AllResultExport` | All results | Excel |
| `UserExport` | All users | Excel |
| `UsersWithoutSlotExport` | Users with permit but no slot | Excel |
| `UsersWithPermitAndSlotExport` | Users with permit and slot | Excel |
| `ResultAllExport` | Complete results | Excel |
| `ResultPerProgramExport` | Results grouped by program | Excel |
| `QualifiedStudentsExport` | Qualified students list | Excel |
| `RegistrationDateExport` | Registrations by date | Excel |
| `PermitReport` | Permit data | Excel |
| `UserSheetExport` | User sheets | Excel |

**Download Routes:**
```php
// Direct download
Route::get('/export/users-without-slot', function () {
    return Excel::download(new UsersWithoutSlotExport, 'filename.xlsx');
});

// Queued export (for large datasets)
Route::get('/export/queue-users-with-permit-and-slot',
    [QueuedExportController::class, 'exportUsersWithPermitAndSlot']);
```

---

### 8. Permit Management

**Routes:**
- `/admin/permit/{permit}/view` - View permit
- `/permit/{permit}` - Permit layout
- `/generate-pdf/{permit}` - Generate PDF

**PDF Generation:**
Uses Spatie Browsershot (Puppeteer) for high-quality PDF:

```php
$htmlContent = View::make('livewire.permit-layout', [
    'permit' => $permit
])->render();

$pdfContent = Browsershot::html($htmlContent)
    ->setOption('args', ['--disable-web-security'])
    ->pdf();

return response($pdfContent, 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' => 'inline; filename="permit.pdf"',
]);
```

---

## Admin Navigation Structure

```
Admin Dashboard
├── Dashboard (/admin/dashboard)
├── Examinations
│   ├── List Examinations (/admin/examinations)
│   ├── Manage Applications (/admin/manage-examination/{id}/applications)
│   └── Manage Slots (/admin/manage-examination/{id}/applications/slots)
├── Campuses (/admin/campuses)
├── Programs (/admin/programs)
├── Users (/admin/users)
├── Results
│   ├── Examinations with Results (/admin/examination-with-results)
│   └── Upload/View Results (/admin/examination-results/{id})
├── Reports
│   ├── General Report (/admin/report)
│   ├── Student List (/admin/student-list-report)
│   ├── Registration Dates (/admin/registration-date-report)
│   ├── Result Report (/admin/student-report)
│   ├── Ranking (/admin/ranking-report)
│   ├── Qualified Students (/admin/qualified-students-report)
│   └── Student Scores (/admin/students-score-report)
├── Monitoring (/admin/monitoring)
└── Exports (/admin/exports)
```

---

## Key Admin Actions Summary

| Action | Route/Method | Effect |
|--------|--------------|--------|
| Create Examination | Livewire Create | New exam record |
| Activate Examination | Toggle is_active | Enables registration |
| Approve Payment | Livewire action | Creates permit, step→5 |
| Reject Payment | Livewire action | Sets declined, adds remarks |
| Create Slot | Livewire action | Adds slot to test center |
| Activate/Deactivate Slot | Toggle is_active | Shows/hides slot |
| Upload Results | Excel import | Populates results table |
| Show Results | Toggle show_results | Enables result viewing |
| Export Data | Excel download | Generates spreadsheet |

---

*Last Updated: February 2026*
