# CSV to TablePlus Import Guide — SKSU TPT Result 2026

## Overview

This guide documents how to import the SKSU TPT Result 2026 data into the `results` database table using TablePlus or the pre-cleaned CSV.

---

## Option 1: Use the Pre-Cleaned CSV (Recommended)

A cleaned CSV file has been generated: **`SKSU_TPT_RESULT_2026_CLEAN.csv`**

This file already has:
- Single header row with exact table column names
- `examination_id = 3` on every row
- 635 empty rows removed
- Only the 15 columns needed for the `results` table
- 8,937 data rows ready to import

### Clean CSV Columns (15 total)

| #  | CSV Header                     | Table Column                    | Source                          |
| -- | ------------------------------ | ------------------------------- | ------------------------------- |
| 1  | examination_id                 | `examination_id`                | Set to `3` (TPT 2026-2027)     |
| 2  | full_name                      | `full_name`                     | Name of Examinee               |
| 3  | examinee_number                | `examinee_number`               | Examinee Number                 |
| 4  | english_standard_score         | `english_standard_score`        | English — Standard Score        |
| 5  | english_raw_score              | `english_raw_score`             | English — Stanine               |
| 6  | science_standard_score         | `science_standard_score`        | Science — Standard Score        |
| 7  | science_raw_score              | `science_raw_score`             | Science — Stanine               |
| 8  | math_standard_score            | `math_standard_score`           | Mathematics — Standard Score    |
| 9  | math_raw_score                 | `math_raw_score`                | Mathematics — Stanine           |
| 10 | filipino_standard_score        | `filipino_standard_score`       | Filipino — Standard Score       |
| 11 | filipino_raw_score             | `filipino_raw_score`            | Filipino — Stanine              |
| 12 | social_studies_standard_score  | `social_studies_standard_score` | Social Studies — Standard Score |
| 13 | social_studies_raw_score       | `social_studies_raw_score`      | Social Studies — Stanine        |
| 14 | total_standard_score           | `total_standard_score`          | Overall — Standard Score        |
| 15 | total_raw_score                | `total_raw_score`               | Overall — Stanine               |

### TablePlus Import Settings

| Setting              | Value                             |
| -------------------- | --------------------------------- |
| Table                | `results`                         |
| First line is header | Checked                           |
| Match Columns        | By Name and Order                 |
| Delimiter            | `,`                               |
| Quote                | `"`                               |
| Encoding             | `utf8`                            |
| Insert option        | `STOP ON ERROR`                   |

All 15 columns will auto-match by name. Just click **Import**.

### How the Clean CSV Was Generated

The PHP script `docs/clean_csv.php` was used to:
1. Read the original `SKSU TPT RESULT 2026.csv`
2. Skip the 2 header rows (group labels + sub-labels)
3. Skip 635 empty rows (no examinee name)
4. Extract only the 14 needed data columns
5. Add `examination_id = 3` to every row
6. Write a single clean header row with exact table column names

To regenerate: `php docs/clean_csv.php`

---

## Option 2: Manual Import from Original CSV

If importing directly from the original `SKSU TPT RESULT 2026.csv`, follow these steps.

### Prerequisites

1. Open the Excel file `SKSU_TPT_RESULT_2026.xlsx`
2. Go to the **Result** sheet only
3. Save As → **CSV UTF-8 (Comma delimited)**
4. Open TablePlus and connect to your database

### Known Issues with Original CSV

- Has **2 header rows** (group labels + sub-labels) which confuses TablePlus
- Many columns share the same name (`Standard Score`, `Stanine`, `Qualitative In...`)
- Does NOT include `examination_id` — must be added manually
- Contains 635 empty rows that must be skipped
- Contains 33 columns but only 14 are needed

### Column Mapping (Left to Right as Shown in TablePlus)

| #  | Group              | Header            | Set Dropdown To                   |
| -- | ------------------ | ----------------- | --------------------------------- |
| 1  |                    | Name of Examin... | `full_name`                       |
| 2  |                    | Examinee Number   | `examinee_number`                 |
| 3  |                    | Preferred Prog... | Do not import                     |
| 4  | English            | Standard Score    | `english_standard_score`          |
| 5  | English            | Stanine           | `english_raw_score`               |
| 6  | English            | Qualitative In... | Do not import                     |
| 7  | Science            | Standard Score    | `science_standard_score`          |
| 8  | Science            | Stanine           | `science_raw_score`               |
| 9  | Science            | Qualitative In... | Do not import                     |
| 10 | Mathematics        | Standard Score    | `math_standard_score`             |
| 11 | Mathematics        | Stanine           | `math_raw_score`                  |
| 12 | Mathematics        | Qualitative In... | Do not import                     |
| 13 | Filipino           | Standard Score    | `filipino_standard_score`         |
| 14 | Filipino           | Stanine           | `filipino_raw_score`              |
| 15 | Filipino           | Qualitative In... | Do not import                     |
| 16 | Social Studies     | Standard Score    | `social_studies_standard_score`   |
| 17 | Social Studies     | Stanine           | `social_studies_raw_score`        |
| 18 | Social Studies     | Qualitative In... | Do not import                     |
| 19 | ESM Competency...  | Standard Score    | Do not import                     |
| 20 | ESM Competency...  | Stanine           | Do not import                     |
| 21 | ESM Competency...  | Qualitative In... | Do not import                     |
| 22 | Overall Score      | Standard Score    | `total_standard_score`            |
| 23 | Overall Score      | Stanine           | `total_raw_score`                 |
| 24 | Overall Score      | Qualitative In... | Do not import                     |
| 25–31 |                 | EMPTY             | Do not import                     |
| 32 |                    | (number)          | Do not import                     |
| 33 |                    | (program ref)     | Do not import                     |

After import, run this SQL to set the examination ID:
```sql
UPDATE results SET examination_id = 3 WHERE examination_id IS NULL;
```

---

## Database Table Schema (`results`)

| Column                        | Type             | Null | Default        |
| ----------------------------- | ---------------- | ---- | -------------- |
| id                            | bigint unsigned  | NO   | auto_increment |
| **examination_id**            | bigint unsigned  | **NO** | **none (required!)** |
| examinee_number               | varchar(255)     | YES  | NULL           |
| full_name                     | varchar(255)     | YES  | NULL           |
| math_raw_score                | varchar(255)     | YES  | NULL           |
| math_standard_score           | varchar(255)     | YES  | NULL           |
| english_raw_score             | varchar(255)     | YES  | NULL           |
| english_standard_score        | varchar(255)     | YES  | NULL           |
| filipino_raw_score            | varchar(255)     | YES  | NULL           |
| filipino_standard_score       | varchar(255)     | YES  | NULL           |
| science_raw_score             | varchar(255)     | YES  | NULL           |
| science_standard_score        | varchar(255)     | YES  | NULL           |
| social_studies_raw_score      | varchar(255)     | YES  | NULL           |
| social_studies_standard_score | varchar(255)     | YES  | NULL           |
| total_raw_score               | varchar(255)     | YES  | NULL           |
| total_standard_score          | varchar(255)     | YES  | NULL           |
| created_at                    | timestamp        | YES  | NULL           |
| updated_at                    | timestamp        | YES  | NULL           |

> **`examination_id`** is the only required column (besides `id` which is auto-increment). It must be provided during import or set via SQL after.

---

## Column Name Mapping (Table vs Data Spec)

The `*_raw_score` columns are repurposed to store **Stanine** values (1–9):

| Table Column          | Stores              | Original Data Spec Field     |
| --------------------- | ------------------- | ---------------------------- |
| `*_standard_score`    | Standard Score      | Standard Score (200–800)     |
| `*_raw_score`         | Stanine             | Stanine (1–9)                |

---

## Data Summary

| Item                   | Value  |
| ---------------------- | ------ |
| Total examinees        | 8,937  |
| Empty rows skipped     | 635    |
| Examination ID         | 3      |
| Examination title      | SKSU Tertiary Placement Test |
| School year            | 2026-2027 |
| Subjects imported      | 6 (English, Science, Math, Filipino, Social Studies, Overall) |
| Subjects skipped       | 1 (ESM Competency — composite, no table columns) |
