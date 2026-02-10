# TPT System Architecture

**Version 1.0 | February 2026**

---

## Table of Contents

1. [Overview](#1-overview)
2. [Technology Stack](#2-technology-stack)
3. [Application Architecture](#3-application-architecture)
4. [Directory Structure](#4-directory-structure)
5. [Authentication Flow](#5-authentication-flow)
6. [Application Workflow](#6-application-workflow)
7. [Component Architecture](#7-component-architecture)
8. [Data Flow](#8-data-flow)
9. [Security Considerations](#9-security-considerations)

---

## 1. Overview

The TPT (Tertiary Placement Test) Examination System is a web-based application built using the Laravel framework with Livewire for reactive UI components. The system manages the complete examination lifecycle from student registration to result publication.

### Key Features

- Google OAuth Authentication
- Multi-step Application Process
- Payment Verification System
- Test Center & Slot Management
- Automated Permit Generation
- Result Management & Publication
- Report Generation

---

## 2. Technology Stack

### Backend

| Component | Technology | Version |
|-----------|------------|---------|
| Framework | Laravel | 9.x |
| PHP | PHP | 8.2+ |
| Database | MySQL | 8.0+ |
| Queue | Laravel Jobs | - |
| Authentication | Laravel Fortify + Jetstream | - |
| OAuth | Laravel Socialite (Google) | - |

### Frontend

| Component | Technology | Version |
|-----------|------------|---------|
| UI Framework | Livewire | 2.x |
| CSS Framework | Tailwind CSS | 3.x |
| JavaScript | Alpine.js | 3.x |
| UI Components | WireUI | 1.x |
| Icons | Heroicons | - |

### Infrastructure

| Component | Technology |
|-----------|------------|
| Web Server | Apache/Nginx |
| Cache | File/Redis |
| Session | Database |
| File Storage | Local/S3 |

---

## 3. Application Architecture

### Figure 6.1 – System Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                                                                             │
│                            ┌─────────────────┐                              │
│                            │   WEB BROWSER   │                              │
│                            │    (Client)     │                              │
│                            └────────┬────────┘                              │
│                                     │                                       │
│                              HTTP/HTTPS Request                             │
│                                     │                                       │
│                                     ▼                                       │
│  ┌──────────────────────────────────────────────────────────────────────┐  │
│  │                         PRESENTATION LAYER                           │  │
│  │  ┌────────────────────────────────────────────────────────────────┐  │  │
│  │  │                      Blade Templates                           │  │  │
│  │  │  ┌──────────────┐  ┌──────────────┐  ┌──────────────────────┐  │  │  │
│  │  │  │  Admin Layout │  │  Applicant   │  │   Guest Layout       │  │  │  │
│  │  │  │              │  │   Layout     │  │                      │  │  │  │
│  │  │  └──────────────┘  └──────────────┘  └──────────────────────┘  │  │  │
│  │  └────────────────────────────────────────────────────────────────┘  │  │
│  │  ┌────────────────────────────────────────────────────────────────┐  │  │
│  │  │                    Frontend Technologies                       │  │  │
│  │  │     Livewire  │  Alpine.js  │  Tailwind CSS  │  WireUI         │  │  │
│  │  └────────────────────────────────────────────────────────────────┘  │  │
│  └──────────────────────────────────────────────────────────────────────┘  │
│                                     │                                       │
│                                     ▼                                       │
│  ┌──────────────────────────────────────────────────────────────────────┐  │
│  │                         APPLICATION LAYER                            │  │
│  │                                                                      │  │
│  │  ┌─────────────┐  ┌─────────────────┐  ┌─────────────────────────┐  │  │
│  │  │   Routes    │  │   Middleware    │  │  Livewire Components    │  │  │
│  │  │  (web.php)  │─▶│  - Authentication│─▶│  - Admin Dashboard     │  │  │
│  │  │             │  │  - Role Check   │  │  - Applications Table  │  │  │
│  │  │             │  │  - Step Control │  │  - Payment Management  │  │  │
│  │  │             │  │                 │  │  - Slot Selection      │  │  │
│  │  │             │  │                 │  │  - Result Viewing      │  │  │
│  │  └─────────────┘  └─────────────────┘  └─────────────────────────┘  │  │
│  │                                                                      │  │
│  │  ┌─────────────────────────────────────────────────────────────┐    │  │
│  │  │                    Services & Exports                       │    │  │
│  │  │  Mail Service  │  Excel Export  │  PDF Generation           │    │  │
│  │  └─────────────────────────────────────────────────────────────┘    │  │
│  └──────────────────────────────────────────────────────────────────────┘  │
│                                     │                                       │
│                                     ▼                                       │
│  ┌──────────────────────────────────────────────────────────────────────┐  │
│  │                           DOMAIN LAYER                               │  │
│  │                                                                      │  │
│  │  ┌─────────────────────────────────────────────────────────────┐    │  │
│  │  │                     Eloquent Models                         │    │  │
│  │  │                                                             │    │  │
│  │  │  ┌─────────┐ ┌─────────────┐ ┌───────────┐ ┌─────────────┐ │    │  │
│  │  │  │  User   │ │ Application │ │Examination│ │   Permit    │ │    │  │
│  │  │  └─────────┘ └─────────────┘ └───────────┘ └─────────────┘ │    │  │
│  │  │  ┌─────────┐ ┌─────────────┐ ┌───────────┐ ┌─────────────┐ │    │  │
│  │  │  │ Payment │ │ TestCenter  │ │   Slot    │ │StudentSlot  │ │    │  │
│  │  │  └─────────┘ └─────────────┘ └───────────┘ └─────────────┘ │    │  │
│  │  │  ┌─────────┐ ┌─────────────┐ ┌───────────┐ ┌─────────────┐ │    │  │
│  │  │  │ Program │ │   Campus    │ │  Result   │ │   Proof     │ │    │  │
│  │  │  └─────────┘ └─────────────┘ └───────────┘ └─────────────┘ │    │  │
│  │  └─────────────────────────────────────────────────────────────┘    │  │
│  └──────────────────────────────────────────────────────────────────────┘  │
│                                     │                                       │
│                                     ▼                                       │
│  ┌──────────────────────────────────────────────────────────────────────┐  │
│  │                       INFRASTRUCTURE LAYER                           │  │
│  │                                                                      │  │
│  │  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────────┐  │  │
│  │  │  MySQL Database │  │  File Storage   │  │   External APIs     │  │  │
│  │  │                 │  │                 │  │                     │  │  │
│  │  │  - users        │  │  - Proof Images │  │  - Google OAuth     │  │  │
│  │  │  - applications │  │  - Profile      │  │  - Mail Service     │  │  │
│  │  │  - examinations │  │    Photos       │  │    (SMTP)           │  │  │
│  │  │  - permits      │  │  - Documents    │  │                     │  │  │
│  │  │  - payments     │  │                 │  │                     │  │  │
│  │  │  - slots        │  │                 │  │                     │  │  │
│  │  │  - results      │  │                 │  │                     │  │  │
│  │  └─────────────────┘  └─────────────────┘  └─────────────────────┘  │  │
│  └──────────────────────────────────────────────────────────────────────┘  │
│                                                                             │
│                     LARAVEL 9.x + PHP 8.2 FRAMEWORK                         │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘

                    Figure 6.1 – System Architecture Diagram
```

**Description:** The TPT Examination System follows a layered architecture pattern built on the Laravel framework. The system is organized into four distinct layers:

1. **Presentation Layer** - Handles user interface rendering using Blade templates with Livewire for reactive components, Alpine.js for client-side interactivity, and Tailwind CSS for styling.

2. **Application Layer** - Contains the business logic including route definitions, middleware for authentication and authorization, and Livewire components that handle user interactions.

3. **Domain Layer** - Houses the Eloquent ORM models that represent the business entities and their relationships.

4. **Infrastructure Layer** - Manages data persistence through MySQL, file storage for uploaded documents, and external service integrations including Google OAuth and email services.

---

### MVC + Livewire Pattern

```
┌─────────────────────────────────────────────────────────────────┐
│                         CLIENT BROWSER                          │
├─────────────────────────────────────────────────────────────────┤
│  Alpine.js  │  Tailwind CSS  │  WireUI Components  │  Livewire │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                      LARAVEL APPLICATION                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────────┐ │
│  │   Routes    │  │ Middleware  │  │   Livewire Components   │ │
│  │  (web.php)  │──▶│  (Auth,     │──▶│  - Admin/*             │ │
│  │             │  │   Steps)    │  │  - Applicant/*          │ │
│  └─────────────┘  └─────────────┘  └───────────┬─────────────┘ │
│                                                 │               │
│                                                 ▼               │
│  ┌─────────────────────────────────────────────────────────────┐│
│  │                    ELOQUENT MODELS                          ││
│  │  User, Application, Examination, Permit, Payment, etc.      ││
│  └───────────────────────────┬─────────────────────────────────┘│
│                              │                                  │
└──────────────────────────────┼──────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────┐
│                      MySQL DATABASE                             │
│  users, applications, examinations, permits, payments, etc.     │
└─────────────────────────────────────────────────────────────────┘
```

### Layered Architecture

```
┌─────────────────────────────────────────┐
│           PRESENTATION LAYER            │
│  Blade Views, Livewire Components       │
│  layouts/, components/, livewire/       │
├─────────────────────────────────────────┤
│           APPLICATION LAYER             │
│  Controllers, Livewire, Middleware      │
│  Http/Controllers, Http/Livewire        │
├─────────────────────────────────────────┤
│             DOMAIN LAYER                │
│  Models, Business Logic                 │
│  Models/, Services/                     │
├─────────────────────────────────────────┤
│          INFRASTRUCTURE LAYER           │
│  Database, File Storage, Mail           │
│  Migrations, Storage, Mail/             │
└─────────────────────────────────────────┘
```

---

## 4. Directory Structure

```
tptv3/
├── app/
│   ├── Exports/                    # Excel export classes
│   │   ├── UsersWithoutSlotExport.php
│   │   ├── UsersWithPermitAndSlotExport.php
│   │   └── ...
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Admin controllers
│   │   │   └── Applicant/          # Applicant controllers
│   │   ├── Livewire/
│   │   │   ├── Admin/              # Admin Livewire components
│   │   │   │   ├── Applications/
│   │   │   │   ├── Dashboard.php
│   │   │   │   ├── Monitoring.php
│   │   │   │   └── ...
│   │   │   ├── Applicant/          # Applicant Livewire components
│   │   │   │   ├── Application/
│   │   │   │   ├── SelectTestingCenter.php
│   │   │   │   └── ...
│   │   │   └── Result/             # Result-related components
│   │   └── Middleware/
│   │       ├── StepOne.php         # Step-based access control
│   │       ├── StepTwo.php
│   │       ├── StepThree.php
│   │       ├── StepFour.php
│   │       └── StepFive.php
│   ├── Mail/                       # Email templates
│   │   ├── PaymentApproved.php
│   │   └── PaymentRejected.php
│   └── Models/                     # Eloquent models
│       ├── User.php
│       ├── Application.php
│       ├── Examination.php
│       └── ...
├── database/
│   ├── migrations/                 # Database migrations
│   └── seeders/                    # Database seeders
├── resources/
│   └── views/
│       ├── components/
│       │   └── layout/
│       │       ├── admin.blade.php
│       │       ├── applicant.blade.php
│       │       └── ordinary.blade.php
│       ├── layouts/
│       │   ├── app.blade.php
│       │   └── guest.blade.php
│       └── livewire/
│           ├── admin/
│           └── applicant/
├── routes/
│   └── web.php                     # Web routes
├── public/
│   ├── css/app.css                 # Compiled CSS
│   └── js/app.js                   # Compiled JS
└── docs/
    └── developer/                  # Developer documentation
```

---

## 5. Authentication Flow

### Google OAuth Flow

```
┌─────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────┐
│  User   │     │  TPT App    │     │   Google    │     │ Database│
└────┬────┘     └──────┬──────┘     └──────┬──────┘     └────┬────┘
     │                 │                   │                  │
     │  Click Login    │                   │                  │
     │────────────────▶│                   │                  │
     │                 │                   │                  │
     │                 │  Redirect OAuth   │                  │
     │                 │──────────────────▶│                  │
     │                 │                   │                  │
     │                 │   Auth Consent    │                  │
     │◀────────────────────────────────────│                  │
     │                 │                   │                  │
     │  Grant Access   │                   │                  │
     │────────────────────────────────────▶│                  │
     │                 │                   │                  │
     │                 │  Auth Code        │                  │
     │                 │◀──────────────────│                  │
     │                 │                   │                  │
     │                 │  Exchange Token   │                  │
     │                 │──────────────────▶│                  │
     │                 │                   │                  │
     │                 │  User Info        │                  │
     │                 │◀──────────────────│                  │
     │                 │                   │                  │
     │                 │  Create/Update User                  │
     │                 │─────────────────────────────────────▶│
     │                 │                   │                  │
     │  Logged In      │                   │                  │
     │◀────────────────│                   │                  │
     │                 │                   │                  │
```

### Role-Based Access

| Role ID | Role Name | Access Level |
|---------|-----------|--------------|
| 1 | Admin | Full system access |
| 2 | Applicant | Student/applicant access |

---

## 6. Application Workflow

### User Step Progression

```
┌─────────────────────────────────────────────────────────────────┐
│                    USER APPLICATION FLOW                        │
└─────────────────────────────────────────────────────────────────┘

  Step 1              Step 2              Step 3
┌─────────┐        ┌─────────┐        ┌─────────┐
│  Login  │───────▶│  Fill   │───────▶│ Payment │
│  /OAuth │        │  Forms  │        │ Submit  │
└─────────┘        └─────────┘        └─────────┘
                        │
          ┌─────────────┼─────────────┐
          ▼             ▼             ▼
    ┌──────────┐  ┌──────────┐  ┌──────────┐
    │ Personal │  │  School  │  │ Program  │
    │   Info   │  │   Info   │  │ Choices  │
    └──────────┘  └──────────┘  └──────────┘


  Step 4              Step 5
┌─────────┐        ┌─────────┐
│ Select  │───────▶│  View   │
│  Slot   │        │ Permit  │
└─────────┘        └─────────┘
     │                  │
     │                  ▼
     │            ┌─────────┐
     │            │  View   │
     └───────────▶│ Results │
                  └─────────┘
```

### Step Middleware Mapping

| Step | Value | Route Pattern | Middleware | Description |
|------|-------|---------------|------------|-------------|
| 1 | '1' | /applicant/home | step_one | Initial state |
| 2 | '2' | /applicant/fill/* | step_two | Fill application |
| 3 | '3' | /applicant/payment | step_three | Submit payment |
| 4 | '4' | /applicant/select-test-center | step_four | Select exam slot |
| 5 | '5' | /applicant/permit | step_five | View permit/results |

---

## 7. Component Architecture

### Admin Livewire Components

```
app/Http/Livewire/Admin/
├── Dashboard.php                # Admin dashboard with statistics
├── Applications/
│   └── Table.php                # Applications management table
├── Examinations/
│   └── Table.php                # Examinations CRUD
├── Monitoring.php               # Real-time slot monitoring
├── Programs/
│   └── Table.php                # Programs management
├── Campuses/
│   └── Table.php                # Campuses management
├── Users/
│   └── Table.php                # Users management
└── Reports/                     # Report generation
    ├── ResultReport.php
    ├── RankingReport.php
    └── QualifiedStudentsReport.php
```

### Applicant Livewire Components

```
app/Http/Livewire/Applicant/
├── Home.php                     # Applicant home/landing
├── Application/
│   ├── PersonalInformation.php  # Step 2a - Personal info form
│   ├── SchoolInformation.php    # Step 2b - School info form
│   └── ProgramChoices.php       # Step 2c - Program selection
├── Payment.php                  # Step 3 - Payment submission
├── SelectTestingCenter.php      # Step 4 - Slot selection
├── Permit.php                   # Step 5 - View permit
└── ViewResult.php               # View examination results
```

### Component Communication

```
┌─────────────────────────────────────────────────────────────────┐
│                   LIVEWIRE COMPONENT                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌─────────────┐    ┌─────────────┐    ┌─────────────────────┐ │
│  │  Properties │◀──▶│   Methods   │◀──▶│   Blade Template    │ │
│  │  (State)    │    │  (Actions)  │    │   (View)            │ │
│  └─────────────┘    └─────────────┘    └─────────────────────┘ │
│         │                 │                      │              │
│         │    wire:model   │    wire:click        │              │
│         │◀───────────────▶│◀────────────────────▶│              │
│         │                 │                      │              │
│  ┌──────┴──────┐   ┌──────┴──────┐                             │
│  │   Emits     │   │  Listeners  │                             │
│  │   Events    │   │   Events    │                             │
│  └─────────────┘   └─────────────┘                             │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## 8. Data Flow

### Payment Approval Flow

```
┌─────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────┐
│Applicant│     │   Payment   │     │    Admin    │     │  Permit │
└────┬────┘     └──────┬──────┘     └──────┬──────┘     └────┬────┘
     │                 │                   │                  │
     │ Submit Payment  │                   │                  │
     │────────────────▶│                   │                  │
     │                 │                   │                  │
     │                 │  Pending Review   │                  │
     │                 │──────────────────▶│                  │
     │                 │                   │                  │
     │                 │                   │  Review          │
     │                 │                   │  Approve/Reject  │
     │                 │                   │                  │
     │                 │◀──────────────────│                  │
     │                 │   Status Update   │                  │
     │                 │                   │                  │
     │                 │                   │  If Approved     │
     │                 │                   │─────────────────▶│
     │                 │                   │  Generate Permit │
     │                 │                   │                  │
     │  Email Notify   │                   │                  │
     │◀────────────────│                   │                  │
     │                 │                   │                  │
```

### Slot Selection Flow

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│  User       │     │  Slot       │     │ StudentSlot │
│  (Step 4)   │     │  Available  │     │  Created    │
└──────┬──────┘     └──────┬──────┘     └──────┬──────┘
       │                   │                   │
       │  View Slots       │                   │
       │──────────────────▶│                   │
       │                   │                   │
       │  ◀────────────────│                   │
       │  Show Available   │                   │
       │                   │                   │
       │  Select Slot      │                   │
       │──────────────────▶│                   │
       │                   │                   │
       │                   │  Validate         │
       │                   │  - Room Capacity  │
       │                   │  - Slot Active    │
       │                   │                   │
       │                   │  Create Record    │
       │                   │──────────────────▶│
       │                   │                   │
       │                   │  Assign           │
       │                   │  - Room Number    │
       │                   │  - Seat Number    │
       │                   │                   │
       │  User → Step 5    │                   │
       │◀──────────────────│                   │
       │                   │                   │
```

---

## 9. Security Considerations

### Authentication & Authorization

- **Google OAuth**: Single sign-on via Google accounts
- **CSRF Protection**: Laravel's built-in CSRF tokens
- **Role-based Access**: Admin vs Applicant roles
- **Step Middleware**: Prevents users from accessing steps out of order

### Data Protection

- **Password Hashing**: bcrypt for any local passwords
- **SQL Injection Prevention**: Eloquent ORM parameterized queries
- **XSS Prevention**: Blade auto-escaping
- **File Upload Validation**: MIME type and size restrictions

### Session Security

```php
// config/session.php
'driver' => 'database',
'lifetime' => 120,
'expire_on_close' => false,
'encrypt' => false,
'secure' => env('SESSION_SECURE_COOKIE', true),
'same_site' => 'lax',
```

### Middleware Stack

```
┌─────────────────────────────────────────┐
│           Global Middleware             │
│  - EncryptCookies                       │
│  - AddQueuedCookiesToResponse           │
│  - StartSession                         │
│  - ShareErrorsFromSession               │
│  - VerifyCsrfToken                      │
├─────────────────────────────────────────┤
│           Route Middleware              │
│  - auth (authentication)                │
│  - admin (admin role check)             │
│  - step_one through step_five           │
└─────────────────────────────────────────┘
```

---

## Appendix: Environment Configuration

### Required Environment Variables

```env
# Application
APP_NAME="TPT Examination System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tpt_latest
DB_USERNAME=root
DB_PASSWORD=

# Google OAuth
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=https://your-domain.com/auth/google/callback

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=noreply@example.com
```

---

**End of System Architecture Document**

*Document Version: 1.0*
*Last Updated: February 2026*
