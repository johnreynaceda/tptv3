# TPT (Tagbilaran Polytechnic Test) - Examination Management System

## Project Overview

TPT is a comprehensive web-based Examination Management System built with Laravel 9 for managing student applications, entrance examinations, payments, slot assignments, and result management for educational institutions.

**Project Name:** TPT v3 (Tagbilaran Polytechnic Test Version 3)
**Framework:** Laravel 9.11+
**PHP Version:** 8.0.2+
**Frontend:** Livewire 2.5+ with Alpine.js 3.x and Tailwind CSS 3.1+

---

## Table of Contents

1. [System Requirements](#system-requirements)
2. [Installation Guide](#installation-guide)
3. [Project Structure](#project-structure)
4. [Database Schema](#database-schema)
5. [User Roles & Authentication](#user-roles--authentication)
6. [Application Flow](#application-flow)
7. [Features Overview](#features-overview)
8. [API Reference](#api-reference)
9. [Configuration](#configuration)
10. [Deployment](#deployment)

---

## System Requirements

### Server Requirements
- PHP >= 8.0.2
- MySQL 5.7+ or MariaDB 10.3+
- Composer 2.x
- Node.js 16+ and NPM
- Puppeteer (for PDF generation via Browsershot)

### PHP Extensions Required
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD PHP Extension (for image processing)
- Zip PHP Extension (for Excel exports)

---

## Installation Guide

### Step 1: Clone the Repository
```bash
git clone [repository-url]
cd tptv3
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Install Node Dependencies
```bash
npm install
```

### Step 4: Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

### Step 5: Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tptv3
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 6: Configure Google OAuth (Optional)
```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://your-domain.com/auth/google/callback
```

### Step 7: Configure Mail
```env
MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 8: Run Migrations & Seeders
```bash
php artisan migrate
php artisan db:seed
```

### Step 9: Create Storage Link
```bash
php artisan storage:link
```

### Step 10: Build Frontend Assets
```bash
npm run production
```

### Step 11: Start Development Server
```bash
php artisan serve
```

---

## Project Structure

```
tptv3/
├── app/
│   ├── Actions/                    # Fortify authentication actions
│   │   └── Fortify/
│   │       ├── CreateNewUser.php
│   │       ├── PasswordValidationRules.php
│   │       ├── ResetUserPassword.php
│   │       ├── UpdateUserPassword.php
│   │       └── UpdateUserProfileInformation.php
│   ├── Console/
│   │   └── Kernel.php             # Scheduled commands
│   ├── Exceptions/
│   │   └── Handler.php            # Exception handling
│   ├── Exports/                   # Excel export classes
│   │   ├── AllResultExport.php
│   │   ├── PermitReport.php
│   │   ├── QualifiedStudentsExport.php
│   │   ├── RegistrationDateExport.php
│   │   ├── ResultAllExport.php
│   │   ├── ResultPerProgramExport.php
│   │   ├── UserExport.php
│   │   ├── UserSheetExport.php
│   │   ├── UsersWithoutSlotExport.php
│   │   └── UsersWithPermitAndSlotExport.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── DashboardController.php
│   │   │   ├── Controller.php
│   │   │   ├── EmailController.php
│   │   │   ├── GoogleController.php
│   │   │   ├── HomeController.php
│   │   │   ├── PrintPermitController.php
│   │   │   ├── QueuedExportController.php
│   │   │   └── ResultController.php
│   │   ├── Livewire/              # Livewire components
│   │   │   ├── Admin/             # Admin panel components
│   │   │   ├── Applicant/         # Applicant form components
│   │   │   ├── Auth/              # Authentication components
│   │   │   └── Result/            # Result display components
│   │   └── Middleware/            # Custom middleware
│   ├── Imports/                   # Excel import classes
│   │   └── ExaminationResultImport.php
│   ├── Mail/                      # Mailable classes
│   │   ├── ApplicationRejected.php
│   │   └── ApplicationStatus.php
│   ├── Models/                    # Eloquent models (19 models)
│   └── Providers/                 # Service providers
├── config/                        # Configuration files
├── database/
│   ├── factories/                 # Model factories
│   ├── migrations/                # Database migrations (32 files)
│   └── seeders/                   # Database seeders
├── public/                        # Publicly accessible files
├── resources/
│   ├── css/                       # Stylesheets
│   ├── js/                        # JavaScript files
│   └── views/                     # Blade templates
├── routes/
│   ├── api.php                    # API routes
│   ├── web.php                    # Web routes
│   ├── channels.php               # Broadcasting channels
│   └── console.php                # Console commands
├── storage/                       # File storage
└── tests/                         # Test files
```

---

## Quick Reference Links

- [Database Schema](./DATABASE.md)
- [API Routes](./API.md)
- [User Flow & Processes](./USER_FLOW.md)
- [Admin Features](./ADMIN_FEATURES.md)
- [Technical Specifications](./TECHNICAL.md)
- [Deployment Guide](./DEPLOYMENT.md)

---

## Key Packages Used

### Production Dependencies
| Package | Version | Purpose |
|---------|---------|---------|
| laravel/framework | ^9.11 | Core Laravel framework |
| laravel/jetstream | ^2.8 | Authentication scaffolding |
| laravel/sanctum | ^2.14.1 | API token authentication |
| laravel/socialite | ^5.16 | Google OAuth integration |
| livewire/livewire | ^2.5 | Reactive UI components |
| wireui/wireui | ^1.7 | Tailwind UI component library |
| maatwebsite/excel | ^3.1 | Excel import/export |
| barryvdh/laravel-dompdf | ^3.0 | PDF generation (DOM) |
| spatie/browsershot | ^5.0 | PDF generation (Puppeteer) |
| milon/barcode | ^11.0 | QR code generation |
| spatie/laravel-db-snapshots | ^2.7 | Database snapshots |

### Development Dependencies
| Package | Version | Purpose |
|---------|---------|---------|
| barryvdh/laravel-debugbar | ^3.6 | Debug toolbar |
| fakerphp/faker | ^1.9.1 | Test data generation |
| phpunit/phpunit | ^9.5.10 | Testing framework |
| laravel/sail | ^1.0.1 | Docker development environment |

### Frontend Dependencies
| Package | Version | Purpose |
|---------|---------|---------|
| tailwindcss | ^3.1.0 | CSS framework |
| alpinejs | ^3.0.6 | Lightweight JavaScript framework |
| axios | ^0.25 | HTTP client |
| puppeteer | ^23.11.1 | Browser automation for PDF |

---

## Support & Maintenance

For technical support or to report issues, please contact the development team or create an issue in the project repository.

---

*Documentation Version: 1.0*
*Last Updated: February 2026*
