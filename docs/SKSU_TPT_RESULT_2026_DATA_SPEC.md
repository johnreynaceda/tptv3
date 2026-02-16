# SKSU TPT Result 2026 — Data Specification for Upload

## Overview

This document describes the structure and format of the **SKSU Tertiary Placement Test (TPT) Result 2026** Excel file (`SKSU_TPT_RESULT_2026.xlsx`) so that the development team can build the appropriate import/upload functionality into the system.

---

## File Details

| Property          | Value                                    |
| ----------------- | ---------------------------------------- |
| File Name         | `SKSU_TPT_RESULT_2026.xlsx`              |
| File Format       | Microsoft Excel 2007+ (`.xlsx`)          |
| Total Sheets      | 5 (`Sheet3`, `Sheet1`, `Sheet5`, `Result`, `Sheet2`) |
| **Primary Sheet** | **`Result`**                             |
| Total Rows        | 9,574 (including 2 header rows)          |
| Actual Data Rows  | **8,937 examinees** (635 rows are empty) |
| Total Columns     | 33 (A–AG)                                |

> **Important:** Only the **`Result`** sheet contains the final, cleaned data intended for upload. The other sheets (`Sheet1`, `Sheet3`, `Sheet5`, `Sheet2`) contain raw computations, z-scores, and intermediate data — these should be **ignored** during import.

---

## Header Structure

The `Result` sheet uses a **two-row merged header**:

- **Row 1** — Subject group labels (e.g., `English`, `Science`, `Mathematics`, etc.)
- **Row 2** — Sub-column labels (e.g., `Standard Score`, `Stanine`, `Qualitative Interpretation`)

**Data starts at Row 3.**

---

## Column Mapping (Primary Data — Columns A to X)

| Column | Letter | Field Name                              | Data Type | Example                                          |
| ------ | ------ | --------------------------------------- | --------- | ------------------------------------------------ |
| 1      | A      | Name of Examinee                        | String    | `Corbal, Precious Shane Acebes`                  |
| 2      | B      | Examinee Number                         | Integer   | `509127`                                         |
| 3      | C      | Preferred Program                       | String    | `Tacurong-Bachelor of Science in Biology`         |
| 4      | D      | English — Standard Score                | Integer   | `654`                                            |
| 5      | E      | English — Stanine                       | Integer   | `9`                                              |
| 6      | F      | English — Qualitative Interpretation    | String    | `Outstanding`                                    |
| 7      | G      | Science — Standard Score                | Integer   | `800`                                            |
| 8      | H      | Science — Stanine                       | Integer   | `9`                                              |
| 9      | I      | Science — Qualitative Interpretation    | String    | `Outstanding`                                    |
| 10     | J      | Mathematics — Standard Score            | Integer   | `800`                                            |
| 11     | K      | Mathematics — Stanine                   | Integer   | `9`                                              |
| 12     | L      | Mathematics — Qualitative Interpretation| String    | `Outstanding`                                    |
| 13     | M      | Filipino — Standard Score               | Integer   | `704`                                            |
| 14     | N      | Filipino — Stanine                      | Integer   | `9`                                              |
| 15     | O      | Filipino — Qualitative Interpretation   | String    | `Outstanding`                                    |
| 16     | P      | Social Studies — Standard Score         | Integer   | `749`                                            |
| 17     | Q      | Social Studies — Stanine                | Integer   | `9`                                              |
| 18     | R      | Social Studies — Qualitative Interpretation | String | `Outstanding`                                   |
| 19     | S      | ESM Competency Score — Standard Score   | Integer   | `800`                                            |
| 20     | T      | ESM Competency Score — Stanine          | Integer   | `9`                                              |
| 21     | U      | ESM Competency Score — Qualitative Interpretation | String | `Outstanding`                            |
| 22     | V      | Overall Score — Standard Score          | Integer   | `800`                                            |
| 23     | W      | Overall Score — Stanine                 | Integer   | `9`                                              |
| 24     | X      | Overall Score — Qualitative Interpretation | String | `Outstanding`                                   |

### Columns Y–AE (Ignore)

Columns Y through AE are **empty/unused** and should be skipped during import.

### Columns AF–AG (Reference Lookup — Separate Data)

These columns contain a **separate reference list** mapping `Examinee Number` to `Program Name`. This is likely used internally for VLOOKUP. **These are not part of the main examinee row data** and should be handled separately or ignored.

| Column | Letter | Field Name              | Data Type | Example                                  |
| ------ | ------ | ----------------------- | --------- | ---------------------------------------- |
| 32     | AF     | Examinee Number (ref)   | Integer   | `500874`                                 |
| 33     | AG     | Program Name (ref)      | String    | `ACCESS-Bachelor in Elementary Education` |

---

## Subject Areas (7 Total)

Each subject has 3 sub-columns: **Standard Score**, **Stanine**, and **Qualitative Interpretation**.

1. English
2. Science
3. Mathematics
4. Filipino
5. Social Studies
6. ESM Competency Score (composite of English, Science, Mathematics)
7. Overall Score

---

## Stanine & Qualitative Interpretation Scale

The stanine values range from **1 to 9** and map to qualitative labels as follows:

| Stanine | Qualitative Interpretation |
| ------- | -------------------------- |
| 9       | Outstanding                |
| 8       | Above Average              |
| 7       | Above Average              |
| 6       | High Average               |
| 5       | Middle Average             |
| 4       | Low Average                |
| 3       | Below Average              |
| 2       | Below Average              |
| 1       | Low                        |

> **Note:** Some cells in Column F (English — Qualitative Interpretation) contain **Excel formulas** (nested `IF` statements) instead of plain text values. When reading the file programmatically, make sure to **read computed/cached values** (i.e., use `data_only=True` in openpyxl, or equivalent) to get the resolved string.

---

## Stanine Distribution (Across All Subjects)

| Stanine | Label          | Count  |
| ------- | -------------- | ------ |
| 1       | Low            | 1,468  |
| 2       | Below Average  | 2,803  |
| 3       | Below Average  | 5,730  |
| 4       | Low Average    | 8,843  |
| 5       | Middle Average | 10,447 |
| 6       | High Average   | 13,062 |
| 7       | Above Average  | 10,484 |
| 8       | Above Average  | 6,019  |
| 9       | Outstanding    | 3,703  |

---

## Preferred Programs (57 Unique Values)

Programs follow the format: **`Campus-Program Name`** (e.g., `Isulan-Bachelor of Science in Civil Engineering`).

### Campuses

- ACCESS
- Bagumbayan
- Isulan
- Kalamansig
- Lutayan
- Palimbang
- Tacurong

### Special Values

- `No Preferred Program Identified` — examinee did not select a program
- `#N/A` — lookup error, treat as null/missing

<details>
<summary>Full list of 57 programs (click to expand)</summary>

- ACCESS-Bachelor in Elementary Education
- ACCESS-Bachelor in Physical Education
- ACCESS-Bachelor in Secondary Education major in: English
- ACCESS-Bachelor in Secondary Education major in: Filipino
- ACCESS-Bachelor in Secondary Education major in: Mathematics
- ACCESS-Bachelor in Secondary Education major in: Science
- ACCESS-Bachelor in Secondary Education major in: Social Studies
- ACCESS-Bachelor of Science in Criminology
- ACCESS-Bachelor of Science in Industrial Security Management
- ACCESS-Bachelor of Science in Medical Technology
- ACCESS-Bachelor of Science in Midwifery
- ACCESS-Bachelor of Science in Nursing
- Bagumbayan-Bachelor in Technology and Livelihood Education major in Agri-fishery
- Bagumbayan-Bachelor of Science in Agribusiness
- Isulan-Bachelor in Technical Teacher Education major in: Automotive Technology
- Isulan-Bachelor in Technical-Vocational Teacher Education major in: Civil Technology
- Isulan-Bachelor in Technical-Vocational Teacher Education major in: Drafting Technology
- Isulan-Bachelor in Technical-Vocational Teacher Education major in: Electrical Technology
- Isulan-Bachelor in Technical-Vocational Teacher Education major in: Electronics Technology
- Isulan-Bachelor in Technical-Vocational Teacher Education major in: Food Service Management
- Isulan-Bachelor of Science in Civil Engineering
- Isulan-Bachelor of Science in Computer Engineering
- Isulan-Bachelor of Science in Computer Science
- Isulan-Bachelor of Science in Electronics Engineering
- Isulan-Bachelor of Science in Industrial Technology major in: Architectural Drafting Technology
- Isulan-Bachelor of Science in Industrial Technology major in: Automotive Technology
- Isulan-Bachelor of Science in Industrial Technology major in: Civil Technology
- Isulan-Bachelor of Science in Industrial Technology major in: Electrical Technology
- Isulan-Bachelor of Science in Industrial Technology major in: Electronics Technology
- Isulan-Bachelor of Science in Industrial Technology major in: Food Innovation and Culinary Technology
- Isulan-Bachelor of Science in Information System
- Isulan-Bachelor of Science in Information Technology
- Kalamansig-Bachelor in Elementary Education
- Kalamansig-Bachelor in Secondary Education major in: English
- Kalamansig-Bachelor in Secondary Education major in: Filipino
- Kalamansig-Bachelor in Secondary Education major in: Mathematics
- Kalamansig-Bachelor in Secondary Education major in: Science
- Kalamansig-Bachelor of Science in Biology
- Kalamansig-Bachelor of Science in Criminology
- Kalamansig-Bachelor of Science in Fisheries
- Kalamansig-Bachelor of Science in Information Technology
- Lutayan-Bachelor in Elementary Education
- Lutayan-Bachelor of Science in Agriculture
- No Preferred Program Identified
- Palimbang-Bachelor in Elementary Education
- Palimbang-Bachelor of Science in Agribusiness
- Tacurong-Bachelor of Arts in Economics
- Tacurong-Bachelor of Arts in Political Science
- Tacurong-Bachelor of Science in Accountancy
- Tacurong-Bachelor of Science in Accounting Information System
- Tacurong-Bachelor of Science in Biology
- Tacurong-Bachelor of Science in Entrepreneurship
- Tacurong-Bachelor of Science in Environmental Science
- Tacurong-Bachelor of Science in Hospitality Management
- Tacurong-Bachelor of Science in Management Accounting
- Tacurong-Bachelor of Science in Tourism Management

</details>

---

## Data Validation & Edge Cases

| Issue                          | Details                                                                 |
| ------------------------------ | ----------------------------------------------------------------------- |
| Empty rows                     | 635 rows have no examinee name — skip these during import               |
| Formula cells                  | Column F may contain Excel `IF` formulas — resolve to cached values     |
| `#N/A` in Preferred Program    | Treat as `null` or `No Preferred Program Identified`                    |
| Standard Score range           | Observed range: approximately **200–800**                               |
| Stanine range                  | Always **1–9** (integer)                                                |
| Examinee Number                | 6-digit integer, appears unique per examinee                            |
| Columns Y–AE                   | Empty — ignore                                                          |
| Columns AF–AG                  | Separate reference list — not part of main data rows                    |

---

## Suggested CSV Conversion Format

If converting to CSV for import, the recommended flat structure is:

```csv
name,examinee_number,preferred_program,english_score,english_stanine,english_interpretation,science_score,science_stanine,science_interpretation,math_score,math_stanine,math_interpretation,filipino_score,filipino_stanine,filipino_interpretation,social_studies_score,social_studies_stanine,social_studies_interpretation,esm_score,esm_stanine,esm_interpretation,overall_score,overall_stanine,overall_interpretation
"Corbal, Precious Shane Acebes",509127,"Tacurong-Bachelor of Science in Biology",654,9,"Outstanding",800,9,"Outstanding",800,9,"Outstanding",704,9,"Outstanding",749,9,"Outstanding",800,9,"Outstanding",800,9,"Outstanding"
```

---

## Summary for Developer

1. **Read only the `Result` sheet.**
2. **Skip the first 2 rows** (headers) — data starts at **Row 3**.
3. **Import Columns A–X** (24 columns) as the main examinee data.
4. **Skip Columns Y–AE** (empty) and **Columns AF–AG** (reference lookup).
5. **Skip rows where Column A (Name) is empty.**
6. **Resolve formula cells** to their cached/computed values.
7. **Handle `#N/A`** in the Preferred Program column as null.
8. Total expected records after cleanup: **~8,937 examinees**.
