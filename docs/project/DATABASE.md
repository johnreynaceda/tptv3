# SKSU TPT v3 — Database Schema

> Complete database schema for the rebuilt examination management system.
> **Total: 27 application tables + 5 Spatie tables = 32 tables**

---

## Table of Contents

1. [Authentication & Roles](#1-authentication--roles)
2. [System Settings](#2-system-settings)
3. [Campus & Programs](#3-campus--programs)
4. [Examination](#4-examination)
5. [Exam Subjects](#5-exam-subjects)
6. [Score Configuration](#6-score-configuration)
7. [Program Cutoffs](#7-program-cutoffs)
8. [Applicant Profile](#8-applicant-profile)
9. [Application](#9-application)
10. [Program Preferences](#10-program-preferences)
11. [Payments](#11-payments)
12. [Exam Schedules](#12-exam-schedules)
13. [Seat Assignments](#13-seat-assignments)
14. [Permits](#14-permits)
15. [Attendance](#15-attendance)
16. [Exam Results](#16-exam-results)
17. [Subject Scores](#17-subject-scores)
18. [Program Qualifications](#18-program-qualifications)
19. [Application Documents](#19-application-documents)
20. [Notifications](#20-notifications)
21. [Announcements](#21-announcements)
22. [Audit Logs](#22-audit-logs)
23. [Survey System](#23-survey-system)
24. [Spatie Tables](#24-spatie-tables-auto-managed)
25. [Entity Relationship Diagram](#entity-relationship-diagram)

---

## 1. Authentication & Roles

### `users`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| email | varchar(255) | unique, not null | Login email |
| password | varchar(255) | not null | Hashed password |
| google_id | varchar(255) | nullable, unique | Google OAuth ID |
| avatar | varchar(255) | nullable | Profile photo URL (Google) |
| email_verified_at | timestamp | nullable | Email verification timestamp |
| remember_token | varchar(100) | nullable | Laravel remember me token |
| is_active | boolean | default true | Account active/disabled |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Real-world scenario:**
> Maria creates an account with email `maria@gmail.com`. She can also sign in with Google. Her account persists across exam cycles — if she re-applies next year, she logs in with the same account. If she graduates and gets hired as staff, the SuperAdmin assigns her a Staff role on the same account.

**Note:** Roles are managed by Spatie (see section 24). No `role_id` column on this table.

---

## 2. System Settings

### `settings`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| key | varchar(255) | unique, not null | Setting identifier |
| value | json | not null | Setting value (flexible) |
| group | varchar(50) | not null | Category: general, examination, scoring, permit |
| description | text | nullable | Human-readable explanation |
| updated_by | bigint | FK → users, nullable | Who last changed it |
| updated_at | timestamp | | |

**Example rows:**

| key | value | group |
|-----|-------|-------|
| `default_subjects` | `["English","Science","Mathematics","Filipino","Social Studies","ESM Competency Score"]` | examination |
| `stanine_labels` | `{"9":"Outstanding","8":"Above Average","7":"Above Average","6":"High Average","5":"Middle Average","4":"Low Average","3":"Below Average","2":"Below Average","1":"Low"}` | scoring |
| `exam_fee_amount` | `300` | general |

**Real-world scenario:**
> Last year, the default subjects didn't include "Critical Thinking." The testing department decides to add it this year. SuperAdmin goes to Settings → updates `default_subjects` → adds "Critical Thinking." When the next exam is created, it auto-pulls this new list. No code changes needed.

---

## 3. Campus & Programs

### `campuses`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| name | varchar(255) | not null | Full name (e.g., "ACCESS") |
| code | varchar(10) | unique, not null | Short code (e.g., "ACC") |
| address | text | nullable | Campus location |
| is_active | boolean | default true | Can be deactivated |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**SKSU Campuses:** ACCESS, Isulan, Tacurong, Lutayan, Palimbang, Kalamansig, Bagumbayan

---

### `programs`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| campus_id | bigint | FK → campuses, not null | Which campus offers this |
| name | varchar(255) | not null | Full name (e.g., "Bachelor of Science in Nursing") |
| abbreviation | varchar(20) | not null | Short form (e.g., "BSN") |
| is_offered | boolean | default true | Available this cycle? |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Note:** Cutoff scores are NOT on this table — they're per exam cycle in `program_cutoffs`.

**Real-world scenario:**
> ACCESS campus offers 12 programs including BS Nursing, BS Medical Technology, BS Criminology. Tacurong offers 9 programs. Lutayan only offers 2. If BS Criminology is paused this year due to no faculty, admin toggles `is_offered = false`. The program still exists for historical records but won't appear in the current exam cycle.

---

## 4. Examination

### `examinations`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| title | varchar(255) | not null | e.g., "SKSU TPT SY 2027-2028" |
| school_year | varchar(20) | not null | e.g., "2027-2028" |
| application_start_date | date | not null | When applications open |
| application_end_date | date | not null | When applications close |
| is_active | boolean | default false | Only ONE active at a time |
| examinee_number_start | integer | not null | Starting number (e.g., 600001) |
| results_published | boolean | default false | Controls result visibility |
| created_by | bigint | FK → users | Who created it |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Real-world scenario:**
> Admin creates "SKSU TPT SY 2027-2028" and activates it. The previous "SY 2026-2027" automatically deactivates. All new applications go to this exam. But the old exam data stays intact — admin can still pull 2026 reports, compare year-over-year. Examinee numbers start at 600001 (last year was 500001). The `results_published` flag controls when applicants can see their scores — admin uploads first, reviews, then publishes.

---

## 5. Exam Subjects

### `exam_subjects`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| examination_id | bigint | FK → examinations, not null | Which exam cycle |
| name | varchar(255) | not null | e.g., "English", "ESM Competency Score" |
| code | varchar(20) | not null | e.g., "ENG", "ESM" |
| order | integer | not null | Display order (1, 2, 3...) |
| is_composite | boolean | default false | ESM = composite of English+Science+Math |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Unique constraint:** `(examination_id, code)`

**Real-world scenario:**
> When admin creates the 2027 exam, system auto-pulls default subjects: English (1), Science (2), Mathematics (3), Filipino (4), Social Studies (5), ESM (6). Admin reviews — "Testing department added Critical Thinking this year." Admin adds it at order 7. Each exam cycle has its OWN subjects. The 2026 exam had 6 subjects, the 2027 exam has 7. No code change — the result upload form, the applicant result view, and the export all dynamically adapt.

---

## 6. Score Configuration

### `score_configs`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| examination_id | bigint | FK → examinations, not null | Which exam cycle |
| type | varchar(50) | not null | `stanine_range` or `qualitative_label` |
| reference_key | varchar(50) | not null | Stanine number (1-9) |
| reference_value | json | not null | Range or label value |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Unique constraint:** `(examination_id, type, reference_key)`

**Example rows (one exam cycle):**

| type | reference_key | reference_value |
|------|--------------|-----------------|
| `stanine_range` | `9` | `{"min": 750, "max": 800}` |
| `stanine_range` | `8` | `{"min": 650, "max": 749}` |
| `stanine_range` | `7` | `{"min": 550, "max": 649}` |
| `stanine_range` | `6` | `{"min": 450, "max": 549}` |
| `stanine_range` | `5` | `{"min": 400, "max": 449}` |
| `stanine_range` | `4` | `{"min": 350, "max": 399}` |
| `stanine_range` | `3` | `{"min": 300, "max": 349}` |
| `stanine_range` | `2` | `{"min": 250, "max": 299}` |
| `stanine_range` | `1` | `{"min": 200, "max": 249}` |
| `qualitative_label` | `9` | `"Outstanding"` |
| `qualitative_label` | `8` | `"Above Average"` |
| `qualitative_label` | `7` | `"Above Average"` |
| `qualitative_label` | `6` | `"High Average"` |
| `qualitative_label` | `5` | `"Middle Average"` |
| `qualitative_label` | `4` | `"Low Average"` |
| `qualitative_label` | `3` | `"Below Average"` |
| `qualitative_label` | `2` | `"Below Average"` |
| `qualitative_label` | `1` | `"Low"` |

**Real-world scenario:**
> This year the testing department says stanine 9 starts at 750. Last year it was 700. Admin configures per exam. If they ever want stanine 9 to mean "Excellent" instead of "Outstanding," they update the label. Old exams keep their original labels. No hardcoding.

---

## 7. Program Cutoffs

### `program_cutoffs`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| examination_id | bigint | FK → examinations, not null | Which exam cycle |
| program_id | bigint | FK → programs, not null | Which program |
| cutoff_score | integer | not null | Minimum passing score |
| notes | text | nullable | e.g., "Increased due to high demand" |
| set_by | bigint | FK → users | Who configured it |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Unique constraint:** `(examination_id, program_id)`

**Real-world scenario:**
> BS Nursing is competitive — cutoff was 380 in 2026, raised to 400 in 2027, might be 420 in 2028. Each year, admin sets cutoffs for all 57 programs. System can optionally copy last year's cutoffs as a starting point — admin just adjusts the ones that changed. Dean asks: "How has BS Nursing cutoff changed?" → query `program_cutoffs` by program → instant trend data across years.

---

## 8. Applicant Profile

### `profiles`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| user_id | bigint | FK → users, unique | One-to-one |
| first_name | varchar(255) | not null | |
| middle_name | varchar(255) | nullable | |
| last_name | varchar(255) | not null | |
| suffix | varchar(20) | nullable | Jr, III, etc. |
| birthdate | date | not null | |
| gender | varchar(20) | not null | |
| civil_status | varchar(20) | not null | |
| nationality | varchar(50) | default 'Filipino' | |
| phone | varchar(20) | not null | |
| address_street | varchar(255) | nullable | |
| address_barangay | varchar(255) | nullable | |
| address_city | varchar(255) | not null | |
| address_province | varchar(255) | not null | |
| address_zip | varchar(10) | nullable | |
| school_name | varchar(255) | not null | Senior high school |
| school_address | varchar(255) | nullable | |
| strand | varchar(100) | not null | STEM, ABM, HUMSS, etc. |
| year_graduated | integer | not null | |
| lrn | varchar(20) | nullable, unique | Learner Reference Number (duplicate detection) |
| applicant_type | varchar(20) | not null | freshmen, transferee |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Note:** Photo and ID documents are handled by Spatie Media Library (attached to Profile model), not as columns.

**Real-world scenario:**
> Old system: `personal_information` table + `school_information` table + some fields on `users`. Maria had to fill 3 forms and couldn't go back to edit. New system: one `profiles` table, one form, editable anytime before exam day. If Maria re-applies next year, her profile is already filled — just submit a new application. LRN field prevents duplicates: if someone tries to create a second account with the same LRN → "You already have an account."

---

## 9. Application

### `applications`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| user_id | bigint | FK → users, not null | |
| examination_id | bigint | FK → examinations, not null | |
| application_number | varchar(20) | unique, not null | Auto-generated: APP-2027-00001 |
| status | varchar(30) | not null, default 'draft' | State machine value |
| submitted_at | timestamp | nullable | When profile was completed |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Unique constraint:** `(user_id, examination_id)` — one application per person per exam cycle

**Status values (enum):**
`draft` | `submitted` | `payment_pending` | `payment_verified` | `scheduled` | `permit_issued` | `examined` | `resulted`

**Real-world scenario:**
> Maria applies for 2027 exam → application APP-2027-00001 created with status `draft`. She completes her profile → status becomes `submitted` → auto-transitions to `payment_pending`. Cashier records payment → `payment_verified`. She picks a schedule → `scheduled` → auto-generates permit → `permit_issued`. Exam day scan → `examined`. Results uploaded → `resulted`. Next year she applies again → new application APP-2028-04521 under the same user account.

---

## 10. Program Preferences

### `program_preferences`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| application_id | bigint | FK → applications, not null | |
| program_id | bigint | FK → programs, not null | |
| priority | integer | not null | 1 = first choice, 2 = second, 3 = third |
| created_at | timestamp | | |

**Real-world scenario:**
> Maria picks: 1st choice BS Nursing, 2nd choice BS Biology, 3rd choice BS Education. These are just preferences — for admin reference and applicant guidance. When results come out, Maria sees ALL programs she qualifies for (score >= cutoff), not just these three. If she scores 654 and BS Agriculture has a cutoff of 250, she qualifies for that too even though she never selected it.

---

## 11. Payments

### `payments`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| application_id | bigint | FK → applications, unique | One payment per application |
| amount | decimal(10,2) | not null | Amount paid |
| receipt_number | varchar(100) | not null | OR number from cashier |
| payment_method | varchar(30) | default 'cash' | cash, online (future) |
| campus_id | bigint | FK → campuses, not null | WHERE they paid |
| processed_by | bigint | FK → users, not null | Cashier who recorded it |
| paid_at | timestamp | not null | When payment was received |
| notes | text | nullable | Cashier notes |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Real-world scenario:**
> Maria lives near Isulan campus but the main office is at ACCESS. Old system: she had to travel to ACCESS, upload a blurry receipt photo, then wait 3 days for approval. New system: she walks into Isulan campus cashier, shows APP-2027-00001, pays PHP 300, Cashier Joy records it. Done in 2 minutes. Instantly verified. Admin sees: "Isulan cashier processed 245 payments. ACCESS processed 612." If Joy accidentally types 200 instead of 300, system warns: "Expected PHP 300, entered PHP 200. Proceed?" — flagged for admin review.

---

## 12. Exam Schedules

### `exam_schedules`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| examination_id | bigint | FK → examinations, not null | |
| campus_id | bigint | FK → campuses, not null | Venue |
| date | date | not null | Exam date |
| start_time | time | not null | e.g., 08:00 |
| end_time | time | not null | e.g., 12:00 |
| capacity | integer | not null | Total seats |
| num_rooms | integer | not null | Number of rooms |
| seats_per_room | integer | not null | Auto-calculated: capacity / num_rooms |
| is_active | boolean | default true | Can deactivate for emergencies |
| created_by | bigint | FK → users | |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Unique constraint:** `(examination_id, campus_id, date)`

**Validation rules:**
- `capacity % num_rooms == 0` (must divide evenly)
- Same date + same campus = not allowed (extend capacity instead)
- Same date + different campus = allowed

**Real-world scenario:**
> Admin creates 6 schedules: ACCESS on Mar 21, 22, 23 (1000, 1000, 500 seats). Isulan on Mar 23 (800 seats). Lutayan on Mar 23 (300 seats). Tacurong on Mar 24 (600 seats). System auto-generates seat rows for each. March 20 — 500 more applicants than expected. Admin extends Mar 22 ACCESS from 1000 to 1200 and adds 4 rooms. System generates 200 new seats. Existing 1000 untouched. March 21 — typhoon. Admin deactivates that schedule. 847 affected students get notified to re-pick. Admin creates Mar 25 ACCESS as replacement.

---

## 13. Seat Assignments

### `seat_assignments`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| exam_schedule_id | bigint | FK → exam_schedules, not null | |
| application_id | bigint | FK → applications, nullable | null = empty seat |
| room_number | integer | not null | 1, 2, 3... |
| seat_number | integer | not null | 1, 2, 3... per room |
| assigned_at | timestamp | nullable | When applicant was assigned |
| created_at | timestamp | | |

**Unique constraints:**
- `(exam_schedule_id, room_number, seat_number)` — no duplicate seats
- `(application_id)` where not null — one seat per applicant

**Real-world scenario:**
> Admin creates: Mar 21 ACCESS, 1000 capacity, 20 rooms. System auto-generates 1000 rows: Room 1 Seat 1-50, Room 2 Seat 1-50... Room 20 Seat 1-50. All with `application_id = NULL`. Maria picks Mar 21 ACCESS → system runs: `BEGIN TRANSACTION → SELECT first seat WHERE application_id IS NULL FOR UPDATE → UPDATE set application_id = Maria → COMMIT`. She gets Room 1, Seat 1. Next person gets Room 1, Seat 2. If 500 people select at the same time, the row lock prevents double-booking.

---

## 14. Permits

### `permits`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| application_id | bigint | FK → applications, unique | One-to-one |
| exam_schedule_id | bigint | FK → exam_schedules, not null | |
| examinee_number | varchar(20) | unique, not null | e.g., "600001" |
| qr_code_data | text | not null | Encoded data for QR scanning |
| room_number | integer | not null | Copied from seat assignment |
| seat_number | integer | not null | Copied from seat assignment |
| issued_at | timestamp | not null | |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Real-world scenario:**
> Maria picks her schedule → system assigns seat → permit auto-generates. Examinee #600001. QR encodes: `{"permit_id":1,"examinee":"600001","exam_id":3}`. She downloads the PDF showing: name, photo, examinee number, QR code, Mar 21 ACCESS, Room 1 Seat 1. Prints it. Brings it on exam day. Staff scans the QR → verified.

---

## 15. Attendance

### `attendances`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| application_id | bigint | FK → applications, not null | |
| exam_schedule_id | bigint | FK → exam_schedules, not null | |
| permit_id | bigint | FK → permits, not null | |
| status | varchar(20) | not null | present, late, absent |
| scanned_at | timestamp | nullable | When QR was scanned |
| scanned_by | bigint | FK → users, nullable | Staff who scanned |
| notes | text | nullable | e.g., "Arrived 30 min late" |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Unique constraint:** `(application_id, exam_schedule_id)`

**Real-world scenario:**
> Exam day. Staff Rico opens scan page on his phone. Maria shows permit → scan → "PRESENT, Maria Santos, Room 1 Seat 1, 7:45 AM." Juan arrives at 8:30 → "LATE, Juan Dela Cruz, Room 3 Seat 12, 8:30 AM, notes: 30 min late." By 9 AM, admin checks: 923 present, 12 late, 65 absent. The absent list is auto-generated: anyone with a seat assignment but no attendance record. When results are uploaded, system cross-checks: "3 results found for students with no attendance record" → flagged for review.

---

## 16. Exam Results

### `exam_results`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| application_id | bigint | FK → applications, unique | One-to-one |
| examination_id | bigint | FK → examinations, not null | |
| overall_standard_score | integer | not null | Total score |
| overall_stanine | integer | not null | Auto-calculated |
| overall_interpretation | varchar(50) | not null | Auto-derived from stanine label |
| is_qualified | boolean | not null | overall_score >= lowest program cutoff |
| uploaded_via | varchar(20) | not null | `bulk_import` or `individual_entry` |
| uploaded_by | bigint | FK → users, not null | Who uploaded/entered |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Real-world scenario:**
> Admin uploads Excel with 8,937 results → each row creates one `exam_results` record + multiple `subject_scores` rows. System auto-calculates `overall_stanine` from score config (654 falls in range 650-749 = stanine 8) and `overall_interpretation` ("Above Average"). Pedro took the emergency exam on Mar 25 → admin adds his result individually → `uploaded_via = individual_entry`, `uploaded_by = Ms. Cruz`. Both bulk and individual tracked.

---

## 17. Subject Scores

### `subject_scores`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| exam_result_id | bigint | FK → exam_results, not null | |
| exam_subject_id | bigint | FK → exam_subjects, not null | Dynamic subject reference |
| raw_score | integer | nullable | If provided in upload |
| standard_score | integer | not null | Main score value |
| stanine | integer | not null | Auto-calculated from score config |
| qualitative_interpretation | varchar(50) | not null | Auto-derived from stanine label |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Unique constraint:** `(exam_result_id, exam_subject_id)`

**Real-world scenario:**
> Old system: `math_raw_score`, `math_standard_score`, `english_raw_score`... hardcoded columns. If a new subject appeared, developer had to add migration + code. New system: one row per subject per applicant. Maria has 7 rows (English, Science, Math, Filipino, Social Studies, ESM, Overall). Next year if "Critical Thinking" is added → 8 rows. No code change. Excel upload maps: column "English — Standard Score" → matches `exam_subjects` where name = "English" → creates `subject_scores` row with `standard_score = 654`. System looks up score config → 654 in stanine 8 range → stanine = 8, interpretation = "Above Average."

---

## 18. Program Qualifications

### `program_qualifications`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| application_id | bigint | FK → applications, not null | |
| program_id | bigint | FK → programs, not null | |
| is_qualified | boolean | not null | Score >= cutoff? |
| applicant_score | integer | not null | Applicant's overall score |
| cutoff_score | integer | not null | Snapshot of cutoff at calculation time |
| rank_in_program | integer | nullable | Rank among qualified applicants |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Unique constraint:** `(application_id, program_id)`

**Real-world scenario:**
> Results uploaded. System runs qualification job (queued): for Maria (score 654), check all 57 offered programs. BS Nursing cutoff 400 → 654 >= 400 → qualified, ranked #23 among BS Nursing qualifiers. BS Education cutoff 300 → 654 >= 300 → qualified, ranked #2. System creates 57 rows for Maria (one per program). `cutoff_score` is a snapshot — if admin adjusts the cutoff later, this record remembers what cutoff was used. Maria logs in → sees "You qualify for 47 programs" with her rank in each.

---

## 19. Application Documents

### `application_documents`

Handled by **Spatie Media Library** — files are attached to the `Application` or `Profile` model using Spatie's polymorphic media system.

**Collections:**

| Collection | Required | Purpose |
|-----------|----------|---------|
| `photo` | Yes | 2x2 photo for permit |
| `valid_id` | Yes | Identity verification |

**Real-world scenario:**
> Maria uploads her 2x2 photo and a scan of her school ID. Spatie Media Library handles storage, thumbnails, and retrieval. The photo is used on the permit PDF. The ID is for admin verification if needed. No separate table needed — Spatie manages the `media` table automatically.

**Spatie creates:**

### `media` (Spatie Media Library — auto-managed)

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | PK |
| model_type | varchar | e.g., "App\Models\Profile" |
| model_id | bigint | FK to the parent model |
| collection_name | varchar | "photo", "valid_id" |
| name | varchar | Original filename |
| file_name | varchar | Stored filename |
| mime_type | varchar | e.g., "image/jpeg" |
| disk | varchar | Storage disk |
| size | bigint | File size in bytes |
| manipulations | json | Image manipulations |
| custom_properties | json | Extra metadata |
| responsive_images | json | Responsive variants |
| order_column | integer | Sort order |
| created_at | timestamp | |
| updated_at | timestamp | |

---

## 20. Notifications

### `notifications`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | uuid | PK | Laravel notification ID |
| type | varchar(255) | not null | Notification class name |
| notifiable_type | varchar(255) | not null | "App\Models\User" |
| notifiable_id | bigint | not null | User ID |
| data | json | not null | Notification payload |
| read_at | timestamp | nullable | When user read it |
| created_at | timestamp | | |

**Note:** This is Laravel's built-in `notifications` table (database channel).

**Notification types:**

| Type | Trigger | Message |
|------|---------|---------|
| PaymentVerified | Cashier records payment | "Payment confirmed! Pick your exam schedule." |
| SchedulePicked | Applicant picks schedule | "Permit ready. Download it." |
| ScheduleCancelled | Admin deactivates schedule | "Your schedule was cancelled. Please pick a new one." |
| ResultsPublished | Admin publishes results | "Your exam results are now available!" |

---

## 21. Announcements

### `announcements`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| examination_id | bigint | FK → examinations, not null | Scoped to exam cycle |
| title | varchar(255) | not null | |
| content | text | not null | Rich text content |
| is_published | boolean | default false | Draft vs published |
| published_by | bigint | FK → users, nullable | |
| published_at | timestamp | nullable | |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Real-world scenario:**
> Admin posts: "Application deadline extended to March 20." All applicants see it on their dashboard. Another announcement: "Bring 2 valid IDs on exam day." Scoped to the current exam cycle — next year's applicants won't see these.

---

## 22. Audit Logs

### `audit_logs`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| user_id | bigint | FK → users, nullable | Who did it (null = system) |
| action | varchar(50) | not null | created, updated, deleted, approved, rejected, uploaded, scanned |
| model_type | varchar(255) | not null | e.g., "App\Models\Payment" |
| model_id | bigint | not null | Record ID |
| old_values | json | nullable | Before the change |
| new_values | json | nullable | After the change |
| ip_address | varchar(45) | nullable | |
| user_agent | text | nullable | |
| created_at | timestamp | | |

**Real-world scenario:**
> "Who approved this fraudulent payment?" → Audit log: user_id=45 (Cashier Joy), action=created, model=Payment #4521, new_values={"amount":300,"receipt":"OR-2027-4521"}, ip=192.168.1.45, at 2:34 PM. "When was this result changed?" → action=updated, model=ExamResult #8937, old_values={"score":350}, new_values={"score":380}, user=Ms. Cruz, at 4:12 PM. Full accountability.

---

## 23. Survey System

### `survey_templates`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| examination_id | bigint | FK → examinations, not null | Per exam cycle |
| title | varchar(255) | not null | e.g., "Post-Exam Feedback SY 2027" |
| is_active | boolean | default true | |
| created_at | timestamp | | |
| updated_at | timestamp | | |

### `survey_questions`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| survey_template_id | bigint | FK → survey_templates, not null | |
| question | text | not null | e.g., "Rate the exam venue" |
| type | varchar(20) | not null | rating, multiple_choice, text |
| options | json | nullable | e.g., ["Excellent","Good","Fair","Poor"] |
| order | integer | not null | Display order |
| is_required | boolean | default true | |
| created_at | timestamp | | |

### `survey_responses`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| survey_template_id | bigint | FK → survey_templates, not null | |
| application_id | bigint | FK → applications, not null | |
| submitted_at | timestamp | not null | |
| created_at | timestamp | | |

**Unique constraint:** `(survey_template_id, application_id)` — one response per applicant per survey

### `survey_answers`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PK, auto-increment | |
| survey_response_id | bigint | FK → survey_responses, not null | |
| survey_question_id | bigint | FK → survey_questions, not null | |
| answer | text | not null | The response value |
| created_at | timestamp | | |

**Real-world scenario:**
> Admin creates survey for the 2027 exam with 4 questions: "Rate the venue (1-5)", "Was the proctor helpful? (Yes/No)", "Any problems? (text)", "Suggestions? (text)". After the exam, applicants complete the survey before viewing results. 9,000 responses come in. Admin sees aggregated data: "85% rated venue as Good/Excellent. Top complaint: crowded rooms at ACCESS campus, Room 15-20." This data helps plan next year: more rooms, better spacing. Future: Laravel AI SDK summarizes 9,000 free-text responses automatically.

---

## 24. Spatie Tables (Auto-Managed)

These tables are created automatically by Spatie packages. Listed for completeness.

### Spatie Permission (5 tables)

| Table | Purpose |
|-------|---------|
| `roles` | Role definitions (super-admin, admin, staff, cashier, applicant) |
| `permissions` | Permission definitions (applications.view, payments.create, etc.) |
| `role_has_permissions` | Which permissions each role has |
| `model_has_roles` | Which roles each user has |
| `model_has_permissions` | Direct permissions on users (bypass role) |

### Spatie Media Library (1 table)

| Table | Purpose |
|-------|---------|
| `media` | All uploaded files (photos, IDs, exports) — polymorphic |

---

## Entity Relationship Diagram

```
settings

users ──┬── profiles (1:1)
        │     └── [media] (photo, valid_id via Spatie)
        ├── [model_has_roles] → roles (Spatie)
        └── applications (1:many — one per exam cycle)
               │
               ├── program_preferences (1:many — 1st, 2nd, 3rd choice)
               ├── payments (1:1)
               ├── seat_assignments (1:1)
               ├── permits (1:1)
               ├── attendances (1:1)
               ├── exam_results (1:1)
               │      └── subject_scores (1:many — one per subject)
               ├── program_qualifications (1:many — one per program)
               ├── survey_responses (1:1 per survey)
               │      └── survey_answers (1:many — one per question)
               └── [notifications] (1:many)

examinations ──┬── exam_subjects (1:many — dynamic per cycle)
               ├── score_configs (1:many — stanine ranges + labels)
               ├── program_cutoffs (1:many — per program per cycle)
               ├── exam_schedules (1:many — date + campus combos)
               │      └── seat_assignments (1:many — auto-generated)
               ├── applications (1:many)
               ├── announcements (1:many)
               └── survey_templates (1:many)
                      └── survey_questions (1:many)

campuses ──┬── programs (1:many)
           └── exam_schedules (1:many)

audit_logs (polymorphic — tracks all models)
```

---

## Table Summary

| # | Table | Records Per Exam (est.) | Purpose |
|---|-------|------------------------|---------|
| 1 | users | ~10,000 | All user accounts |
| 2 | profiles | ~9,000 | Applicant personal + school info |
| 3 | settings | ~10 | Global configuration |
| 4 | campuses | 7 | SKSU campuses |
| 5 | programs | 57 | Academic programs |
| 6 | examinations | 1 active | Exam cycle |
| 7 | exam_subjects | 6-8 | Subjects per exam |
| 8 | score_configs | 18 | 9 ranges + 9 labels |
| 9 | program_cutoffs | 57 | Cutoff per program |
| 10 | applications | ~9,000 | One per applicant per exam |
| 11 | program_preferences | ~27,000 | 3 choices per applicant |
| 12 | payments | ~9,000 | One per application |
| 13 | exam_schedules | 6-10 | Date + campus combos |
| 14 | seat_assignments | ~5,000 | Auto-generated seats |
| 15 | permits | ~9,000 | One per approved applicant |
| 16 | attendances | ~9,000 | Exam day scans |
| 17 | exam_results | ~9,000 | Overall result per applicant |
| 18 | subject_scores | ~63,000 | 7 subjects x 9,000 applicants |
| 19 | program_qualifications | ~513,000 | 57 programs x 9,000 applicants |
| 20 | notifications | ~36,000 | ~4 per applicant |
| 21 | announcements | ~5-10 | Admin broadcasts |
| 22 | audit_logs | ~50,000+ | Every admin action |
| 23 | survey_templates | 1 | Per exam cycle |
| 24 | survey_questions | 4-8 | Per survey |
| 25 | survey_responses | ~9,000 | One per applicant |
| 26 | survey_answers | ~36,000 | ~4 answers per applicant |
| 27 | media | ~18,000 | Photo + ID per applicant |
| + | Spatie (5 tables) | ~100 | Roles + permissions |
