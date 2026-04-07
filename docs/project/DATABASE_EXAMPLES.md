# SKSU TPT v3 — Database Example Data

> 1-3 realistic rows per table. Enough to understand the expected data shape.

---

## `users`

| id | email                   | google_id  | is_active |
| -- | ----------------------- | ---------- | --------- |
| 1  | superadmin@sksu.edu.ph  | NULL       | true      |
| 2  | cruzm@sksu.edu.ph       | NULL       | true      |
| 3  | joy.cashier@sksu.edu.ph | NULL       | true      |
| 4  | rico.staff@sksu.edu.ph  | NULL       | true      |
| 5  | maria.santos@gmail.com  | 1098234756 | true      |

*1=SuperAdmin, 2=Admin(Ms.Cruz), 3=Cashier(Joy), 4=Staff(Rico), 5=Applicant(Maria)*

---

## `roles` (Spatie)

| id | name        | guard_name |
| -- | ----------- | ---------- |
| 1  | super-admin | web        |
| 2  | admin       | web        |
| 3  | staff       | web        |
| 4  | cashier     | web        |
| 5  | applicant   | web        |

---

## `model_has_roles` (Spatie)

| role_id | model_type      | model_id |
| ------- | --------------- | -------- |
| 1       | App\Models\User | 1        |
| 2       | App\Models\User | 2        |
| 4       | App\Models\User | 3        |
| 3       | App\Models\User | 4        |
| 5       | App\Models\User | 5        |

---

## `settings`

| id | key              | value                                                                                                                                                                       | group       |
| -- | ---------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------- |
| 1  | default_subjects | `["English","Science","Mathematics","Filipino","Social Studies","ESM Competency Score"]`                                                                                  | examination |
| 2  | stanine_labels   | `{"9":"Outstanding","8":"Above Average","7":"Above Average","6":"High Average","5":"Middle Average","4":"Low Average","3":"Below Average","2":"Below Average","1":"Low"}` | scoring     |
| 3  | exam_fee_amount  | `300`                                                                                                                                                                     | general     |

---

## `campuses`

| id | name     | code | address                       | is_active |
| -- | -------- | ---- | ----------------------------- | --------- |
| 1  | ACCESS   | ACC  | EJC Montilla, Tacurong City   | true      |
| 2  | Isulan   | ISU  | Isulan, Sultan Kudarat        | true      |
| 3  | Tacurong | TAC  | Tacurong City, Sultan Kudarat | true      |

*+ Lutayan(4), Kalamansig(5), Palimbang(6), Bagumbayan(7)*

---

## `programs`

| id | campus_id | name                                      | abbreviation | is_offered |
| -- | --------- | ----------------------------------------- | ------------ | ---------- |
| 1  | 1         | Bachelor of Science in Nursing            | BSN          | true       |
| 2  | 1         | Bachelor of Science in Medical Technology | BSMT         | true       |
| 3  | 2         | Bachelor of Science in Civil Engineering  | BSCE         | true       |

*57 programs total across 7 campuses*

---

## `examinations`

| id | title                 | school_year | application_start_date | application_end_date | is_active | examinee_number_start | results_published |
| -- | --------------------- | ----------- | ---------------------- | -------------------- | --------- | --------------------- | ----------------- |
| 1  | SKSU TPT SY 2025-2026 | 2025-2026   | 2025-01-15             | 2025-03-15           | false     | 400001                | true              |
| 2  | SKSU TPT SY 2026-2027 | 2026-2027   | 2026-01-15             | 2026-03-15           | false     | 500001                | true              |
| 3  | SKSU TPT SY 2027-2028 | 2027-2028   | 2027-01-15             | 2027-03-15           | true      | 600001                | false             |

---

## `exam_subjects`

| id | examination_id | name                 | code | order | is_composite |
| -- | -------------- | -------------------- | ---- | ----- | ------------ |
| 1  | 3              | English              | ENG  | 1     | false        |
| 2  | 3              | Science              | SCI  | 2     | false        |
| 3  | 3              | Mathematics          | MATH | 3     | false        |
| 4  | 3              | Filipino             | FIL  | 4     | false        |
| 5  | 3              | Social Studies       | SOC  | 5     | false        |
| 6  | 3              | ESM Competency Score | ESM  | 6     | true         |

---

## `score_configs`

| id | examination_id | type              | reference_key | reference_value           |
| -- | -------------- | ----------------- | ------------- | ------------------------- |
| 1  | 3              | stanine_range     | 9             | `{"min":750,"max":800}` |
| 2  | 3              | stanine_range     | 5             | `{"min":400,"max":449}` |
| 3  | 3              | stanine_range     | 1             | `{"min":200,"max":249}` |
| 4  | 3              | qualitative_label | 9             | `"Outstanding"`         |
| 5  | 3              | qualitative_label | 5             | `"Middle Average"`      |
| 6  | 3              | qualitative_label | 1             | `"Low"`                 |

*18 rows total per exam (9 ranges + 9 labels)*

---

## `program_cutoffs`

| id | examination_id | program_id | cutoff_score | notes                             | set_by |
| -- | -------------- | ---------- | ------------ | --------------------------------- | ------ |
| 1  | 3              | 1          | 400          | BSN — increased from 380         | 2      |
| 2  | 3              | 2          | 420          | BSMT — board passing priority    | 2      |
| 3  | 3              | 3          | 450          | BSCE — engineering higher cutoff | 2      |

*57 rows per exam (one per offered program)*

---

## `profiles`

| id | user_id | first_name | last_name | birthdate  | gender | phone       | address_city  | address_province | school_name          | strand | year_graduated | lrn          | applicant_type |
| -- | ------- | ---------- | --------- | ---------- | ------ | ----------- | ------------- | ---------------- | -------------------- | ------ | -------------- | ------------ | -------------- |
| 1  | 5       | Maria      | Santos    | 2008-05-12 | Female | 09171234567 | Tacurong City | Sultan Kudarat   | Tacurong National HS | STEM   | 2026           | 301245678901 | freshmen       |
| 2  | 6       | Juan       | Dela Cruz | 2008-08-23 | Male   | 09189876543 | Isulan        | Sultan Kudarat   | Isulan National HS   | ABM    | 2026           | 301298765432 | freshmen       |

---

## `applications`

| id | user_id | examination_id | application_number | status   | submitted_at        |
| -- | ------- | -------------- | ------------------ | -------- | ------------------- |
| 1  | 5       | 3              | APP-2027-00001     | resulted | 2027-01-16 08:23:00 |
| 2  | 6       | 3              | APP-2027-00002     | examined | 2027-01-16 10:45:00 |
| 3  | 5       | 2              | APP-2026-03421     | resulted | 2026-01-20 08:00:00 |

*Maria (user 5) has 2 applications — she re-applied from 2026 to 2027*

---

## `program_preferences`

| id | application_id | program_id | priority |
| -- | -------------- | ---------- | -------- |
| 1  | 1              | 1          | 1        |
| 2  | 1              | 2          | 2        |
| 3  | 2              | 3          | 1        |

*Maria: 1st BSN, 2nd BSMT. Juan: 1st BSCE. These are guides only — not restrictive.*

---

## `payments`

| id | application_id | amount | receipt_number | payment_method | campus_id | processed_by | paid_at             |
| -- | -------------- | ------ | -------------- | -------------- | --------- | ------------ | ------------------- |
| 1  | 1              | 300.00 | OR-2027-0001   | cash           | 3         | 3            | 2027-01-17 09:15:00 |
| 2  | 2              | 300.00 | OR-2027-0002   | cash           | 2         | 3            | 2027-01-17 10:30:00 |

*Maria paid at Tacurong (campus 3). Juan paid at Isulan (campus 2). Both by Cashier Joy (user 3).*

---

## `exam_schedules`

| id | examination_id | campus_id | date       | start_time | end_time | capacity | num_rooms | seats_per_room | is_active |
| -- | -------------- | --------- | ---------- | ---------- | -------- | -------- | --------- | -------------- | --------- |
| 1  | 3              | 1         | 2027-03-21 | 08:00      | 12:00    | 1000     | 20        | 50             | true      |
| 2  | 3              | 2         | 2027-03-23 | 08:00      | 12:00    | 800      | 16        | 50             | true      |
| 3  | 3              | 3         | 2027-03-24 | 08:00      | 12:00    | 600      | 12        | 50             | true      |

*Mar 21 ACCESS 1000 seats. Mar 23 Isulan 800 seats. Mar 24 Tacurong 600 seats.*

---

## `seat_assignments`

| id | exam_schedule_id | application_id | room_number | seat_number | assigned_at         |
| -- | ---------------- | -------------- | ----------- | ----------- | ------------------- |
| 1  | 1                | 1              | 1           | 1           | 2027-01-17 09:20:00 |
| 2  | 2                | 2              | 1           | 1           | 2027-01-17 10:35:00 |
| 3  | 1                | NULL           | 1           | 2           | NULL                |

*Maria → Mar 21 ACCESS Room 1 Seat 1. Juan → Mar 23 Isulan Room 1 Seat 1. Row 3 = empty seat.*

---

## `permits`

| id | application_id | exam_schedule_id | examinee_number | qr_code_data                                        | room_number | seat_number | issued_at           |
| -- | -------------- | ---------------- | --------------- | --------------------------------------------------- | ----------- | ----------- | ------------------- |
| 1  | 1              | 1                | 600001          | `{"permit_id":1,"examinee":"600001","exam_id":3}` | 1           | 1           | 2027-01-17 09:20:00 |
| 2  | 2              | 2                | 600002          | `{"permit_id":2,"examinee":"600002","exam_id":3}` | 1           | 1           | 2027-01-17 10:35:00 |

---

## `attendances`

| id | application_id | exam_schedule_id | permit_id | status  | scanned_at          | scanned_by | notes               |
| -- | -------------- | ---------------- | --------- | ------- | ------------------- | ---------- | ------------------- |
| 1  | 1              | 1                | 1         | present | 2027-03-21 07:45:00 | 4          | NULL                |
| 2  | 2              | 2                | 2         | late    | 2027-03-23 08:35:00 | 4          | Arrived 35 min late |

*Maria present at 7:45 AM. Juan late at 8:35 AM. Staff Rico (user 4) scanned both.*

---

## `exam_results`

| id | application_id | examination_id | overall_standard_score | overall_stanine | overall_interpretation | is_qualified | uploaded_via     | uploaded_by |
| -- | -------------- | -------------- | ---------------------- | --------------- | ---------------------- | ------------ | ---------------- | ----------- |
| 1  | 1              | 3              | 654                    | 8               | Above Average          | true         | bulk_import      | 2           |
| 2  | 2              | 3              | 425                    | 5               | Middle Average         | true         | individual_entry | 2           |

*Maria 654 (bulk upload). Juan 425 (added individually — late examinee).*

---

## `subject_scores`

**Maria (exam_result_id=1):**

| id | exam_result_id | exam_subject_id | standard_score | stanine | qualitative_interpretation |
| -- | -------------- | --------------- | -------------- | ------- | -------------------------- |
| 1  | 1              | 1               | 654            | 8       | Above Average              |
| 2  | 1              | 2               | 700            | 8       | Above Average              |
| 3  | 1              | 3               | 620            | 7       | Above Average              |

**Juan (exam_result_id=2):**

| id | exam_result_id | exam_subject_id | standard_score | stanine | qualitative_interpretation |
| -- | -------------- | --------------- | -------------- | ------- | -------------------------- |
| 7  | 2              | 1               | 380            | 4       | Low Average                |
| 8  | 2              | 2               | 420            | 5       | Middle Average             |
| 9  | 2              | 3               | 350            | 4       | Low Average                |

*6 rows per student (one per subject). Dynamic — if 7 subjects next year, 7 rows.*

---

## `program_qualifications`

**Maria (score=654):**

| id | application_id | program_id | is_qualified | applicant_score | cutoff_score | rank_in_program |
| -- | -------------- | ---------- | ------------ | --------------- | ------------ | --------------- |
| 1  | 1              | 1          | true         | 654             | 400          | 23              |
| 2  | 1              | 3          | true         | 654             | 450          | 45              |

**Juan (score=425):**

| id | application_id | program_id | is_qualified | applicant_score | cutoff_score | rank_in_program |
| -- | -------------- | ---------- | ------------ | --------------- | ------------ | --------------- |
| 3  | 2              | 1          | true         | 425             | 400          | 1847            |
| 4  | 2              | 3          | false        | 425             | 450          | NULL            |

*Maria qualifies for BSN (rank #23) and BSCE (rank #45). Juan qualifies for BSN (rank #1847) but NOT BSCE (425 < 450 cutoff).*

---

## `notifications`

| id       | type             | notifiable_id | data                                                             | read_at             |
| -------- | ---------------- | ------------- | ---------------------------------------------------------------- | ------------------- |
| uuid-001 | PaymentVerified  | 5             | `{"message":"Payment confirmed!","application_id":1}`          | 2027-01-17 09:18:00 |
| uuid-002 | ResultsPublished | 5             | `{"message":"Your results are available!","examination_id":3}` | NULL                |

---

## `announcements`

| id | examination_id | title                         | content                                          | is_published | published_by |
| -- | -------------- | ----------------------------- | ------------------------------------------------ | ------------ | ------------ |
| 1  | 3              | Application Deadline Extended | Extended to March 20, 2027.                      | true         | 2            |
| 2  | 3              | Exam Day Reminders            | Bring permit and 2 valid IDs. Report by 7:30 AM. | true         | 2            |

---

## `audit_logs`

| id | user_id | action   | model_type | model_id | old_values        | new_values                                  | ip_address   |
| -- | ------- | -------- | ---------- | -------- | ----------------- | ------------------------------------------- | ------------ |
| 1  | 3       | created  | Payment    | 1        | NULL              | `{"amount":300,"receipt":"OR-2027-0001"}` | 192.168.1.45 |
| 2  | 2       | uploaded | ExamResult | NULL     | NULL              | `{"file":"RESULTS.xlsx","records":8937}`  | 192.168.1.10 |
| 3  | 2       | updated  | ExamResult | 2        | `{"score":425}` | `{"score":435}`                           | 192.168.1.10 |

*Cashier created payment. Admin uploaded results. Admin corrected Juan's score.*

---

## Survey Tables

### `survey_templates`

| id | examination_id | title                           | is_active |
| -- | -------------- | ------------------------------- | --------- |
| 1  | 3              | Post-Exam Feedback SY 2027-2028 | true      |

### `survey_questions`

| id | survey_template_id | question                      | type            | options                     | order |
| -- | ------------------ | ----------------------------- | --------------- | --------------------------- | ----- |
| 1  | 1                  | Rate the exam venue           | rating          | NULL                        | 1     |
| 2  | 1                  | Was the proctor helpful?      | multiple_choice | `["Yes","Somewhat","No"]` | 2     |
| 3  | 1                  | Any problems during the exam? | text            | NULL                        | 3     |

### `survey_responses`

| id | survey_template_id | application_id | submitted_at        |
| -- | ------------------ | -------------- | ------------------- |
| 1  | 1                  | 1              | 2027-04-05 08:30:00 |

### `survey_answers`

| id | survey_response_id | survey_question_id | answer               |
| -- | ------------------ | ------------------ | -------------------- |
| 1  | 1                  | 1                  | 4                    |
| 2  | 1                  | 2                  | Yes                  |
| 3  | 1                  | 3                  | Room was too crowded |

---

## Data Volume Per Exam Cycle (~9,000 applicants)

| Table                  | Est. Rows |
| ---------------------- | --------- |
| users                  | ~10,000   |
| profiles               | ~9,000    |
| applications           | ~9,000    |
| payments               | ~9,000    |
| seat_assignments       | ~5,100    |
| permits                | ~9,000    |
| attendances            | ~8,500    |
| exam_results           | ~8,937    |
| subject_scores         | ~53,622   |
| program_qualifications | ~509,409  |
| notifications          | ~36,000   |
| audit_logs             | ~50,000+  |
| survey_answers         | ~32,000   |
