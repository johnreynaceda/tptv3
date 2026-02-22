# TPT Result 2026 - Deployment Guide

## Overview

This deployment adds the 2026 TPT Result page with:
- ESM Competency Score (English + Science + Math composite)
- Preferred Program field
- Campus-based cutoff scores (replacing the 2025 board/non-board cutoff design)
- Gray campus headers (#808080 bg, white text)
- Signature images (Prepared by, Interpreted by, Noted)
- Print-optimized layout (zoom: 0.7 for single-page print)
- Admin panel updated with ESM + Preferred Program columns
- Developer mode page for quick PDF lookup without login

All existing 2025 pages are **preserved untouched**.

---

## Branch Strategy

- **Server branch (current/stable):** `sksu_tptp_october_2025`
- **Update branch:** `oo1`

The `oo1` branch contains all 2026 result changes. After testing locally, push `oo1` then switch to it on the server.

---

## Pre-Deployment Checklist

- [ ] Backup the production database
- [ ] Ensure `docs/SKSU_TPT_RESULT_2026_CLEAN_V2.csv` is present in the repo
- [ ] Ensure signature images are in `public/images/signature/`
- [ ] Test locally: web view, print, PDF generation, admin panel

---

## Deployment Steps

### 1. Push from Local

```bash
# On your local machine (branch: oo1)
git add .
git commit -m "2026 TPT Result updates"
git push origin oo1
```

### 2. Switch Branch on Server

```bash
# SSH into server
ssh your-server

# Navigate to project
cd /var/www/tptv3

# Enable maintenance mode
php artisan down

# Fetch latest and switch to oo1 branch
git fetch origin
git checkout oo1
git pull origin oo1
```

### 3. Install Dependencies & Build

```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies and build assets
npm install
npm run production
```

### 4. Run Database Migration

> **IMPORTANT:** Do NOT run `php artisan migrate` bare — it may execute other pending migrations you don't want. Always target this specific migration file:

```bash
php artisan migrate --path=database/migrations/2026_02_22_000000_add_esm_and_preferred_program_to_results_table.php
```

To preview first without making changes:
```bash
php artisan migrate --path=database/migrations/2026_02_22_000000_add_esm_and_preferred_program_to_results_table.php --pretend
```

This adds 3 nullable columns to the `results` table:
- `preferred_program` (after `full_name`)
- `esm_raw_score` (after `social_studies_standard_score`)
- `esm_standard_score` (after `esm_raw_score`)

Existing rows get `NULL` for all 3 columns. No data loss.

### 5. Import CSV Data

Import `docs/SKSU_TPT_RESULT_2026_CLEAN_V2.csv` into the `results` table using TablePlus (or any DB tool).

**Column mapping:**

| CSV Column | DB Column |
|---|---|
| examination_id | examination_id |
| examinee_number | examinee_number |
| full_name | full_name |
| preferred_program | preferred_program |
| math_raw_score | math_raw_score |
| math_standard_score | math_standard_score |
| english_raw_score | english_raw_score |
| english_standard_score | english_standard_score |
| filipino_raw_score | filipino_raw_score |
| filipino_standard_score | filipino_standard_score |
| science_raw_score | science_raw_score |
| science_standard_score | science_standard_score |
| social_studies_raw_score | social_studies_raw_score |
| social_studies_standard_score | social_studies_standard_score |
| esm_raw_score | esm_raw_score |
| esm_standard_score | esm_standard_score |
| total_raw_score | total_raw_score |
| total_standard_score | total_standard_score |

**Important:** Set the `examination_id` column to the correct 2026 examination ID before importing.

### 6. Enable Results Visibility

In the `examinations` table, set `show_results = 1` for the 2026 examination record.

### 7. Ensure Signature Images Exist

Verify these files exist in `public/images/signature/`:
- `john-michael.png` (JAN MICHAEL B. SALDICAYA - Prepared by)
- `mark.png` (MARK F. ONIA - Interpreted by)
- `bacera.png` (JOSELYN H. BACERA - Noted)

### 8. Clear Cache & Go Live

```bash
# Clear and rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Disable maintenance mode
php artisan up
```

---

## Quick Deploy Summary

```bash
# Local
git push origin oo1

# Server
ssh your-server
cd /var/www/tptv3
php artisan down
git fetch origin && git checkout oo1 && git pull origin oo1
composer install --optimize-autoloader --no-dev
npm install && npm run production
php artisan migrate --path=database/migrations/2026_02_22_000000_add_esm_and_preferred_program_to_results_table.php
php artisan config:cache && php artisan route:cache && php artisan view:cache
php artisan up
```

---

## Verification

1. **Migration**: Confirm 3 new nullable columns on `results` table
2. **CSV Import**: Confirm `esm_raw_score`, `esm_standard_score`, `preferred_program` are populated for 2026 rows
3. **Web View**: Login as applicant -> `/applicant/result` -> verify 2026 layout with ESM row and campus cutoffs
4. **Print**: Test Print button -> verify print layout fits A4 (single page with zoom)
5. **PDF**: Test `/tpt-result-2026/{examinee_number}` -> verify PDF renders with signatures and campus headers
6. **Admin Table**: `/admin/examination-results/{id}` -> verify ESM Score and Preferred Program columns show
7. **Admin View Details**: Opens new 2026 layout at `/test-result-2026/{examinee_number}`
8. **Admin Generate PDF**: Uses 2026 PDF route with signatures and campus headers
9. **Developer Mode**: Visit `/developer-mode` -> enter examinee number -> downloads PDF

---

## Files Changed

| Action | File |
|--------|------|
| CREATE | `database/migrations/2026_02_22_000000_add_esm_and_preferred_program_to_results_table.php` |
| CREATE | `docs/SKSU_TPT_RESULT_2026_CLEAN_V2.csv` |
| CREATE | `resources/views/applicant/result-2026.blade.php` |
| CREATE | `resources/views/result-pdf-2026.blade.php` |
| CREATE | `resources/views/livewire/result/score-result-2026.blade.php` |
| CREATE | `resources/views/livewire/result/score-guide-2026.blade.php` |
| CREATE | `resources/views/developer-mode.blade.php` |
| CREATE | `public/images/signature/john-michael.png` |
| CREATE | `public/images/signature/mark.png` |
| CREATE | `public/images/signature/bacera.png` |
| MODIFY | `routes/web.php` - applicant result route, PDF route, developer-mode route |
| MODIFY | `app/Http/Controllers/ResultController.php` - add `result2026()` |
| MODIFY | `app/Http/Livewire/Result/ScoreResult.php` - conditionally render 2026 view |
| MODIFY | `app/Http/Livewire/Result/ScoreGuide.php` - conditionally render 2026 view |
| MODIFY | `resources/views/livewire/examination-result-page.blade.php` - add ESM/Preferred Program columns, update routes |
| MODIFY | `resources/views/livewire/examinee-result-details.blade.php` - update to 2026 (ESM, preferred program, year) |

---

## Key URLs

| URL | Description |
|-----|-------------|
| `/test-result-2026/{examinee_number}` | Web view (2026 layout) |
| `/tpt-result-2026/{examinee_number}` | PDF download |
| `/admin/examination-results/{id}` | Admin results table |
| `/developer-mode` | Quick PDF lookup (no login required) |

---

## Rollback

If you need to revert back to the stable branch:

```bash
# On server
php artisan down
git checkout sksu_tptp_october_2025
php artisan migrate:rollback   # drops the 3 new columns
php artisan config:cache && php artisan route:cache && php artisan view:cache
php artisan up
```

The 2025 views are untouched and will continue to work.
