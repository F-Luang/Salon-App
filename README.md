# ✦ Petal Nails — Salon Management System

A complete Laravel-based management system for nail salons, covering login/auth, service management, appointment booking, and payment processing.

---

## Features

| Module | Features |
|---|---|
| **Login / Auth** | Email & password login, session handling, remember me, logout |
| **Services** | Add, view, edit, delete services (name, price, duration, description) |
| **Appointments** | Book appointments, select service, customer info, date/time, status tracking |
| **Payments** | Process payments, choose method (Cash/GCash/Maya/Card), history, printable receipt |

---

## Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+ (or MariaDB)
- Laravel 11

---

## Installation

### 1. Clone / copy the project

```bash
cd /your/projects/folder
# If starting fresh:
composer create-project laravel/laravel petal-nails
cd petal-nails
```

Then copy all the provided files into your Laravel project root, maintaining the directory structure.

---

### 2. Install dependencies

```bash
composer install
```

---

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials:

```env
DB_DATABASE=petal_nails
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

### 4. Create the database

```sql
CREATE DATABASE petal_nails CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### 5. Run migrations and seed

```bash
php artisan migrate
php artisan db:seed
```

This creates:
- Admin user: `admin@petalnails.com` / `password`
- 7 sample services
- 3 sample appointments with payment records

---

### 6. Start the development server

```bash
php artisan serve
```

Open: [http://localhost:8000](http://localhost:8000)

---

## File Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── AuthController.php          # Login, logout
│       ├── DashboardController.php     # Dashboard stats
│       ├── ServiceController.php       # CRUD for services
│       ├── AppointmentController.php   # CRUD for appointments
│       └── PaymentController.php       # Payment processing
├── Models/
│   ├── User.php
│   ├── Service.php
│   ├── Appointment.php
│   └── Payment.php

database/
├── migrations/
│   ├── ..._create_users_table.php
│   ├── ..._create_services_table.php
│   ├── ..._create_appointments_table.php
│   └── ..._create_payments_table.php
└── seeders/
    └── DatabaseSeeder.php

resources/views/
├── layouts/
│   └── app.blade.php                   # Master layout with sidebar
├── auth/
│   └── login.blade.php
├── dashboard/
│   └── index.blade.php
├── services/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── appointments/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── show.blade.php
│   └── edit.blade.php
└── payments/
    ├── index.blade.php
    └── show.blade.php                  # Printable receipt

routes/
└── web.php
```

---

## Database Schema

### `users`
| Column | Type | Notes |
|---|---|---|
| id | bigint | PK |
| name | string | |
| email | string | unique |
| password | string | hashed |

### `services`
| Column | Type | Notes |
|---|---|---|
| id | bigint | PK |
| name | string | e.g. Gel Manicure |
| price | decimal(10,2) | |
| duration | string | e.g. 1 hour |
| description | text | nullable |
| is_active | boolean | default true |

### `appointments`
| Column | Type | Notes |
|---|---|---|
| id | bigint | PK |
| customer_name | string | |
| customer_contact | string | |
| service_id | FK → services | |
| appointment_date | date | |
| appointment_time | time | |
| notes | text | nullable |
| status | enum | Pending, Confirmed, Done, Cancelled |

### `payments`
| Column | Type | Notes |
|---|---|---|
| id | bigint | PK |
| appointment_id | FK → appointments | |
| amount | decimal(10,2) | copied from service price |
| status | enum | Paid, Unpaid |
| payment_method | string | Cash, GCash, Maya, Card |
| paid_at | timestamp | nullable |
| notes | text | nullable |

---

## Routes

```
GET    /                          → login page
POST   /login                     → authenticate
POST   /logout                    → logout

GET    /dashboard                 → dashboard

GET    /services                  → list services
GET    /services/create           → add form
POST   /services                  → store
GET    /services/{id}/edit        → edit form
PUT    /services/{id}             → update
DELETE /services/{id}             → delete

GET    /appointments              → list
GET    /appointments/create       → booking form
POST   /appointments              → store
GET    /appointments/{id}         → detail view
GET    /appointments/{id}/edit    → edit form
PUT    /appointments/{id}         → update
DELETE /appointments/{id}         → delete

GET    /payments                  → payment history
GET    /payments/{id}             → receipt
POST   /payments/{id}/process     → mark as paid
POST   /payments/{id}/unpaid      → revert to unpaid
```

---

## Demo Login

```
Email:    admin@petalnails.com
Password: password
```

---

## Extending the System

Some ideas for future features:
- **Staff management** — assign appointments to specific nail technicians
- **Customer records** — track returning clients and their history
- **SMS notifications** — send booking confirmations via Twilio/Semaphore
- **Reports** — monthly/weekly revenue reports with export to PDF
- **Online booking** — public-facing booking page for customers
- **Inventory** — track nail polish and supply stock levels

---

## Tech Stack

- **Framework:** Laravel 11
- **Database:** MySQL
- **Frontend:** Blade templates (no build step required)
- **Auth:** Laravel built-in session authentication
- **Fonts:** DM Serif Display + DM Sans (Google Fonts)
