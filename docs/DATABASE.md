# Database Schema Documentation

## Overview

The TPT system uses MySQL/MariaDB as its primary database. The schema is organized around core entities: Users, Examinations, Applications, Permits, Results, and Slots.

---

## Entity Relationship Diagram (ERD) Summary

```
                                    ┌─────────────┐
                                    │   campuses  │
                                    └──────┬──────┘
                                           │
                         ┌─────────────────┼─────────────────┐
                         ▼                 ▼                 ▼
                  ┌──────────┐     ┌─────────────┐    ┌──────────────┐
                  │ programs │     │test_centers │    │              │
                  └────┬─────┘     └──────┬──────┘    │              │
                       │                  │           │              │
                       │           ┌──────┴──────┐    │              │
                       │           │    slots    │    │              │
                       │           └──────┬──────┘    │              │
                       │                  │           │              │
┌───────┐     ┌────────┴───────────┐      │           │              │
│ roles │────▶│       users        │◀─────┼───────────┤ examinations │
└───────┘     └─────────┬──────────┘      │           │              │
                        │                 │           │              │
      ┌─────────────────┼─────────────────┼───────────┼──────────────┤
      │                 │                 │           │              │
      ▼                 ▼                 ▼           │              │
┌───────────────┐ ┌──────────────┐ ┌─────────────┐   │              │
│personal_info  │ │applications  │ │student_slots│   │              │
└───────────────┘ └──────────────┘ └─────────────┘   │              │
                        │                             │              │
      ┌─────────────────┼─────────────────────────────┤              │
      │                 │                             │              │
      ▼                 ▼                             ▼              │
┌───────────┐    ┌───────────┐                 ┌───────────┐        │
│ payments  │    │  permits  │                 │  results  │◀───────┘
└───────────┘    └───────────┘                 └───────────┘
      │
      ▼
┌───────────┐
│  proofs   │
└───────────┘
```

---

## Tables Reference

### 1. users
Core authentication and user data table.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| step | VARCHAR(255) | NO | '1' | Current application step (1-5) |
| type_id | BIGINT UNSIGNED | YES | NULL | FK to types (Freshmen/Transferee) |
| role_id | BIGINT UNSIGNED | NO | 2 | FK to roles (1=Admin, 2=Applicant) |
| first_name | VARCHAR(255) | NO | | User's first name |
| middle_name | VARCHAR(255) | YES | NULL | User's middle name |
| last_name | VARCHAR(255) | NO | | User's last name |
| email | VARCHAR(255) | NO | | Unique email address |
| email_verified_at | TIMESTAMP | YES | NULL | Email verification timestamp |
| password | VARCHAR(255) | YES | NULL | Hashed password (nullable for OAuth) |
| remember_token | VARCHAR(100) | YES | NULL | Remember me token |
| current_team_id | BIGINT UNSIGNED | YES | NULL | Jetstream team ID |
| profile_photo_path | VARCHAR(2048) | YES | NULL | Profile photo path |
| remarks | TEXT | YES | NULL | Admin remarks for rejection |
| is_declined | BOOLEAN | NO | FALSE | Payment declined flag |
| two_factor_secret | TEXT | YES | NULL | 2FA secret |
| two_factor_recovery_codes | TEXT | YES | NULL | 2FA recovery codes |
| provider | VARCHAR(255) | YES | NULL | OAuth provider (google) |
| provider_id | VARCHAR(255) | YES | NULL | OAuth provider user ID |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

**Step Values:**
- `1`: Initial registration (default)
- `2`: Fill application (personal info, school info, program choice)
- `3`: Submit payment
- `4`: Awaiting payment approval
- `5`: Approved - Can view permit

---

### 2. roles
User role definitions.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| name | VARCHAR(255) | NO | | Role name |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

**Seeded Data:**
| id | name |
|----|------|
| 1 | Admin |
| 2 | Applicant |

---

### 3. types
Applicant type definitions.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| name | VARCHAR(255) | NO | | Type name |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

**Seeded Data:**
| id | name |
|----|------|
| 1 | Freshmen |
| 2 | Transferee |

---

### 4. personal_information
Detailed personal information for applicants.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| type_id | BIGINT UNSIGNED | NO | | FK to types |
| user_id | BIGINT UNSIGNED | NO | | FK to users (CASCADE) |
| first_name | VARCHAR(255) | NO | | First name |
| middle_name | VARCHAR(255) | YES | NULL | Middle name |
| last_name | VARCHAR(255) | NO | | Last name |
| extension | VARCHAR(255) | YES | NULL | Name extension (Jr., Sr., etc.) |
| present_address | VARCHAR(255) | NO | | Current address |
| permanent_address | VARCHAR(255) | NO | | Permanent address |
| phone_number | VARCHAR(255) | NO | | Contact number |
| date_of_birth | VARCHAR(255) | NO | | Date of birth (YYYY-MM-DD) |
| place_of_birth | VARCHAR(255) | NO | | Birth place |
| age | VARCHAR(255) | NO | | Age |
| tribe | VARCHAR(255) | NO | | Ethnic tribe |
| religion | VARCHAR(255) | NO | | Religion |
| nationality | VARCHAR(255) | NO | | Nationality |
| citizenship | VARCHAR(255) | NO | | Citizenship |
| photo | VARCHAR(255) | NO | | Photo file path |
| sex | VARCHAR(255) | NO | | Gender |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 5. school_information
Previous school information for applicants.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | NO | | FK to users (CASCADE) |
| school_name | VARCHAR(255) | NO | | Previous school name |
| school_address | VARCHAR(255) | NO | | School address |
| level | VARCHAR(255) | NO | | Education level |
| gwa | VARCHAR(255) | NO | | General weighted average |
| strand | VARCHAR(255) | YES | NULL | Academic strand (for SHS) |
| school_type | VARCHAR(255) | NO | | Public/Private |
| year_graduated | VARCHAR(255) | NO | | Year of graduation |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 6. examinations
Examination schedules and settings.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| name | VARCHAR(255) | NO | | Examination name |
| is_active | BOOLEAN | NO | FALSE | Active examination flag |
| show_results | BOOLEAN | NO | FALSE | Show results to applicants |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

**Note:** Only ONE examination should be active at a time.

---

### 7. applications
Student examination applications.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | NO | | FK to users (CASCADE) |
| examination_id | BIGINT UNSIGNED | NO | | FK to examinations (CASCADE) |
| submitted_at | TIMESTAMP | YES | NULL | Submission timestamp |
| status | VARCHAR(255) | YES | 'pending' | Application status |
| student_slot_id | BIGINT UNSIGNED | YES | NULL | FK to student_slots |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

**Status Values:**
- `pending`: Application submitted, awaiting review
- `approved`: Payment approved, permit generated
- `rejected`: Payment rejected

---

### 8. campuses
Campus locations.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| name | VARCHAR(255) | NO | | Campus name |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 9. programs
Academic programs offered per campus.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| campus_id | BIGINT UNSIGNED | NO | | FK to campuses (CASCADE) |
| name | VARCHAR(255) | NO | | Program name |
| description | TEXT | YES | NULL | Program description |
| is_offered | BOOLEAN | NO | TRUE | Currently offered flag |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 10. program_choices
Student's program preferences (ordered choices).

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | NO | | FK to users |
| program_id | BIGINT UNSIGNED | NO | | FK to programs |
| choice_order | INT | NO | | Priority order (1, 2, 3) |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 11. payments
Payment records for examination fees.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | NO | | FK to users |
| examination_id | BIGINT UNSIGNED | NO | | FK to examinations |
| reference_number | VARCHAR(255) | NO | | Payment reference number |
| paid_at | TIMESTAMP | YES | NULL | Payment date |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 12. proofs
Payment proof documents (receipts).

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| payment_id | BIGINT UNSIGNED | NO | | FK to payments |
| path | VARCHAR(255) | NO | | File path to proof document |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 13. permits
Examination permits (generated after payment approval).

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | NO | | FK to users |
| examination_id | BIGINT UNSIGNED | NO | | FK to examinations |
| examinee_number | VARCHAR(255) | NO | | Original examinee number |
| examinee_number_updated | VARCHAR(255) | YES | NULL | Updated examinee number |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 14. test_centers
Examination testing centers.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| examination_id | BIGINT UNSIGNED | NO | | FK to examinations |
| campus_id | BIGINT UNSIGNED | NO | | FK to campuses |
| name | VARCHAR(255) | NO | | Test center name |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 15. slots
Available examination slots at test centers.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| test_center_id | BIGINT UNSIGNED | NO | | FK to test_centers |
| date_of_exam | DATE | NO | | Examination date |
| time | VARCHAR(255) | NO | | Time slot (e.g., "8:00 AM") |
| slots | INT | NO | | Number of available seats |
| is_active | BOOLEAN | NO | TRUE | Slot activation status |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 16. student_slots
Student slot assignments.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | NO | | FK to users |
| slot_id | BIGINT UNSIGNED | NO | | FK to slots |
| room_number | VARCHAR(255) | YES | NULL | Assigned room |
| seat_number | VARCHAR(255) | YES | NULL | Assigned seat |
| time | VARCHAR(255) | YES | NULL | Exam time |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 17. results
Examination results and scores.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| examination_id | BIGINT UNSIGNED | NO | | FK to examinations (CASCADE) |
| examinee_number | VARCHAR(255) | YES | NULL | Examinee number |
| full_name | VARCHAR(255) | YES | NULL | Full name of examinee |
| math_raw_score | VARCHAR(255) | YES | NULL | Math raw score |
| math_standard_score | VARCHAR(255) | YES | NULL | Math stanine score |
| english_raw_score | VARCHAR(255) | YES | NULL | English raw score |
| english_standard_score | VARCHAR(255) | YES | NULL | English stanine score |
| filipino_raw_score | VARCHAR(255) | YES | NULL | Filipino raw score |
| filipino_standard_score | VARCHAR(255) | YES | NULL | Filipino stanine score |
| science_raw_score | VARCHAR(255) | YES | NULL | Science raw score |
| science_standard_score | VARCHAR(255) | YES | NULL | Science stanine score |
| social_studies_raw_score | VARCHAR(255) | YES | NULL | Social Studies raw score |
| social_studies_standard_score | VARCHAR(255) | YES | NULL | Social Studies stanine score |
| total_raw_score | VARCHAR(255) | YES | NULL | Total raw score |
| total_standard_score | VARCHAR(255) | YES | NULL | Total stanine score |
| show_result | BOOLEAN | NO | FALSE | Show result to student |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

**Stanine Score Interpretation:**
| Stanine | Interpretation |
|---------|----------------|
| 9 | Outstanding |
| 8 | Above Average |
| 7 | Above Average |
| 6 | High Average |
| 5 | Middle Average |
| 4 | Low Average |
| 3 | Below Average |
| 2 | Below Average |
| 1 | Low |

---

### 18. survey_results
Post-examination survey responses.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | NO | | FK to users |
| question_1 | VARCHAR(255) | YES | NULL | Survey question 1 response |
| question_2 | VARCHAR(255) | YES | NULL | Survey question 2 response |
| question_3 | VARCHAR(255) | YES | NULL | Survey question 3 response |
| question_4 | VARCHAR(255) | YES | NULL | Survey question 4 response |
| question_5 | VARCHAR(255) | YES | NULL | Survey question 5 response |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

### 19. selected_courses
Courses selected by applicants after survey.

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| id | BIGINT UNSIGNED | NO | AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | NO | | FK to users |
| program_id | BIGINT UNSIGNED | NO | | FK to programs |
| created_at | TIMESTAMP | YES | NULL | Created timestamp |
| updated_at | TIMESTAMP | YES | NULL | Updated timestamp |

---

## Migration Files List

| Order | Migration File | Description |
|-------|---------------|-------------|
| 1 | 2014_10_12_000000_create_users_table.php | Create users table |
| 2 | 2014_10_12_100000_create_password_resets_table.php | Password reset tokens |
| 3 | 2014_10_12_200000_add_two_factor_columns_to_users_table.php | 2FA columns |
| 4 | 2019_08_19_000000_create_failed_jobs_table.php | Failed jobs table |
| 5 | 2019_12_14_000001_create_personal_access_tokens_table.php | API tokens |
| 6 | 2022_06_27_233737_create_sessions_table.php | Sessions table |
| 7 | 2022_06_27_234625_create_personal_information_table.php | Personal info |
| 8 | 2022_06_27_234634_create_school_information_table.php | School info |
| 9 | 2022_06_27_234654_create_payments_table.php | Payments table |
| 10 | 2022_06_27_234717_create_examinations_table.php | Examinations table |
| 11 | 2022_06_27_234738_create_permits_table.php | Permits table |
| 12 | 2022_06_28_002521_create_types_table.php | User types |
| 13 | 2022_06_28_003151_create_proofs_table.php | Payment proofs |
| 14 | 2022_06_28_003345_create_applications_table.php | Applications |
| 15 | 2022_06_28_003749_create_roles_table.php | User roles |
| 16 | 2022_06_28_004301_create_program_choices_table.php | Program choices |
| 17 | 2022_06_28_004443_create_campuses_table.php | Campuses |
| 18 | 2022_06_28_004457_create_programs_table.php | Programs |
| 19 | 2022_07_20_041331_create_results_table.php | Results table |
| 20 | 2023_01_25_125834_create_test_centers_table.php | Test centers |
| 21 | 2023_01_25_130035_create_slots_table.php | Time slots |
| 22 | 2023_01_26_025844_create_student_slots_table.php | Student slot assignments |
| 23 | 2023_02_01_024740_add_remarks_column_to_users_table.php | Add remarks |
| 24 | 2023_02_03_062133_add_column_is_active_to_slots_table.php | Add is_active to slots |
| 25 | 2023_06_02_110905_create_survey_results_table.php | Survey results |
| 26 | 2023_06_04_000503_create_selected_courses_table.php | Selected courses |
| 27 | 2024_01_07_094935_add_column_is_declined_on_users_table.php | Add is_declined |
| 28 | 2024_01_31_011736_add_column_examinee_number_updated_in_permits_table.php | Add examinee_number_updated |
| 29 | 2024_12_26_030140_add_provider_columns_to_users_table.php | OAuth columns |
| 30 | 2025_04_10_010503_create_jobs_table.php | Queue jobs |
| 31 | 2025_06_04_123309_add_fullname_column_to_results.php | Add full_name to results |
| 32 | 2025_06_04_123635_add_show_results_to_examinations_table.php | Add show_results |

---

## Seeders

| Seeder | Description |
|--------|-------------|
| DatabaseSeeder.php | Master seeder (calls others) |
| CampusSeeder.php | Seeds campus data |
| RoleSeeder.php | Seeds roles (Admin, Applicant) and types (Freshmen, Transferee) |
| AccountSeeder.php | Seeds default admin account |
| UserSeeder.php | Seeds test user accounts |

---

## Running Migrations

```bash
# Run all migrations
php artisan migrate

# Run seeders
php artisan db:seed

# Fresh migration with seeders
php artisan migrate:fresh --seed

# Create database snapshot
php artisan snapshot:create snapshot_name
```

---

*Last Updated: February 2026*
