# User Flow & Process Documentation

## High-Level System Overview

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                           TPT EXAMINATION SYSTEM FLOW                            │
└─────────────────────────────────────────────────────────────────────────────────┘

                              ┌──────────────────┐
                              │   REGISTRATION   │
                              │  (Google OAuth)  │
                              └────────┬─────────┘
                                       │
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────────┐
│  STEP 1: GET STARTED                                                             │
│  User clicks "Get Started" → Moves to Step 2                                     │
│  user.step = '1' → user.step = '2'                                               │
└────────────────────────────────────────┬────────────────────────────────────────┘
                                         │
                                         ▼
┌─────────────────────────────────────────────────────────────────────────────────┐
│  STEP 2: FILL APPLICATION (3 Forms)                                              │
│  ├── Personal Information (name, address, photo, etc.)                           │
│  ├── School Information (previous school, GWA, strand)                           │
│  └── Program Choices (select 1st, 2nd, 3rd choice programs)                      │
│                                                                                   │
│  On Submit Application → Creates Application record → user.step = '3'            │
└────────────────────────────────────────┬────────────────────────────────────────┘
                                         │
                                         ▼
┌─────────────────────────────────────────────────────────────────────────────────┐
│  STEP 3: PAYMENT SUBMISSION                                                      │
│  ├── Enter payment reference number                                              │
│  └── Upload proof of payment (receipt images/PDF)                                │
│                                                                                   │
│  On Submit → Creates Payment + Proof records → user.step = '4'                   │
└────────────────────────────────────────┬────────────────────────────────────────┘
                                         │
                                         ▼
┌─────────────────────────────────────────────────────────────────────────────────┐
│  STEP 4: WAITING FOR APPROVAL                                                    │
│  ├── Admin reviews payment proof                                                 │
│  │                                                                               │
│  ├── IF APPROVED:                                                                │
│  │   ├── Generate Permit with examinee_number                                    │
│  │   ├── Send approval email                                                     │
│  │   └── user.step = '5'                                                         │
│  │                                                                               │
│  └── IF REJECTED:                                                                │
│      ├── Set user.is_declined = true                                             │
│      ├── Set user.remarks = "reason for rejection"                               │
│      ├── Send rejection email                                                    │
│      └── User can resubmit payment                                               │
└────────────────────────────────────────┬────────────────────────────────────────┘
                                         │
                                         ▼
┌─────────────────────────────────────────────────────────────────────────────────┐
│  STEP 5: APPROVED - PERMIT AVAILABLE                                             │
│  ├── View/Download Permit (PDF with QR code)                                     │
│  ├── Select Test Center (choose exam location & time slot)                       │
│  │   └── Creates StudentSlot record with room & seat numbers                     │
│  └── Proceed to take examination at scheduled date/time                          │
└────────────────────────────────────────┬────────────────────────────────────────┘
                                         │
                                         ▼
┌─────────────────────────────────────────────────────────────────────────────────┐
│  POST-EXAMINATION                                                                │
│  ├── Admin uploads examination results (Excel import)                            │
│  ├── Admin enables show_results on examination                                   │
│  │                                                                               │
│  └── IF RESULTS AVAILABLE:                                                       │
│      ├── Complete Survey (required before viewing results)                       │
│      ├── Select Preferred Courses                                                │
│      └── View/Download Result (PDF with scores & stanine interpretation)         │
└─────────────────────────────────────────────────────────────────────────────────┘
```

---

## Detailed Step-by-Step Flow

### Phase 1: Registration & Authentication

```
┌─────────────┐     ┌──────────────────┐     ┌────────────────┐
│   Student   │────▶│   Login Page     │────▶│  Google OAuth  │
│   Accesses  │     │   (Login/Signup) │     │   Redirect     │
│   System    │     └──────────────────┘     └───────┬────────┘
└─────────────┘                                      │
                                                     ▼
                    ┌──────────────────┐     ┌────────────────┐
                    │   User Created   │◀────│   Google       │
                    │   step='1'       │     │   Callback     │
                    │   role_id=2      │     └────────────────┘
                    └────────┬─────────┘
                             │
                             ▼
                    ┌──────────────────┐
                    │  Redirect to     │
                    │  Applicant Home  │
                    └──────────────────┘
```

**Authentication Routes:**
- `GET /auth/google` - Initiates Google OAuth
- `GET /auth/google/callback` - Handles OAuth callback
- `POST /login` - Standard email/password login
- `POST /register` - Standard registration

---

### Phase 2: Application Process (Step 1 → 2)

```
┌─────────────────────────────────────────────────────────────────┐
│                      APPLICANT HOME (Step 1)                     │
│                                                                  │
│   [User sees "Get Started" button if step='1']                   │
│                                                                  │
│   Click "Get Started" → Livewire: GetStartedButton.php           │
│   └── Checks if active examination exists                        │
│   └── Checks if slots are available                              │
│   └── Updates user.step = '2'                                    │
│   └── Creates Application record linked to active examination    │
│   └── Redirects to /applicant/fill/application                   │
└─────────────────────────────────────────────────────────────────┘
```

---

### Phase 3: Fill Application (Step 2)

```
┌─────────────────────────────────────────────────────────────────┐
│                  FILL APPLICATION PAGE                           │
│                  Route: /applicant/fill/application              │
│                  Middleware: step_two                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ FORM 1: PERSONAL INFORMATION                                │ │
│  │ Livewire Component: Applicant/PersonalInfo.php              │ │
│  │                                                             │ │
│  │ Fields:                                                     │ │
│  │ ├── Applicant Type (Freshmen/Transferee)                    │ │
│  │ ├── First Name, Middle Name, Last Name, Extension           │ │
│  │ ├── Present Address, Permanent Address                      │ │
│  │ ├── Phone Number                                            │ │
│  │ ├── Date of Birth, Place of Birth, Age                      │ │
│  │ ├── Sex                                                     │ │
│  │ ├── Tribe, Religion, Nationality, Citizenship               │ │
│  │ └── Photo Upload (2x2 ID photo)                             │ │
│  │                                                             │ │
│  │ On Save → Creates PersonalInformation record                │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ FORM 2: SCHOOL INFORMATION                                  │ │
│  │ Livewire Component: Applicant/SchoolInfo.php                │ │
│  │                                                             │ │
│  │ Fields:                                                     │ │
│  │ ├── School Name                                             │ │
│  │ ├── School Address                                          │ │
│  │ ├── Level (Senior High, ALS, etc.)                          │ │
│  │ ├── GWA (General Weighted Average)                          │ │
│  │ ├── Strand (for SHS: STEM, ABM, HUMSS, etc.)                │ │
│  │ ├── School Type (Public/Private)                            │ │
│  │ └── Year Graduated                                          │ │
│  │                                                             │ │
│  │ On Save → Creates SchoolInformation record                  │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ FORM 3: PROGRAM CHOICES                                     │ │
│  │ Livewire Component: Applicant/ProgramInfo.php               │ │
│  │                                                             │ │
│  │ Select 3 Programs in order of preference:                   │ │
│  │ ├── 1st Choice Program (required)                           │ │
│  │ ├── 2nd Choice Program (required)                           │ │
│  │ └── 3rd Choice Program (required)                           │ │
│  │                                                             │ │
│  │ Programs are grouped by Campus                              │ │
│  │                                                             │ │
│  │ On Save → Creates 3 ProgramChoice records                   │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ SUBMIT APPLICATION BUTTON                                   │ │
│  │ Livewire Component: Applicant/ButtonSubmitApplication.php   │ │
│  │                                                             │ │
│  │ Validates:                                                  │ │
│  │ ├── Personal Information exists                             │ │
│  │ ├── School Information exists                               │ │
│  │ └── Program Choices exist (3 choices)                       │ │
│  │                                                             │ │
│  │ On Submit:                                                  │ │
│  │ ├── Updates application.submitted_at = now()                │ │
│  │ ├── Updates user.step = '3'                                 │ │
│  │ └── Redirects to /applicant/payment                         │ │
│  └─────────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────┘
```

---

### Phase 4: Payment Submission (Step 3)

```
┌─────────────────────────────────────────────────────────────────┐
│                      PAYMENT PAGE                                │
│                      Route: /applicant/payment                   │
│                      Middleware: step_three                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Livewire Component: Applicant/PaymentSection.php                │
│                                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ PAYMENT FORM                                                │ │
│  │                                                             │ │
│  │ Fields:                                                     │ │
│  │ ├── Reference Number (unique, from payment receipt)         │ │
│  │ └── Proof of Payment (multiple file upload: JPG/PNG/PDF)    │ │
│  │                                                             │ │
│  │ Validations:                                                │ │
│  │ ├── Reference number must be unique                         │ │
│  │ ├── At least one proof document required                    │ │
│  │ └── Allowed file types: jpeg, png, pdf, jpg                 │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                  │
│  On Submit:                                                      │
│  ├── Creates Payment record (user_id, examination_id, reference) │
│  ├── Creates Proof record(s) for each uploaded file              │
│  ├── Files stored in storage/app/public/proofs/                  │
│  ├── Updates user.step = '4'                                     │
│  └── Redirects to Applicant Home (waiting status)                │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

### Phase 5: Admin Review & Approval (Step 4)

```
┌─────────────────────────────────────────────────────────────────┐
│                    ADMIN PAYMENT REVIEW                          │
│                    Route: /admin/manage-examination/{id}/        │
│                           applications                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Admin sees list of applications with payment status             │
│                                                                  │
│  For each application, admin can:                                │
│  ├── View applicant details                                      │
│  ├── View payment reference number                               │
│  ├── View/download proof documents                               │
│  │                                                               │
│  └── Take Action:                                                │
│      ├── APPROVE                                                 │
│      │   ├── Generate Permit with unique examinee_number         │
│      │   ├── Update user.step = '5'                              │
│      │   ├── Send approval email                                 │
│      │   └── Applicant can now view permit                       │
│      │                                                           │
│      └── REJECT                                                  │
│          ├── Enter rejection remarks/reason                      │
│          ├── Update user.is_declined = true                      │
│          ├── Update user.remarks = "rejection reason"            │
│          ├── Send rejection email                                │
│          └── Applicant can resubmit payment                      │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

**Examinee Number Generation:**
The examinee number is auto-generated when admin approves payment. Format may vary based on examination year and sequence.

---

### Phase 6: Permit & Slot Selection (Step 5)

```
┌─────────────────────────────────────────────────────────────────┐
│                    APPLICANT HOME (Step 5)                       │
│                    Payment Approved                              │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ VIEW/DOWNLOAD PERMIT                                        │ │
│  │ Route: /applicant/permit                                    │ │
│  │                                                             │ │
│  │ Permit Contains:                                            │ │
│  │ ├── Examinee Number                                         │ │
│  │ ├── Full Name                                               │ │
│  │ ├── Photo                                                   │ │
│  │ ├── Examination Name                                        │ │
│  │ ├── Exam Date, Time, Room, Seat (if slot selected)          │ │
│  │ ├── QR Code (encoded permit data)                           │ │
│  │ └── Program Choices                                         │ │
│  │                                                             │ │
│  │ Actions:                                                    │ │
│  │ ├── View Online                                             │ │
│  │ └── Download PDF (Browsershot generates PDF)                │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ SELECT TEST CENTER (If not yet selected)                    │ │
│  │ Route: /applicant/select-test-center                        │ │
│  │ Livewire: Applicant/SelectTestingCenter.php                 │ │
│  │                                                             │ │
│  │ Process:                                                    │ │
│  │ ├── View available test centers                             │ │
│  │ ├── View available slots per center                         │ │
│  │ ├── Select preferred slot (date/time/room)                  │ │
│  │ │                                                           │ │
│  │ └── On Select:                                              │ │
│  │     ├── Creates StudentSlot record                          │ │
│  │     ├── Assigns room_number and seat_number                 │ │
│  │     ├── Links to application.student_slot_id                │ │
│  │     └── Slot occupancy count increases                      │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

### Phase 7: Examination & Results

```
┌─────────────────────────────────────────────────────────────────┐
│                   EXAMINATION PROCESS                            │
│                   (Offline - Physical Exam)                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Student:                                                        │
│  ├── Prints or shows digital permit                             │
│  ├── Arrives at assigned test center                            │
│  ├── Goes to assigned room and seat                             │
│  └── Takes the TPT examination                                  │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘

                              ▼

┌─────────────────────────────────────────────────────────────────┐
│                   ADMIN: UPLOAD RESULTS                          │
│                   Route: /admin/examination-results/{exam}       │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Admin Process:                                                  │
│  ├── Prepare Excel file with results                            │
│  │   (examinee_number, scores for each subject)                 │
│  ├── Upload Excel file                                          │
│  │   Uses: ExaminationResultImport.php                          │
│  ├── System imports results to results table                    │
│  │                                                               │
│  └── Enable Results Visibility:                                  │
│      └── Set examination.show_results = true                     │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘

                              ▼

┌─────────────────────────────────────────────────────────────────┐
│                   APPLICANT: VIEW RESULTS                        │
│                   (When show_results is enabled)                 │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ STEP 1: COMPLETE SURVEY (Required)                          │ │
│  │ Route: /applicant/survey                                    │ │
│  │ Livewire: Applicant/Survey.php                              │ │
│  │                                                             │ │
│  │ Creates SurveyResult record on completion                   │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ STEP 2: SELECT COURSES                                      │ │
│  │ Route: /applicant/select-course                             │ │
│  │ Livewire: Applicant/SelectCourses.php                       │ │
│  │                                                             │ │
│  │ Creates SelectedCourse record(s)                            │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                  │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │ STEP 3: VIEW RESULT                                         │ │
│  │ Route: /applicant/result                                    │ │
│  │ Middleware: survey.result                                   │ │
│  │                                                             │ │
│  │ Result Shows:                                               │ │
│  │ ├── Subject-wise Raw Scores                                 │ │
│  │ ├── Subject-wise Standard Scores (Stanine 1-9)              │ │
│  │ ├── Stanine Interpretation (Outstanding to Low)             │ │
│  │ ├── Total Scores                                            │ │
│  │ └── PDF Download Option                                     │ │
│  └─────────────────────────────────────────────────────────────┘ │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## Status Flow Summary

### User Step Progression

```
┌─────────┐    ┌─────────┐    ┌─────────┐    ┌─────────┐    ┌─────────┐
│ Step 1  │───▶│ Step 2  │───▶│ Step 3  │───▶│ Step 4  │───▶│ Step 5  │
│         │    │         │    │         │    │         │    │         │
│ Initial │    │  Fill   │    │ Payment │    │ Waiting │    │Approved │
│ State   │    │  Forms  │    │ Submit  │    │ Approval│    │ Permit  │
└─────────┘    └─────────┘    └─────────┘    └─────────┘    └─────────┘
    │              │              │              │              │
    │              │              │              │              ▼
    │              │              │              │         ┌─────────┐
    │              │              │              │         │ Select  │
    │              │              │              │         │  Slot   │
    │              │              │              │         └────┬────┘
    │              │              │              │              │
    │              │              │              │              ▼
    │              │              │              │         ┌─────────┐
    │              │              │              │         │  Take   │
    │              │              │              │         │  Exam   │
    │              │              │              │         └────┬────┘
    │              │              │              │              │
    │              │              │              │              ▼
    │              │              │              │         ┌─────────┐
    │              │              │              │         │ Survey  │
    │              │              │              │         │& Course │
    │              │              │              │         └────┬────┘
    │              │              │              │              │
    │              │              │              │              ▼
    │              │              │              │         ┌─────────┐
    │              │              │              │         │  View   │
    │              │              │              │         │ Result  │
    │              │              │              │         └─────────┘
    │              │              │              │
    │              │              │         ┌────┴────┐
    │              │              │         │REJECTED │
    │              │              │         └────┬────┘
    │              │              │              │
    │              │              │◀─────────────┘
    │              │              │ (Resubmit Payment)
    │              │              │
```

### Middleware Protection

| Step | Middleware | Route Pattern | Description |
|------|------------|---------------|-------------|
| 2 | step_two | /applicant/fill/application | Only accessible when step='2' |
| 3 | step_three | /applicant/payment | Only accessible when step='3' |
| 5 | step_five | /applicant/permit | Only accessible when step='5' |
| - | survey.result | /applicant/result | Requires survey completion |

---

## Real-World Scenario Examples

### Scenario 1: Complete Happy Path

1. **Juan registers** via Google OAuth → `user.step = '1'`
2. **Juan clicks "Get Started"** → Application created → `user.step = '2'`
3. **Juan fills 3 forms**:
   - Personal Information (saves)
   - School Information (saves)
   - Program Choices (saves)
4. **Juan clicks "Submit Application"** → `user.step = '3'`
5. **Juan goes to payment page**, enters reference #12345, uploads receipt photo
6. **Payment submitted** → `user.step = '4'`
7. **Admin reviews** and approves payment → Permit #200001 generated → `user.step = '5'`
8. **Juan downloads permit**, selects Tagbilaran Campus, Room 101, Seat 5
9. **Exam day**: Juan takes exam
10. **Admin uploads results** for examination
11. **Juan completes survey**, selects courses, **views result** (Score: 85, Stanine: 7 - Above Average)

### Scenario 2: Payment Rejection

1. **Maria** completes steps 1-3, submits payment with reference #99999
2. **Admin sees** proof is blurry/invalid
3. **Admin rejects** with remarks: "Receipt image is not readable. Please resubmit."
4. **Maria receives** rejection email
5. **Maria** goes back to payment page, submits clearer photo
6. **Admin approves** on second review
7. **Maria continues** with permit and exam

### Scenario 3: Late Slot Selection

1. **Pedro** gets approved but doesn't select slot immediately
2. **All slots fill up** at preferred test center
3. **Pedro sees** "No Available Slots" warning
4. **Admin activates more slots** at another test center
5. **Pedro can now** select from newly available slots

---

## Database State at Each Step

| Step | Tables Affected | Records Created/Updated |
|------|-----------------|------------------------|
| 1→2 | users, applications | user.step='2', application created |
| 2 | personal_information, school_information, program_choices | 3 new records |
| 2→3 | users, applications | user.step='3', application.submitted_at set |
| 3→4 | users, payments, proofs | user.step='4', payment + proof(s) created |
| 4→5 (Approve) | users, permits | user.step='5', permit created |
| 4 (Reject) | users | user.is_declined=true, user.remarks set |
| 5 | student_slots, applications | student_slot created, application.student_slot_id set |
| Post-Exam | results | result imported via Excel |
| Survey | survey_results, selected_courses | survey + courses saved |

---

*Last Updated: February 2026*
