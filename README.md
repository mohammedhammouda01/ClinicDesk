# ClinicDesk — Clinic Management System

**Student:** Mohammed Hammouda  
**Student ID:** 120230487  
**Course:** Web Development — Islamic University of Gaza

---

## Project Overview

ClinicDesk is a web-based clinic management system built with PHP using the MVC (Model-View-Controller) architectural pattern. It allows administrators, doctors, and patients to manage appointments, prescriptions, and clinic operations through a clean and role-based dashboard interface.

The system is powered by a plain PHP routing mechanism (no framework), a MySQL database via XAMPP, and an AdminLTE Bootstrap 4 admin template for the UI.

---

## Features

- **Role-based access control** — Admin, Doctor, and Patient roles each have their own dashboard and permissions
- **Appointment management** — Patients can book appointments; doctors and admins can view and update their status
- **Doctor management** — Admins can manage doctor profiles, specializations, and photos
- **Prescription management** — Doctors can add prescriptions linked to appointments; patients can download them as PDF
- **User management** — Admins can create, edit, and activate/deactivate user accounts
- **Reports** — Admin report view with clinic statistics
- **CSRF protection** — All forms are protected against Cross-Site Request Forgery
- **Pagination** — Built-in paginator for large data sets
- **Session-based authentication** — Secure login with session timeout

---

## Project Structure

```
clinicdesk/
├── config/
│   ├── config.php          # App settings (name, base URL, session, limits)
│   └── database.php        # DB credentials (host, name, user, password)
│
├── core/
│   ├── Auth.php            # Session auth helper (login, logout, role checks)
│   ├── CSRF.php            # CSRF token generation and validation
│   ├── Database.php        # PDO database connection singleton
│   ├── Paginator.php       # Pagination logic
│   └── helpers.php         # Shared utility functions
│
├── controllers/
│   ├── AuthController.php          # Login / logout
│   ├── DashboardController.php     # Role-based dashboard routing
│   ├── UserController.php          # User CRUD (admin only)
│   ├── DoctorController.php        # Doctor profile management
│   ├── AppointmentController.php   # Book, view, update appointments
│   ├── PrescriptionController.php  # Add and download prescriptions
│   └── ReportController.php        # Clinic statistics report
│
├── models/
│   ├── BaseModel.php           # Shared DB query methods
│   ├── UserModel.php           # Users table queries
│   ├── DoctorModel.php         # Doctors table queries
│   ├── AppointmentModel.php    # Appointments table queries
│   ├── PrescriptionModel.php   # Prescriptions table queries
│   └── SpecializationModel.php # Specializations table queries
│
├── views/
│   ├── auth/           # Login page
│   ├── dashboard/      # Admin, Doctor, Patient dashboards
│   ├── appointments/   # Book, list, view appointments
│   ├── doctors/        # Doctor list, profile, edit
│   ├── prescriptions/  # Add prescription, list
│   ├── users/          # User create, edit, list
│   ├── reports/        # Reports page
│   ├── partials/       # Shared layout: header, footer, navbar, sidebar, alerts
│   └── errors/         # 403 and 404 error pages
│
├── public/
│   ├── assets/adminlte/    # AdminLTE + Bootstrap 4 + plugins
│   └── uploads/
│       ├── avatars/        # User profile pictures
│       ├── doctor_photos/  # Doctor photos
│       └── prescriptions/  # Uploaded prescription PDFs
│
├── index.php       # Main router — handles all page/action requests
└── .htaccess       # URL rewriting rules
```

---

## Architecture — MVC Pattern

The project follows the **MVC pattern** manually without a framework:

- **Model** — handles all database queries using PDO (in `/models`)
- **View** — PHP HTML templates rendered by controllers (in `/views`)
- **Controller** — receives the request, calls the model, passes data to the view (in `/controllers`)

Routing is handled by `index.php` using `$_GET['page']` and `$_GET['action']` parameters with a `switch/match` structure.

Example URL: `http://localhost/clinicdesk/?page=appointments&action=book`

---

## Technologies Used

| Technology | Purpose |
|---|---|
| PHP 8+ | Backend logic |
| MySQL | Database |
| XAMPP | Local server (Apache + MySQL) |
| PDO | Database access layer |
| AdminLTE 3 | Admin UI template |
| Bootstrap 4 | CSS framework |
| jQuery / DataTables | Frontend interactivity |

---

## Installation & Setup

### Requirements

- XAMPP (PHP 8+, Apache, MySQL)
- A browser

### Steps

**1. Clone or copy the project**

Place the `clinicdesk` folder inside your XAMPP `htdocs` directory:
```
C:/xampp/htdocs/clinicdesk        (Windows)
/Applications/XAMPP/htdocs/clinicdesk  (macOS)
```

**2. Start XAMPP**

Open the XAMPP Control Panel and start **Apache** and **MySQL**.

**3. Create the database**

Open `http://localhost/phpmyadmin` in your browser, create a new database named:
```
clinicdesk_db
```
Then import the SQL file (if provided) or run the schema manually.

**4. Configure the database**

Open `config/database.php` and verify the credentials match your XAMPP setup:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'clinicdesk_db');
define('DB_USER', 'root');
define('DB_PASS', '');
```

**5. Configure the base URL**

Open `config/config.php` and set:
```php
define('BASE_URL', 'http://localhost/clinicdesk');
```

**6. Run the application**

Open your browser and go to:
```
http://localhost/clinicdesk
```

---

## User Roles

| Role | Access |
|---|---|
| **Admin** | Full access — users, doctors, appointments, reports |
| **Doctor** | Own appointments, add prescriptions, view profile |
| **Patient** | Book appointments, view own appointments and prescriptions |

---

## Security Features

- Passwords hashed with `password_hash()` / verified with `password_verify()`
- CSRF tokens on all forms (generated and validated via `core/CSRF.php`)
- Session-based authentication with 1-hour timeout
- Role-based access enforcement in every controller
- File uploads restricted by type and size (avatars: 1MB, PDFs: 3MB)
- Prescription files protected from direct access via `.htaccess`

---

## Notes

- This project was built and tested locally using **XAMPP on macOS**
- The `BASE_URL` in `config/config.php` must match your local setup for links and redirects to work correctly
- The `public/uploads/` directories must be writable by Apache for file uploads to work
