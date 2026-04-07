# SKSU TPT v3 — Project Rebuild Documentation

> **SKSU Tertiary Placement Test System v3**
> Complete rebuild of the examination management system for Sultan Kudarat State University.

---

## Table of Contents

1. [Overview](#overview)
2. [Tech Stack](#tech-stack)
3. [Roles & Permissions](#roles--permissions)
4. [System Settings](#system-settings)
5. [Admin Flow](#admin-flow)
6. [Applicant Flow](#applicant-flow)
7. [Cashier Flow](#cashier-flow)
8. [Staff Flow (Exam Day)](#staff-flow-exam-day)
9. [Application State Machine](#application-state-machine)
10. [Exam Scheduling Rules](#exam-scheduling-rules)
11. [Results & Scoring Engine](#results--scoring-engine)
12. [Program Qualification Logic](#program-qualification-logic)
13. [Attendance System](#attendance-system)
14. [Survey System](#survey-system)
15. [Notifications & Announcements](#notifications--announcements)
16. [Reporting & Exports](#reporting--exports)
17. [AI Features (Future)](#ai-features-future)
18. [Project Structure](#project-structure)
19. [Deployment](#deployment)
20. [Key Design Decisions](#key-design-decisions)

---

## Overview

### What Is This System?

A web-based platform that manages the entire lifecycle of SKSU's entrance examination:

**Register → Complete Profile → Pay → Pick Schedule → Get Permit → Take Exam → View Results**

### Why Rebuild?

The v2 system (Laravel 9 + Livewire) had critical limitations:

- Hardcoded subjects — adding a new subject required code changes
- Hardcoded stanine ranges, cutoffs, and examinee number patterns
- Rigid 5-step middleware — applicants couldn't go back or edit
- Manual payment verification — admin reviewed 9,000+ receipt photos one by one
- No audit trail, no attendance tracking, no real-time notifications
- First-come-first-served slot selection — unfair
- Single-role system — only Admin or Applicant, nothing in between
- No historical data support — only one active exam cycle visible

### What Changes?

| Area | v2 (Old) | v3 (New) |
|------|----------|----------|
| Subjects | Hardcoded columns | Dynamic per exam cycle |
| Cutoffs | Hardcoded 374 | Configurable per program per exam |
| Stanine | Hardcoded ranges | Configurable score guide per exam |
| Examinee # | Hardcoded 500001 | Configurable start per exam |
| Payment | Receipt photo upload → manual review | Cashier at any campus → instant |
| Application flow | Rigid 5-step middleware | Flexible state machine |
| Roles | Admin / Applicant only | SuperAdmin, Admin, Staff, Cashier, Applicant |
| Permissions | role_id on user | Spatie granular permissions |
| Scheduling | Time slots, first-come-first-served | Date + campus selection, auto seat assignment |
| Results | Bulk upload only | Bulk upload + individual add |
| Attendance | None | QR scan on exam day |
| Notifications | Email only | In-app + email |
| Audit | None | Every action logged |
| Frontend | Blade + Livewire | Vue 3 + Inertia.js v3 |
| Queue | Sync (blocks request) | Redis (background jobs) |
| API | None | Sanctum (ready for mobile) |
| AI | None | Laravel AI SDK available |

---

## Tech Stack

### Core

| Technology | Version | Purpose |
|-----------|---------|---------|
| Laravel | 13 | Backend framework (PHP 8.3+) |
| Vue 3 | 3.x | Frontend framework (Composition API) |
| Inertia.js | v3 | SPA-like experience without API |
| Tailwind CSS | 4.x | Utility-first styling |
| MySQL | 8 | Primary database |
| Redis | Latest | Cache, queues, sessions, seat locking |

### Laravel Packages

| Package | Purpose |
|---------|---------|
| Spatie Laravel Permission | Roles & granular permissions |
| Spatie Media Library v11 | File uploads (photos, documents, exports) |
| Maatwebsite Laravel Excel | Result import, data exports |
| Barryvdh Laravel DomPDF | Permit PDFs, result PDFs |
| Laravel AI SDK | AI-powered features (first-party) |
| Simple QRCode | QR codes on permits |
| Laravel Sanctum | API authentication (future mobile) |
| Laravel Socialite | Google OAuth login |

### Infrastructure

| Component | Choice |
|-----------|--------|
| Hosting | Digital Ocean Droplet |
| Web Server | Nginx |
| Queue Worker | Redis |
| SSL | Let's Encrypt |
| Storage | Local / DO Spaces (future) |

---

## Roles & Permissions

Using **Spatie Laravel Permission** — roles managed through UI, each permission checkable.

### Roles

| Role | Description |
|------|-------------|
| **SuperAdmin** | Full system access including settings, roles, permissions |
| **Admin** | Exam management, results, reports, user management |
| **Staff** | Attendance scanning, monitoring, limited reports |
| **Cashier** | Search applicants + record payments ONLY |
| **Applicant** | Apply, pay, pick schedule, view results |

### Permission Groups

```
Examinations:       view, create, update, delete, activate
Applications:       view, search, manage
Payments:           view, create, manage
Schedules:          view, create, update, delete
Attendance:         scan, view, report
Results:            view, upload, add_individual, publish
Reports:            view, export
Programs:           view, manage
Campuses:           view, manage
Users:              view, manage
Roles:              manage
Permissions:        manage
Settings:           view, manage
Announcements:      view, create, manage
Surveys:            view, create, manage
```

### Real-World Example

- **Cashier Joy** at Isulan campus: can ONLY search applicants and record payments
- **Staff Rico** at ACCESS campus: can ONLY scan QR codes and view attendance
- **Admin Ms. Cruz**: manages exams, applications, results, reports — but NOT settings or roles
- **SuperAdmin (IT head)**: can change settings, create roles, assign permissions
- **Campus Coordinator (custom role)**: view applications + attendance + reports for their campus only

---

## System Settings

Global configuration stored in `settings` table. Editable by SuperAdmin through the UI.

| Setting | Example Value | Purpose |
|---------|--------------|---------|
| `default_subjects` | `["English","Science","Math","Filipino","Social Studies","ESM"]` | Template for new exam cycles |
| `stanine_labels` | `{"9":"Outstanding","8":"Above Average",...}` | Default qualitative interpretation |
| `exam_fee_amount` | `300` | Expected payment amount (for cashier validation) |

**Per-exam settings** (stored on the examination record, not global):

| Setting | Example | Purpose |
|---------|---------|---------|
| `examinee_number_start` | `600001` | Starting number for this exam cycle |
| Subjects | Pulled from defaults, editable | What subjects this exam covers |
| Score configs | Stanine ranges for this exam | How scores are interpreted |
| Program cutoffs | Per program per exam | Qualification thresholds |

---

## Admin Flow

### Phase 1: System Setup (One-Time)

```
1. Configure global settings (default subjects, stanine labels, fee amount)
2. Add campuses (ACCESS, Isulan, Tacurong, Lutayan, Palimbang, Kalamansig, Bagumbayan)
3. Add programs per campus (57 programs across 7 campuses)
4. Create roles and assign permissions
5. Create user accounts for staff and cashiers
```

### Phase 2: Create Examination

```
1. Create exam: "SKSU TPT SY 2027-2028"
   ├── Set application period (Jan 15 – Mar 15)
   ├── Set examinee number start (600001)
   └── Activate examination (only one active at a time)

2. Configure subjects (auto-pulled from defaults, editable):
   ├── English
   ├── Science
   ├── Mathematics
   ├── Filipino
   ├── Social Studies
   ├── ESM Competency Score
   └── (add more if needed)

3. Configure score settings:
   ├── Stanine ranges (e.g., stanine 9 = 750-800)
   └── Qualitative labels (e.g., 9 = "Outstanding")

4. Set program cutoffs:
   ├── BS Nursing: 400
   ├── BS Education: 300
   ├── BS IT: 350
   └── (per program, per exam cycle)
```

### Phase 3: Create Exam Schedules

```
Admin adds schedules (as many as needed):

  March 21 — ACCESS Campus    — 1,000 capacity — 20 rooms
  March 22 — ACCESS Campus    — 1,000 capacity — 20 rooms
  March 23 — ACCESS Campus    —   500 capacity — 10 rooms
  March 23 — Isulan Campus    —   800 capacity — 16 rooms
  March 23 — Lutayan Campus   —   300 capacity —  6 rooms
  March 24 — Tacurong Campus  —   600 capacity — 12 rooms

Rules:
  - Same date + different campus = ALLOWED
  - Same date + same campus = NOT ALLOWED (extend capacity instead)
  - Rooms auto-generated: capacity / num_rooms = seats per room
  - Must divide evenly
  - Can extend capacity later without disrupting existing data
  - Can deactivate for emergencies
  - Can add new schedules anytime
```

### Phase 4: Monitor Applications

```
Dashboard shows:
  ├── Total registered
  ├── Awaiting payment
  ├── Payment verified
  ├── Scheduled (picked slot)
  ├── Permits issued
  ├── Per-campus breakdown
  └── Real-time seat availability per schedule
```

### Phase 5: Exam Day Monitoring

```
Live attendance dashboard:
  ├── March 21 ACCESS — 923 present, 12 late, 65 absent
  ├── March 23 Isulan — 756 present, 8 late, 36 absent
  └── Actual turnout vs capacity
```

### Phase 6: Results Management

```
A. Bulk Upload (Excel):
   1. Upload Excel file
   2. System maps columns to configured subjects
   3. Preview: "8,937 records, 6 subjects matched"
   4. Validation: cross-check attendance, flag duplicates
   5. Confirm → import with auto stanine calculation

B. Individual Add:
   1. Search by examinee number or name
   2. Enter scores per subject (dynamic form)
   3. Stanine auto-calculated from score config
   4. Audit trail: who added, when

C. Publish Results:
   1. Toggle results_published on examination
   2. All applicants get notification
   3. Applicants see scores + ALL qualifying programs
```

### Phase 7: Reports & Exports

```
  ├── Ranking per program (sorted by score)
  ├── Qualified students per program per campus
  ├── Attendance report (present/absent per schedule)
  ├── Payment report (per campus, per cashier)
  ├── Capacity vs turnout report
  ├── Registration date report
  ├── Score distribution per subject
  └── All exportable to Excel (queued for large datasets)
```

---

## Applicant Flow

### Step 1: Register / Login

```
- Create account (email + password)
- OR sign in with Google (Socialite)
- System assigns Applicant role
- Re-applicants: same account, profile carries over
```

### Step 2: Complete Profile

```
One unified form:
  ├── Personal: name, birthday, address, contact, gender
  ├── School: school name, strand, GPA, year graduated, LRN
  ├── Upload: 2x2 photo, valid ID
  ├── Program Preference (optional guide — NOT a restriction):
  │     1st choice: BS Nursing
  │     2nd choice: BS Biology
  │     3rd choice: BS Education
  └── Can edit anytime before exam day
```

### Step 3: Pay at Any Campus

```
1. Applicant goes to nearest campus cashier
2. Shows application number
3. Pays exam fee (e.g., PHP 300)
4. Cashier records in system → instantly verified
5. In-app notification: "Payment confirmed!"
6. No receipt photo upload needed
7. No waiting days for approval
```

### Step 4: Pick Exam Schedule

```
Applicant sees available schedules:

  ACCESS Campus
    ☐ March 21 — 847 seats remaining
    ☐ March 22 — 623 seats remaining
    ☐ March 23 — 500 seats remaining

  Isulan Campus
    ☐ March 23 — 412 seats remaining

  Lutayan Campus
    ☐ March 23 — 289 seats remaining

  Tacurong Campus
    ☐ March 24 — 600 seats remaining

Applicant picks one → system auto-assigns room + seat.
Can change schedule if seats available elsewhere.
If emergency cancellation → prompted to re-pick.
```

### Step 5: Permit Generated

```
Auto-generated after picking schedule:
  ├── Examinee Number (from exam config)
  ├── QR Code (for attendance scanning)
  ├── Name, photo
  ├── Schedule: date + campus
  ├── Room + seat number
  └── Download as PDF / Print
```

### Step 6: Exam Day

```
Arrive at campus → staff scans QR on permit → take exam
```

### Step 7: View Results

```
When results are published:
  ├── Per-subject scores with stanine + interpretation
  ├── Overall score
  ├── List of ALL programs applicant qualifies for
  │   (not just preference — every program where score >= cutoff)
  └── Download result PDF
```

---

## Cashier Flow

```
Cashier logs in → sees ONLY the payment screen.

1. Search applicant by name or application number
2. Verify applicant identity
3. Accept payment in person
4. Record in system:
   ├── Amount paid
   ├── Receipt / OR number
   ├── Auto-tagged: campus, cashier ID, timestamp
5. Payment instantly verified
6. Applicant can now pick schedule

Validation:
  - If amount ≠ expected fee → warning shown, cashier must confirm
  - Duplicate payment check (application already paid)
  - Audit trail on every payment
```

---

## Staff Flow (Exam Day)

```
Staff opens scan page on phone/tablet (web-based, no app install).

1. Camera activates
2. Scan QR code on applicant's permit
3. System shows:
   ├── ✅ PRESENT — "Maria Santos, Room 5, Seat 23"
   ├── ⚠️ LATE — with timestamp
   └── ❌ INVALID — "Already scanned" / "Not found" / "Wrong schedule"
4. Admin sees live attendance count per schedule
```

---

## Application State Machine

Flexible state transitions instead of rigid step middleware:

```
draft → submitted → payment_pending → payment_verified
  → scheduled → permit_issued → examined → resulted

Forward transitions:
  draft            → submitted         (profile complete)
  submitted        → payment_pending   (auto — awaiting cashier)
  payment_pending  → payment_verified  (cashier records payment)
  payment_verified → scheduled         (applicant picks schedule)
  scheduled        → permit_issued     (auto — permit generated)
  permit_issued    → examined          (QR scanned on exam day)
  examined         → resulted          (results uploaded/added)

Backward transitions (when needed):
  scheduled        → payment_verified  (change schedule)
  submitted        → draft             (edit profile)
```

Implemented using Laravel Enums:

```php
enum ApplicationStatus: string {
    case Draft = 'draft';
    case Submitted = 'submitted';
    case PaymentPending = 'payment_pending';
    case PaymentVerified = 'payment_verified';
    case Scheduled = 'scheduled';
    case PermitIssued = 'permit_issued';
    case Examined = 'examined';
    case Resulted = 'resulted';
}
```

---

## Exam Scheduling Rules

### Constraints

| Rule | Enforcement |
|------|------------|
| One schedule per date per campus | `UNIQUE(examination_id, campus_id, date)` |
| Same date, different campuses | Allowed |
| Rooms auto-generated | `capacity / num_rooms = seats_per_room` (must divide evenly) |
| Capacity extension | Add rooms/seats without disrupting existing assignments |
| Emergency deactivation | `is_active = false`, students notified to re-pick |
| New schedules anytime | Admin can add more dates/campuses as needed |

### Seat Assignment (Concurrency Safe)

```
When applicant picks a schedule:
  1. BEGIN TRANSACTION
  2. SELECT first empty seat WHERE application_id IS NULL FOR UPDATE (row lock)
  3. UPDATE seat → set application_id
  4. COMMIT

If concurrent request → waits for lock → gets next available seat.
Redis atomic counters for "seats remaining" display.
```

---

## Results & Scoring Engine

### Dynamic Subjects

Subjects are configured per exam cycle, not hardcoded. Each subject stores 3 values per applicant:

- **Standard Score** (from Excel upload or manual entry)
- **Stanine** (auto-calculated from score config)
- **Qualitative Interpretation** (auto-derived from stanine label)

### Score Configuration (Per Exam)

```
Stanine ranges (configurable):
  9: 750 – 800
  8: 650 – 749
  7: 550 – 649
  6: 450 – 549
  5: 400 – 449
  4: 350 – 399
  3: 300 – 349
  2: 250 – 299
  1: 200 – 249

Qualitative labels (configurable):
  9: Outstanding
  8: Above Average
  7: Above Average
  6: High Average
  5: Middle Average
  4: Low Average
  3: Below Average
  2: Below Average
  1: Low
```

### Result Upload Flow

```
Bulk Upload:
  1. Admin uploads Excel file
  2. System reads headers → maps to configured subjects
  3. Preview: record count, subject matches, errors
  4. Validation: attendance cross-check, duplicate detection
  5. Admin confirms → queued import job
  6. Stanine + interpretation auto-calculated

Individual Add:
  1. Search by examinee number or name
  2. Dynamic form (fields based on exam subjects)
  3. Enter scores → stanine auto-calculated
  4. Saved with audit trail (who, when, upload method)
```

---

## Program Qualification Logic

Program preference is a **wish list only** — NOT a gate.

```
After results are uploaded, system calculates:

For each applicant:
  For each offered program:
    if applicant.overall_score >= program_cutoff.cutoff_score:
      → QUALIFIED (with rank position in that program)

Result: applicant sees ALL programs they qualify for.
```

### Example

```
Maria scored 654 overall.

BS Nursing (ACCESS) — cutoff 400 → 654 >= 400 → ✅ Qualified, Rank #23
BS Biology (Tacurong) — cutoff 380 → 654 >= 380 → ✅ Qualified, Rank #8
BS Education (Kalamansig) — cutoff 300 → 654 >= 300 → ✅ Qualified, Rank #2
BS Engineering (Isulan) — cutoff 500 → 654 >= 500 → ✅ Qualified, Rank #45
...all 57 programs checked

Maria sees: "You qualify for 47 out of 57 programs."
```

### Cutoffs are Per Exam Cycle

```
BS Nursing cutoff:
  2026: 380
  2027: 400
  2028: 420

Stored in program_cutoffs table — separate from programs table.
Historical data preserved. Admin can copy last year's cutoffs as starting point.
```

---

## Attendance System

### QR-Based Scanning

```
Permit has QR code → Staff scans with phone browser → System records attendance.

Statuses:
  PRESENT — scanned on time
  LATE    — scanned after start time (with timestamp)
  ABSENT  — has seat assignment but no scan record (auto-generated)
```

### What Attendance Unlocks

| Feature | How |
|---------|-----|
| Valid results only | Cross-check: has attendance? Flag if not |
| Absent list | Auto-generated: paid + had slot + didn't show up |
| Capacity analytics | Actual turnout vs capacity per schedule |
| Late tracking | Admin knows who arrived late |
| Re-schedule eligibility | Absent with valid reason → can be reassigned |

---

## Survey System

### Dynamic Survey Per Exam Cycle

```
Admin creates survey template for the exam:
  ├── Question 1: "Rate the exam venue" (rating 1-5)
  ├── Question 2: "Was the proctor helpful?" (multiple choice: Yes/No)
  ├── Question 3: "Any problems during the exam?" (free text)
  └── Question 4: "Suggestions for improvement?" (free text)

Applicant completes survey after exam (before viewing results).
Admin sees aggregated feedback for planning next cycle.
```

---

## Notifications & Announcements

### In-App Notifications (Per User)

| Trigger | Message |
|---------|---------|
| Payment verified | "Payment confirmed! Pick your exam schedule now." |
| Schedule picked | "Permit ready. Download it." |
| Schedule cancelled | "Your exam schedule was cancelled. Please pick a new one." |
| Results published | "Your exam results are now available!" |

### Announcements (Broadcast to All)

Admin can post announcements visible to all applicants on their dashboard:
- "Application deadline extended to March 20"
- "Bring 2 valid IDs on exam day"
- "Results will be released on April 5"

---

## Reporting & Exports

| Report | Filters | Export |
|--------|---------|--------|
| Ranking per program | Campus, program | Excel |
| Qualified students | Campus, program, score range | Excel (queued for large sets) |
| Attendance | Schedule, campus, date | Excel |
| Payment | Campus, cashier, date range | Excel |
| Capacity vs turnout | Schedule, campus | Excel |
| Registration date | Date range, name | Excel |
| Score distribution | Subject, campus | Excel |
| Survey results | Question, campus | Excel |

All exports run as **queued Redis jobs** for large datasets (9,000+ records).

---

## AI Features (Future)

Using **Laravel AI SDK** (first-party, production-stable in Laravel 13):

| Feature | Description |
|---------|-------------|
| Smart result analysis | "Show students scoring high in Science but low in Math" |
| Applicant help bot | Answers FAQs about exam dates, requirements, status |
| Admin report assistant | "Compare this year vs last year" — AI generates summary |
| Upload validation | AI scans Excel for anomalies before import |
| Survey summarization | AI reads 9,000 responses → top complaints/praises |

Not required for v1. Foundation ready for incremental addition.

---

## Project Structure

```
tpt-v3/
├── app/
│   ├── Models/              (25 models)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/        (Login, Register, SocialAuth)
│   │   │   ├── Admin/       (15 controllers)
│   │   │   ├── Cashier/     (PaymentController)
│   │   │   ├── Staff/       (AttendanceController)
│   │   │   └── Applicant/   (7 controllers)
│   │   ├── Middleware/       (Spatie handles role/permission)
│   │   └── Requests/        (Form validation per domain)
│   ├── Services/            (Business logic layer)
│   ├── Imports/             (Excel imports)
│   ├── Exports/             (Excel exports)
│   ├── Jobs/                (Queued: imports, exports, PDFs)
│   ├── Notifications/       (Payment, schedule, results)
│   ├── Enums/               (ApplicationStatus, AttendanceStatus)
│   ├── Observers/           (Auto audit logging)
│   └── Policies/            (Authorization)
│
├── resources/js/
│   ├── Layouts/             (Admin, Applicant, Cashier, Staff)
│   ├── Pages/
│   │   ├── Auth/
│   │   ├── Admin/           (Dashboard, Exams, Schedules, Results, Reports, etc.)
│   │   ├── Applicant/       (Dashboard, Profile, Schedule, Permit, Result, Survey)
│   │   ├── Cashier/         (Payment)
│   │   └── Staff/           (Attendance)
│   └── Components/          (UI, Charts, Scanner)
│
├── routes/
│   ├── web.php              (clean — includes role-based route files)
│   ├── auth.php
│   ├── admin.php
│   ├── applicant.php
│   ├── cashier.php
│   ├── staff.php
│   └── api.php              (future mobile)
│
├── database/
│   ├── migrations/          (27 tables + Spatie)
│   └── seeders/             (Roles, Settings, Campuses, Programs)
│
└── config/                  (app, permission, media-library, ai)
```

### Architecture Pattern

```
Controller → validates input → calls Service → returns Inertia response
Service    → business logic → calls Models / Jobs
Model      → data layer → Eloquent
Observer   → auto audit logging on model events
Job        → heavy work (imports, exports, PDFs) → Redis queue
```

---

## Deployment

```
Server:     Digital Ocean Droplet
OS:         Ubuntu 22.04+
Web:        Nginx
PHP:        8.3+
Database:   MySQL 8
Cache:      Redis
Queue:      Redis (Laravel Horizon for monitoring)
SSL:        Let's Encrypt (Certbot)
Storage:    Local (DO Spaces for future scale)
CI/CD:      GitHub Actions (future)
```

---

## Key Design Decisions

### 1. State Machine Over Step Middleware
The old 5-step middleware was rigid — applicants couldn't go back, and adding a new step required new middleware + route changes. The new enum-based state machine allows flexible forward/backward transitions with clear rules.

### 2. Dynamic Subjects Over Hardcoded Columns
Old: `math_raw_score`, `english_raw_score` as database columns. New: `exam_subjects` + `subject_scores` tables. Add/remove subjects without code changes.

### 3. Cashier Role Over Receipt Upload
Old: applicant uploads receipt photo → admin manually reviews → days of waiting. New: cashier at any campus records payment in person → instant verification. Eliminates the biggest bottleneck.

### 4. Per-Exam Configuration Over Global Hardcoding
Cutoffs, stanine ranges, examinee number patterns, subjects — all configurable per exam cycle. Historical data preserved. No developer needed for yearly changes.

### 5. Services Layer Over Fat Controllers
Business logic lives in Service classes, not controllers or Livewire components. Controllers handle HTTP, Services handle rules, Models handle data.

### 6. Split Routes Over Single File
Routes organized by role: `admin.php`, `applicant.php`, `cashier.php`, `staff.php`. Clean, maintainable, easy to navigate vs one 492-line file.

### 7. Program Preference as Guide, Not Gate
Applicants see ALL programs they qualify for based on score, not just their preference. Fair system — qualification is score vs cutoff, not pre-selection.

### 8. Auto Seat Assignment Over Manual Room Management
Admin sets capacity + rooms → system auto-generates seats. Applicants are auto-assigned when they pick a schedule. No manual room/seat management by admin.

### 9. Audit Everything
Every admin action logged: who, what, when, old values, new values. Accountability built into the system from day one.

### 10. Concurrency-Safe Seat Selection
Database-level row locking (SELECT FOR UPDATE) prevents double-booking. Redis atomic counters for real-time availability display. Handles 500+ simultaneous seat selections.
