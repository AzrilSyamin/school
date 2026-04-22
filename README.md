# EduFlow — School Management System

> A modern, open-source school management system built with **Laravel 12**, **React 18**, and **Inertia.js**. Designed for Malaysian educational institutions with a full 5-tier role-based access control (RBAC) system.

---

## ✨ Features

EduFlow is designed around real school operations: course management, classroom assignment, subject ownership, student records, lecturer responsibilities, class representatives, and attendance tracking.

### Role-Based Access Control

The system includes a 5-tier role system with policy-based permissions:

| Role | Description |
|---|---|
| **Admin** | Full system access. |
| **Moderator** | Administrative access similar to Admin, but cannot manage Admin users/roles. |
| **Lecturer / Course Manager** | Lecturer promoted to manage one assigned course. |
| **Lecturer / Teacher** | Lecturer assigned to teach subjects in one or more classrooms/courses. |
| **Classrep** | Class representative who can record attendance within their allowed course/classroom scope. |
| **Student** | Basic student role with limited authenticated access. |

### Admin Features

- View dashboard statistics and system overview.
- Create, read, update, and delete courses.
- Assign a lecturer as **Course Manager** for a course.
- Create, read, update, and delete classrooms.
- Assign a **Classrep** to a classroom.
- Assign lecturers to teach specific subjects in specific classrooms.
- Create, read, update, and delete subjects/mata pelajaran.
- Create, read, update, and delete lecturers.
- Create, read, update, and delete students.
- View, create, and edit attendance records.
- Create, read, update, and delete users across all roles.
- Access system settings for logo, site title, favicon, and branding-related values.

### Moderator Features

- Similar administrative workflow to Admin.
- Manage courses, classrooms, subjects, lecturers, students, attendance, and users.
- Cannot create, edit, assign, or manage Admin-level users/roles.

### Course Manager Features

A Course Manager is a lecturer assigned as the manager of one course. One course can only have one manager.

- View courses they teach or manage.
- Manage classrooms within their assigned course.
- Manage subjects/mata pelajaran within their assigned course.
- Manage students within their assigned course.
- Create attendance for multiple classrooms under their managed course.
- Edit attendance only for subjects/classes they teach.
- View related academic records without gaining full system-wide admin access.

### Lecturer / Teacher Features

- View courses they teach.
- View classrooms related to their teaching assignments.
- View subjects/mata pelajaran related to their teaching assignments.
- View students in classrooms/courses they teach.
- Create attendance only for subjects they are assigned to teach.
- Edit attendance only for subjects they are assigned to teach.

### Classrep Features

- Record attendance for subjects within their allowed course/classroom scope.
- View attendance sessions relevant to their course/classroom scope.

### Academic & Attendance Management

- Course management with optional Course Manager assignment.
- Classroom management with course linking, Classrep assignment, and subject-teacher assignment.
- Subject/mata pelajaran management by course.
- Student profile management with classroom assignment.
- Session-based attendance grouped by subject, classroom, date, and recorder.
- Attendance filtering by date, classroom, and subject.
- Attendance detail pages for reviewing student attendance status.

### User, Email & Developer Features

- Login using email, username, or phone number.
- Account registration with inactive-by-default approval flow.
- Email verification with custom Malay email notification.
- Password reset with custom Malay email notification.
- Profile management with password update, account deletion, and profile picture upload.
- Smart search for users and lecturers using full-name matching, email, and username.
- Queue-ready notification system using Laravel queues.
- Development and production seeders.
- **47 automated tests** covering authentication, courses, classrooms, subjects, students, lecturers, attendance, and profile flows.

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | PHP 8.2+, Laravel 12 |
| **Frontend** | React 18, Inertia.js v2 |
| **Styling** | Tailwind CSS v4 |
| **Build Tool** | Vite 7 |
| **Database** | MySQL / SQLite |
| **Testing** | PHPUnit 11 |

---

## 📋 Requirements

Before you begin, ensure your system has the following installed:

- **PHP** >= 8.2 (with extensions: `pdo`, `mbstring`, `openssl`, `bcmath`, `tokenizer`, `xml`, `ctype`, `json`)
- **Composer** >= 2.x
- **Node.js** >= 18.x & **npm** >= 9.x
- **MySQL** >= 8.0 (or SQLite for local development)
- A working mail provider for production email delivery (SMTP by default)

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/azrilsyamin/school.git
cd school
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Configure Environment

Copy the example environment file and generate the application key:

```bash
cp .env.example .env
php artisan key:generate
```

For production, make sure these values are changed before the application goes live:

```env
APP_NAME=EduFlow
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### 5. Configure Database

Open the `.env` file and update the database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school
DB_USERNAME=root
DB_PASSWORD=your_password
```

> **Tip:** For quick local development using SQLite, set `DB_CONNECTION=sqlite` and create a blank database file with `touch database/database.sqlite`.

The project uses Laravel's database queue by default:

```env
QUEUE_CONNECTION=database
```

Keep this value unless you already know you want to use Redis, SQS, or another queue driver.

### 6. Run Database Migrations & Seeders

```bash
# For local development (includes dummy data):
php artisan migrate:fresh --seed

# For production (only essential data, no dummy data):
php artisan migrate --seed
```

### 7. Create Admin User (Production)

Once the database is migrated and seeded with essential data, create your first admin account:

```bash
php artisan make:admin
```

### 8. Create Storage Symlink

```bash
php artisan storage:link
```

This is required for uploaded profile pictures and other public storage files.

### 9. Build Frontend Assets

```bash
# For production:
npm run build

# For local development (with hot reload):
npm run dev
```

### 10. Start the Queue Worker

Several emails and notifications are queued, so they will not be sent until a queue worker is running:

```bash
php artisan queue:work
```

For local development, open another terminal and keep this command running while testing registration, email verification, password reset, and other email-related features.

---

## 🖥️ Running Locally

The easiest way to run the full development stack is using the built-in Composer script, which starts the Laravel server, queue worker, log viewer, and Vite dev server concurrently:

```bash
composer run dev
```

Alternatively, you can run them separately in different terminals:

```bash
# Terminal 1: Laravel development server
php artisan serve

# Terminal 2: Vite frontend dev server
npm run dev

# Terminal 3: Queue worker for queued emails/notifications
php artisan queue:work
```

The application will be available at **`http://localhost:8000`**.

---

## 📬 Email Configuration

Email is required for account verification, registration notifications, password reset links, and other system notifications.

By default, Laravel uses `MAIL_MAILER=log`, which only writes emails to the log file. This is useful for local development, but it will not send real emails in production.

### Local Development

You can keep the log mailer while developing:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="no-reply@example.test"
MAIL_FROM_NAME="${APP_NAME}"
```

For local SMTP testing, you may use tools such as Mailpit, Mailhog, or a sandbox SMTP provider.

### Production SMTP Example

Update your `.env` with real SMTP credentials from your email provider:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_SCHEME=tls
MAIL_FROM_ADDRESS="no-reply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

After changing mail settings in production, clear and rebuild cached configuration:

```bash
php artisan config:clear
php artisan config:cache
```

### API-Based Email Providers

This project ships with standard Laravel mail configuration only. If you want to use an API provider such as Mailgun, Postmark, Amazon SES, Resend, or another service, install the required Laravel/Symfony mailer package and add the provider-specific environment variables yourself.

Example only:

```env
MAIL_MAILER=postmark
POSTMARK_TOKEN=your-token
```

Do not add API credentials to the repository. Keep them in `.env` or your hosting provider's secret manager.

---

## ⚙️ Queue Worker & Cron Jobs

This project uses queued notifications. If the queue worker is not running, users may register successfully but never receive verification emails, password reset emails, or other queued notifications.

### Development

Run the queue worker manually:

```bash
php artisan queue:work
```

The `composer run dev` command already starts a queue listener together with the Laravel server and Vite.

### VPS / Dedicated Server

For production servers, run the worker with a process manager such as Supervisor or systemd so it restarts automatically.

Supervisor example:

```ini
[program:eduflow-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/eduflow/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/eduflow/storage/logs/worker.log
stopwaitsecs=3600
```

Restart workers after every deployment:

```bash
php artisan queue:restart
```

### Shared Hosting

Many shared hosting providers do not allow long-running processes. In that case, add a cron job that runs the queue for a short time and exits.

Cron example, every minute:

```cron
* * * * * cd /home/username/path-to-project && /usr/local/bin/php artisan queue:work --stop-when-empty --tries=3 >> /dev/null 2>&1
```

Adjust the PHP path and project path based on your hosting provider.

### Laravel Scheduler Cron

If you add scheduled tasks later, configure Laravel's scheduler cron as well:

```cron
* * * * * cd /home/username/path-to-project && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1
```

The scheduler is different from the queue worker. The scheduler runs timed commands; the queue worker processes queued jobs.

---

## 🚢 Production Deployment Checklist

Before going live, review this checklist:

1. Set `APP_ENV=production`, `APP_DEBUG=false`, and the correct `APP_URL`.
2. Configure a real database and run `php artisan migrate --seed --force`.
3. Create the first admin account with `php artisan make:admin`.
4. Configure real email credentials and test password reset/email verification.
5. Run `npm run build` and upload/serve the generated production assets.
6. Run `php artisan storage:link` for public uploads.
7. Make sure `storage/` and `bootstrap/cache/` are writable by the web server.
8. Start a queue worker using Supervisor/systemd, or configure a shared-hosting cron fallback.
9. Point the web server document root to the `public/` directory, not the project root.
10. Change all default/development passwords and avoid running development seeders in production.

Recommended production dependency install:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --seed --force
php artisan storage:link
php artisan config:cache
php artisan view:cache
```

If you change `.env`, routes, config, or views after caching, clear/rebuild the relevant cache:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

---

## 🔑 Default Credentials (Development Only)

After running `migrate:fresh --seed`, the following accounts are available:

| Role | Username | Email | Password | Notes |
|---|---|---|---|---|
| Admin | `admin` | `admin@example.com` | `password` | Full development admin access. |
| Moderator | `moderator` | `moderator@example.com` | `password` | Admin-like access, except protected Admin role management. |
| Lecturers | *(randomly generated)* | *(randomly generated)* | `password` | Login as Admin first, then open the lecturer/user list to see generated lecturer emails. |
| Seeded Classreps | `classrep1`, `classrep2`, etc. | `classrep1@example.com`, `classrep2@example.com`, etc. | `password` | Created only by the local development seeder. |

The login form accepts email, username, or phone number.

When a Classrep is appointed manually from a student record in the classroom edit screen, the system creates a new user account with the student's email if one does not already exist. The default password for that newly created Classrep account is:

```text
password123
```

> **⚠️ Warning:** Change all passwords immediately in a production environment.

---

## 👥 Role & Permission Reference

| Feature | Admin | Moderator | Lecturer (Manager) | Lecturer (Teacher) | Classrep |
|---|:---:|:---:|:---:|:---:|:---:|
| Full System Access | ✅ | ✅ | ❌ | ❌ | ❌ |
| Manage Courses | ✅ | ✅ | ❌ | ❌ | ❌ |
| Manage Classes | ✅ | ✅ | ✅ (Own Course) | ❌ | ❌ |
| Manage Subjects | ✅ | ✅ | ✅ (Own Course) | ❌ | ❌ |
| Manage Students | ✅ | ✅ | ✅ (Own Course) | ❌ | ❌ |
| Record Attendance | ✅ | ✅ | ✅ (Own Course) | ✅ (Own Subject) | ✅ (Own Class) |
| Edit Attendance | ✅ | ✅ | ✅ (Own Course) | ✅ (Own Subject) | ❌ |

---

## 🧪 Running Tests

```bash
# Run all 47 tests
php artisan test

# Run a specific test file
php artisan test --filter LecturerTest

# Run tests with detailed output
php artisan test --verbose
```

---

## 📁 Project Structure

```
school/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Resource controllers (User, Teacher, Student, etc.)
│   │   └── Middleware/         # RoleMiddleware for route protection
│   ├── Models/                 # Eloquent models (User, Role, Student, Classroom, etc.)
│   └── Policies/               # UserPolicy for fine-grained authorization
├── database/
│   ├── factories/              # Model factories for testing & seeding
│   ├── migrations/             # Database schema migrations
│   └── seeders/
│       ├── Dev/                # Development seeder (with dummy data)
│       ├── RoleSeeder.php      # Seeds the 5 default roles
│       └── SettingSeeder.php   # Seeds default branding settings
├── public/
│   └── images/                 # Static assets (default.jpg avatar, hero image)
├── resources/
│   └── js/
│       ├── Layouts/            # AuthenticatedLayout, GuestLayout
│       └── Pages/              # Inertia React pages (Dashboard, Users, Teachers, etc.)
├── routes/
│   └── web.php                 # All application routes with role middleware
└── tests/
    └── Feature/                # PHPUnit feature tests
```

---

## ⚙️ Environment Variables Reference

| Variable | Description | Default |
|---|---|---|
| `APP_NAME` | Application name | `EduFlow` |
| `APP_ENV` | Environment (`local`, `production`) | `local` |
| `APP_URL` | Application base URL | `http://localhost` |
| `DB_CONNECTION` | Database driver (`mysql`, `sqlite`) | `mysql` |
| `DB_DATABASE` | Database name | `school` |
| `QUEUE_CONNECTION` | Queue driver for queued jobs/notifications | `database` |
| `MAIL_MAILER` | Mail driver for notifications (`log`, `smtp`, or provider driver) | `log` |
| `MAIL_HOST` | SMTP host for production email | `127.0.0.1` |
| `MAIL_PORT` | SMTP port | `2525` |
| `MAIL_SCHEME` | SMTP scheme, usually `tls` for port 587 or `ssl` for port 465 | `null` |
| `MAIL_USERNAME` | SMTP username | `null` |
| `MAIL_PASSWORD` | SMTP password | `null` |
| `MAIL_FROM_ADDRESS` | Sender email address | `hello@example.com` |

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new feature branch: `git checkout -b feature/your-feature-name`
3. Make your changes and add tests where applicable.
4. Ensure all tests pass: `php artisan test`
5. Commit your changes: `git commit -m 'feat: add your feature'`
6. Push to your branch: `git push origin feature/your-feature-name`
7. Open a Pull Request.

Please follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards for PHP code.

---

## 📄 License

This project is open-source and licensed under the **MIT License**.

```
MIT License

Copyright (c) 2026 EduFlow Contributors

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

<div align="center">
  <p>Built with ❤️ using Laravel & React</p>
</div>
