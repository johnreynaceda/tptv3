# Models Documentation

## Overview

The TPT system uses 19 Eloquent models to represent the database entities. This document details each model's structure, relationships, and key methods.

---

## Model Summary

| Model | Table | Purpose |
|-------|-------|---------|
| User | users | User accounts (admins & applicants) |
| Role | roles | User roles (Admin, Applicant) |
| Type | types | Applicant types (Freshmen, Transferee) |
| Application | applications | Exam applications |
| PersonalInformation | personal_information | Student demographics |
| SchoolInformation | school_information | Previous school data |
| Payment | payments | Payment records |
| Proof | proofs | Payment proof documents |
| Permit | permits | Exam permits |
| Examination | examinations | Exam schedules |
| Result | results | Exam results/scores |
| Campus | campuses | Campus locations |
| Program | programs | Academic programs |
| ProgramChoice | program_choices | Student program preferences |
| TestCenter | test_centers | Exam testing centers |
| Slot | slots | Exam time slots |
| StudentSlot | student_slots | Student slot assignments |
| SurveyResult | survey_results | Post-exam survey |
| SelectedCourse | selected_courses | Selected courses |

---

## User Model

**File:** `app/Models/User.php`
**Table:** `users`

### Fillable Fields
```php
protected $fillable = [
    'type_id',
    'step',
    'remarks',
    'role_id',
    'first_name',
    'middle_name',
    'last_name',
    'email',
    'password',
];
```

### Hidden Fields
```php
protected $hidden = [
    'password',
    'remember_token',
    'two_factor_recovery_codes',
    'two_factor_secret',
];
```

### Casts
```php
protected $casts = [
    'email_verified_at' => 'datetime',
];
```

### Relationships
```php
// Belongs To
public function role() {
    return $this->belongsTo(Role::class);
}

// Has One
public function application() {
    return $this->hasOne(Application::class);
}

public function personal_information() {
    return $this->hasOne(PersonalInformation::class);
}

public function school_information() {
    return $this->hasOne(SchoolInformation::class);
}

public function payment() {
    return $this->hasOne(Payment::class);
}

public function permit() {
    return $this->hasOne(Permit::class);
}

public function student_slot() {
    return $this->hasOne(StudentSlot::class);
}

public function survey_result() {
    return $this->hasOne(SurveyResult::class);
}

// Has Many
public function program_choices() {
    return $this->hasMany(ProgramChoice::class);
}

public function selected_courses() {
    return $this->hasMany(SelectedCourse::class);
}
```

### Methods
```php
public function is_admin(): bool {
    return $this->role_id === 1;
}

public function scopeIsNotAdmin($query) {
    return $query->where('role_id', '!=', 1);
}
```

### Traits Used
- `HasApiTokens` (Sanctum)
- `HasFactory`
- `HasProfilePhoto` (Jetstream)
- `Notifiable`
- `TwoFactorAuthenticatable` (Fortify)

---

## Application Model

**File:** `app/Models/Application.php`
**Table:** `applications`

### Relationships
```php
public function user() {
    return $this->belongsTo(User::class);
}

public function examination() {
    return $this->belongsTo(Examination::class);
}

public function student_slot() {
    return $this->belongsTo(StudentSlot::class);
}
```

### Scopes
```php
// Order by examinee number with NULLs last
public function scopeOrderByExamineeNumber($query) {
    $query->leftJoin('permits', 'applications.user_id', '=', 'permits.user_id')
          ->orderByRaw('CASE WHEN permits.examinee_number IS NULL THEN 1 ELSE 0 END, permits.examinee_number ASC')
          ->select('applications.*');
}
```

---

## PersonalInformation Model

**File:** `app/Models/PersonalInformation.php`
**Table:** `personal_information`

### Relationships
```php
public function user() {
    return $this->belongsTo(User::class);
}
```

### Methods
```php
// Format: "Last Name, First Name Middle Name"
public function fullName(): string {
    $firstName = $this->first_name ?? '';
    $middleName = $this->middle_name ? " {$this->middle_name}" : '';
    $lastName = $this->last_name ?? '';

    return trim("{$lastName}, {$firstName}{$middleName}");
}
```

### Accessors
```php
// Returns formatted date: "January 15, 2000"
public function getFormattedDateOfBirthAttribute() {
    if (!$this->date_of_birth) {
        return '';
    }
    return \Carbon\Carbon::createFromFormat('Y-m-d', $this->date_of_birth)
        ->format('F j, Y');
}
```

---

## SchoolInformation Model

**File:** `app/Models/SchoolInformation.php`
**Table:** `school_information`

### Relationships
```php
public function user() {
    return $this->belongsTo(User::class);
}
```

---

## Examination Model

**File:** `app/Models/Examination.php`
**Table:** `examinations`

### Relationships
```php
public function applications() {
    return $this->hasMany(Application::class);
}

public function results() {
    return $this->hasMany(Result::class);
}

public function permits() {
    return $this->hasMany(Permit::class);
}

public function test_centers() {
    return $this->hasMany(TestCenter::class);
}
```

### Slot Calculation Methods
```php
// Total slots across all test centers
public function totalSlots() {
    return $this->test_centers->sum(function ($testCenter) {
        return $testCenter->slots->sum('slots');
    });
}

// Available slots (total - occupied)
public function totalAvailableSlots() {
    return $this->test_centers->sum(function ($testCenter) {
        return $testCenter->totalAvailableSlots();
    });
}

// Activated slots only
public function totalActivatedSlots() {
    return $this->test_centers->sum(function ($testCenter) {
        return $testCenter->slots->where('is_active', true)->sum('slots');
    });
}

// Non-activated slots
public function totalNonActivatedSlots() {
    return $this->test_centers->sum(function ($testCenter) {
        return $testCenter->slots->where('is_active', false)->sum('slots');
    });
}

// Occupied slots
public function totalOccupiedSlots() {
    return $this->test_centers->sum(function ($testCenter) {
        return $testCenter->slots->sum(function ($slot) {
            return $slot->student_slots->count();
        });
    });
}

// Vacant slots
public function totalVacantSlots() {
    return $this->totalSlots() - $this->totalOccupiedSlots();
}

// Active slots (using join for efficiency)
public function totalActiveSlots() {
    return $this->test_centers()
        ->join('slots', 'test_centers.id', '=', 'slots.test_center_id')
        ->where('slots.is_active', true)
        ->sum('slots.slots');
}

// Occupied active slots
public function totalOccupiedActiveSlots() {
    return $this->test_centers()
        ->join('slots', 'test_centers.id', '=', 'slots.test_center_id')
        ->leftJoin('student_slots', 'slots.id', '=', 'student_slots.slot_id')
        ->where('slots.is_active', true)
        ->count('student_slots.id');
}

// Available active slots
public function totalAvailableActiveSlots() {
    return $this->totalActiveSlots() - $this->totalOccupiedActiveSlots();
}

// Boolean checks
public function hasAvailableSlotsForActivation() {
    return $this->totalNonActivatedSlots() > 0;
}

public function hasNoVacantSlots() {
    return $this->totalVacantSlots() <= 0;
}

public function hasAvailableActiveSlots() {
    return $this->totalAvailableActiveSlots() > 0;
}

public function hasNoAvailableActiveSlots() {
    return $this->totalAvailableActiveSlots() <= 0;
}
```

---

## Permit Model

**File:** `app/Models/Permit.php`
**Table:** `permits`

### Relationships
```php
public function user() {
    return $this->belongsTo(User::class);
}

public function result() {
    return $this->hasOne(Result::class, 'examinee_number', 'examinee_number_updated');
}

public function examination() {
    return $this->belongsTo(Examination::class);
}
```

### Methods
```php
// Generate QR code data
public function generateQrData() {
    $examineeName = optional($this->user)->personal_information->fullName() ?? 'Unknown';
    $examineeNumber = $this->examinee_number ?? 'N/A';

    $studentSlot = optional($this->user->application)->student_slot;

    $examDate = optional($studentSlot?->slot)->date_of_exam
        ? \Carbon\Carbon::parse($studentSlot->slot->date_of_exam)->format('F d, Y')
        : 'Not Assigned';

    $examTime = $studentSlot?->time ?? 'Not Assigned';
    $roomNumber = $studentSlot?->room_number ?? 'Not Assigned';
    $seatNumber = $studentSlot?->seat_number ?? 'Not Assigned';

    return "Examinee Name: $examineeName\n" .
           "Examinee Number: $examineeNumber\n" .
           "Exam Date: $examDate\n" .
           "Exam Time: $examTime\n" .
           "Room Number: $roomNumber\n" .
           "Seat Number: $seatNumber";
}

public function getExamDate() {
    return optional(optional($this->student_slot)->slot)->date_of_exam ?? 'Not Assigned';
}
```

---

## Result Model

**File:** `app/Models/Result.php`
**Table:** `results`

### Casts
```php
protected $casts = [
    'show_result' => 'boolean',
];
```

### Relationships
```php
public function examination() {
    return $this->belongsTo(Examination::class);
}
```

### Methods
```php
// Convert stanine score to interpretation
public function stanineInterpretation($stanine) {
    if ($stanine == 9) return 'Outstanding';
    if ($stanine == 8) return 'Above Average';
    if ($stanine == 7) return 'Above Average';
    if ($stanine == 6) return 'High Average';
    if ($stanine == 5) return 'Middle Average';
    if ($stanine == 4) return 'Low Average';
    if ($stanine == 3) return 'Below Average';
    if ($stanine == 2) return 'Below Average';
    if ($stanine == 1) return 'Low';
    return '';
}
```

---

## TestCenter Model

**File:** `app/Models/TestCenter.php`
**Table:** `test_centers`

### Relationships
```php
public function campus() {
    return $this->belongsTo(Campus::class);
}

public function slots() {
    return $this->hasMany(Slot::class);
}

public function examination() {
    return $this->belongsTo(Examination::class);
}
```

### Scopes
```php
public function scopeWithRelations($query) {
    return $query->with(['campus', 'slots']);
}

public function scopeTotalSlots($query) {
    return $query->withCount('slots');
}
```

### Methods
```php
public function totalOccupiedSlots() {
    return $this->slots->sum(function ($slot) {
        return $slot->student_slots->count();
    });
}

public function totalNumberOfSlot() {
    return $this->slots->sum('slots');
}

public function totalAvailableSlots() {
    return $this->totalNumberOfSlot() - $this->totalOccupiedSlots();
}

public function hasAvailableSlots() {
    return $this->totalAvailableSlots() > 0;
}
```

---

## Slot Model

**File:** `app/Models/Slot.php`
**Table:** `slots`

### Relationships
```php
public function test_center() {
    return $this->belongsTo(TestCenter::class);
}

public function student_slots() {
    return $this->hasMany(StudentSlot::class);
}
```

### Scopes
```php
public function scopeTotalSlots($query) {
    return $query->withCount('student_slots');
}
```

---

## StudentSlot Model

**File:** `app/Models/StudentSlot.php`
**Table:** `student_slots`

### Relationships
```php
public function application() {
    return $this->hasOne(Application::class);
}

public function slot() {
    return $this->belongsTo(Slot::class, 'slot_id');
}

public function users() {
    return $this->belongsTo(User::class, 'user_id');
}
```

### Methods
```php
public function generateQrData() {
    if (!$this->slot) {
        return 'No Slot Assigned';
    }

    return "Name: " . (optional($this->user)->name ?? 'Unknown') .
           "\nExam Number: " . (optional($this->application)->examinee_number ?? 'N/A') .
           "\nDate: " . (optional($this->slot)->date_of_exam ?? 'N/A') .
           "\nRoom: " . ($this->room_number ?? 'N/A') .
           "\nSeat: " . ($this->seat_number ?? 'N/A');
}
```

---

## Payment Model

**File:** `app/Models/Payment.php`
**Table:** `payments`

### Relationships
```php
public function proofs() {
    return $this->hasMany(Proof::class);
}

public function user() {
    return $this->belongsTo(User::class);
}
```

---

## Proof Model

**File:** `app/Models/Proof.php`
**Table:** `proofs`

### Relationships
```php
public function payment() {
    return $this->belongsTo(Payment::class);
}
```

---

## Campus Model

**File:** `app/Models/Campus.php`
**Table:** `campuses`

### Relationships
```php
public function programs() {
    return $this->hasMany(Program::class);
}

public function test_centers() {
    return $this->hasMany(TestCenter::class);
}
```

---

## Program Model

**File:** `app/Models/Program.php`
**Table:** `programs`

### Relationships
```php
public function campus() {
    return $this->belongsTo(Campus::class);
}

public function program_choices() {
    return $this->hasMany(ProgramChoice::class);
}
```

---

## ProgramChoice Model

**File:** `app/Models/ProgramChoice.php`
**Table:** `program_choices`

### Relationships
```php
public function user() {
    return $this->belongsTo(User::class);
}

public function program() {
    return $this->belongsTo(Program::class);
}
```

---

## Role Model

**File:** `app/Models/Role.php`
**Table:** `roles`

### Seeded Data
| id | name |
|----|------|
| 1 | Admin |
| 2 | Applicant |

### Relationships
```php
public function users() {
    return $this->hasMany(User::class);
}
```

---

## Type Model

**File:** `app/Models/Type.php`
**Table:** `types`

### Seeded Data
| id | name |
|----|------|
| 1 | Freshmen |
| 2 | Transferee |

---

## SurveyResult Model

**File:** `app/Models/SurveyResult.php`
**Table:** `survey_results`

### Relationships
```php
public function user() {
    return $this->belongsTo(User::class);
}
```

---

## SelectedCourse Model

**File:** `app/Models/SelectedCourse.php`
**Table:** `selected_courses`

### Relationships
```php
public function user() {
    return $this->belongsTo(User::class);
}

public function program() {
    return $this->belongsTo(Program::class);
}
```

---

## Common Patterns

### Guarded vs Fillable

All models use `$guarded = []` which means all attributes are mass-assignable. This is a flexible approach but requires careful validation at the controller/Livewire level.

```php
protected $guarded = [];
```

### Factory Pattern

All models use the `HasFactory` trait for testing:

```php
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;
}
```

### Soft Deletes

Note: This project does **not** use soft deletes. Records are permanently deleted.

---

## Usage Examples

### Create User with Related Data

```php
// Create user
$user = User::create([
    'first_name' => 'Juan',
    'last_name' => 'Dela Cruz',
    'email' => 'juan@example.com',
    'role_id' => 2,
    'step' => '1',
]);

// Create personal information
$user->personal_information()->create([
    'type_id' => 1,
    'first_name' => 'Juan',
    'last_name' => 'Dela Cruz',
    // ... other fields
]);

// Create application
$user->application()->create([
    'examination_id' => 1,
    'submitted_at' => now(),
]);
```

### Query with Eager Loading

```php
// Load user with all related data
$user = User::with([
    'personal_information',
    'school_information',
    'program_choices.program.campus',
    'application.examination',
    'permit.result',
    'student_slot.slot.test_center',
])->find($id);
```

### Check Examination Slots

```php
$examination = Examination::with('test_centers.slots.student_slots')->find(1);

echo "Total Slots: " . $examination->totalSlots();
echo "Available: " . $examination->totalAvailableActiveSlots();
echo "Occupied: " . $examination->totalOccupiedSlots();

if ($examination->hasAvailableActiveSlots()) {
    echo "Slots are available for selection";
}
```

---

*Last Updated: February 2026*
