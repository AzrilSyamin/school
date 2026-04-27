# EduFlow Product Requirements Document

Status: Draft for pre-release refactor  
Product name: EduFlow  
Repository name: school  
Primary audience: Malaysian schools, colleges, training centres, and open-source contributors  
Tech stack: Laravel 12, React 18, Inertia.js, Tailwind CSS, MySQL/SQLite

## 1. Product Summary

EduFlow is an open-source school and college management system focused on academic structure, role-based access, student records, lecturer responsibility, class representative workflow, and attendance tracking.

The system started as a school management application with courses, classrooms, subjects, students, lecturers, and attendance. The target product must support real academic operations where multiple student intakes can run across multiple academic sessions over time.

The major domain direction is:

- `intakes` represent sesi kemasukan.
- `academic_sessions` represent sesi latihan / current operating academic session.
- `academic_classes` represent class snapshots in one academic session.
- Attendance, teaching responsibility, course manager responsibility, and class placement must keep historical context.

## 2. Product Goals

1. Provide a practical open-source system for managing courses, academic classes, subjects, lecturers, students, users, settings, and attendance.
2. Support a 5-tier RBAC model: Admin, Moderator, Lecturer/Course Manager, Lecturer/Teacher, and Classrep.
3. Support Malaysian academic wording and workflows such as sesi kemasukan, sesi latihan, semester, mata pelajaran, pensyarah, and ketua kelas.
4. Keep historical academic records stable when sessions change.
5. Allow colleges to run multiple intakes and academic sessions over several years.
6. Make installation, local testing, production deployment, queue setup, email setup, and default development login clear for new users.
7. Keep the codebase understandable for human developers and AI coding assistants.

## 3. Non-Goals For First Stable Release

These are intentionally not required for the first stable release unless later prioritized:

- Full student course-transfer workflow.
- Payment, billing, or finance.
- Learning management system features such as quizzes, assignments, grading, and content delivery.
- Timetable scheduling.
- Parent portal.
- Mobile app.
- Biometric attendance.
- Multi-campus enterprise tenancy.

The database structure should not block future student transfer support.

## 4. Current System Snapshot

The current implementation already includes:

- Landing page.
- Authentication with login, registration, email verification, password reset, profile update, profile picture, and account deletion.
- Login by email, username, or phone number.
- Inactive-by-default registration approval flow.
- Role-based navigation and authorization.
- Courses with optional course manager.
- Classrooms linked to courses.
- Subjects linked to courses.
- Classroom-subject-lecturer assignment.
- Students linked to classrooms.
- Student ID normalization and NRIC validation.
- Attendance creation, edit, show, filtering, PDF export, and CSV export.
- Student PDF and CSV export.
- System settings for logo, site title, favicon, and branding.
- Queue-ready email notification system.
- Development seeders with Admin, Moderator, lecturers, classreps, students, courses, subjects, classrooms, and sample attendance.
- Automated feature tests for main flows.

Current limitations:

- Academic structure is still "current session only".
- `classrooms` act as long-lived class records.
- `students.classroom_id` stores current placement directly on student.
- `courses.manager_id` stores one current manager directly on course.
- `classroom_subject` stores teaching assignment without academic session context.
- `attendances` mix attendance session identity and student attendance detail in one table.

The target refactor must address these limitations.

## 5. Core Terminology

### Intake

`intakes` represent sesi kemasukan: the batch/cohort of students who entered the institution together.

Examples:

- `1/2024`
- `2/2024`
- `Sesi 1 2025`
- `Sesi 2 2025`

Intake answers:

- When did the student enter?
- Which cohort does the student belong to?
- What semester should this intake be in during a given academic session?

### Academic Session

`academic_sessions` represent sesi latihan / the active academic operating period.

Examples:

- `1/2025`
- `2/2025`
- `Short Sem 2026`

Academic session answers:

- Which session is the system operating in?
- Which classes run in this session?
- Which lecturer teaches which subject in this session?
- Who is the course manager in this session?
- Which attendance records belong to this session?

Mapping from common forms:

```text
SESI KEMASUKAN = intakes
SESI LATIHAN   = academic_sessions
SEMESTER       = academic_classes.semester_number
```

### Academic Class

`academic_classes` represent real class snapshots in one academic session.

Example:

```text
Intake: 2/2024
Course: Diploma IT

Academic Session 2/2024 -> DIT-1A -> semester_number 1
Academic Session 1/2025 -> DIT-2A -> semester_number 2
Academic Session 2/2025 -> DIT-3A -> semester_number 3
```

Old rows must not be overwritten when the session changes.

## 6. Target Domain Model

### Master Data

- `users`
- `roles`
- `students`
- `courses`
- `subjects`
- `settings`

### Academic Operation Data

- `intakes`
- `academic_sessions`
- `academic_classes`
- `student_enrollments`
- `course_manager_assignments`
- `teaching_assignments`
- `attendance_sessions`
- `attendances`

## 7. Target Data Model Requirements

### 7.1 intakes

Purpose: store student entry cohorts.

Recommended fields:

- `id`
- `name`
- `code`
- `start_date`
- `status`
- `created_at`
- `updated_at`

Statuses:

- `draft`
- `active`
- `closed`
- `archived`

Rules:

- One intake can pass through many academic sessions.
- Intake does not close just because one academic session ends.

### 7.2 academic_sessions

Purpose: store sesi latihan / academic operating periods.

Recommended fields:

- `id`
- `name`
- `code`
- `start_date`
- `end_date`
- `status`
- `is_current`
- `created_at`
- `updated_at`

Statuses:

- `draft`
- `active`
- `closed`
- `archived`

Rules:

- More than one active academic session may be allowed if an institution runs overlapping sessions.
- Closed/archived sessions are read-only by default.
- Admin and Moderator manage the lifecycle.

### 7.3 academic_classes

Purpose: replace current `classrooms` as academic class snapshots for a session.

Recommended fields:

- `id`
- `academic_session_id`
- `intake_id`
- `course_id`
- `name`
- `semester_number`
- `classrep_id`
- `status`
- `created_at`
- `updated_at`

Rules:

- A new academic session creates new academic class rows.
- `semester_number` must not be updated on old rows just because a new session starts.
- Classrep should auto carry forward from the previous academic class when generating the next session class, unless manually changed.

### 7.4 student_enrollments

Purpose: separate student identity from academic placement.

Recommended fields:

- `id`
- `student_id`
- `intake_id`
- `course_id`
- `academic_class_id`
- `current_semester`
- `status`
- `enrolled_at`
- `completed_at`
- `created_at`
- `updated_at`

Statuses:

- `active`
- `transferred`
- `completed`
- `withdrawn`

Rules:

- `students.classroom_id` should be removed in the target refactor.
- `students` store biodata and identity only.
- `student_enrollments` become the source of truth for intake, course, and class placement.
- Full student transfer workflow is not required for first stable release, but the model must support it later.

### 7.5 course_manager_assignments

Purpose: store course manager history by academic session and date range.

Recommended fields:

- `id`
- `academic_session_id`
- `course_id`
- `manager_id`
- `starts_at`
- `ends_at`
- `created_at`
- `updated_at`

Rules:

- No extra table is required for mid-session manager changes.
- More than one row may exist for the same `academic_session_id + course_id` if date ranges do not overlap.
- Only one manager may be active for one course on one date.
- Policies must resolve the active manager using `academic_session_id`, `course_id`, and the relevant operation date.

Example:

```text
Session 1/2026, Diploma IT, Ali, 2026-01-01 to 2026-03-31
Session 1/2026, Diploma IT, Siti, 2026-04-01 to 2026-06-30
```

### 7.6 teaching_assignments

Purpose: store lecturer-subject-class responsibility with academic session context.

Recommended fields:

- `id`
- `academic_session_id`
- `academic_class_id`
- `subject_id`
- `lecturer_id`
- `created_at`
- `updated_at`

Rules:

- A lecturer may teach the same subject in multiple classes.
- Lecturer assignments may change by academic session.
- This table replaces `classroom_subject`.

### 7.7 attendance_sessions

Purpose: store the parent record for one attendance session.

Recommended fields:

- `id`
- `academic_session_id`
- `academic_class_id`
- `subject_id`
- `teaching_assignment_id`
- `date`
- `recorded_by`
- `created_at`
- `updated_at`

Rules:

- One attendance session has a clear identity.
- The system should no longer group attendance using `subject_id + classroom_id + date + recorded_by`.
- PDF/CSV export, show, edit, and permission checks should be based on attendance session.

### 7.8 attendances

Purpose: store attendance detail per student.

Recommended fields:

- `id`
- `attendance_session_id`
- `student_id`
- `student_enrollment_id`
- `status`
- `remarks`
- `created_at`
- `updated_at`

Rules:

- `attendances` must not be removed.
- `attendances` become child rows to `attendance_sessions`.

## 8. Roles And Permissions

### Admin

Admin has full system access.

Requirements:

- View dashboard.
- Manage courses.
- Assign course managers.
- Manage academic sessions.
- Manage intakes.
- Manage academic classes.
- Assign classreps.
- Assign lecturers to subjects/classes.
- Manage subjects.
- Manage lecturers.
- Manage students.
- Manage attendance.
- Manage users across all roles.
- Manage system settings.
- Override academic assignment where policy permits.

### Moderator

Moderator is similar to Admin but cannot manage Admin users/roles.

Requirements:

- Manage academic data.
- Manage users except Admin-protected actions.
- Manage settings only if policy allows.
- Must not create, edit, demote, promote, or delete Admin role/users.

### Lecturer / Course Manager

A course manager is a lecturer assigned to manage a course in an academic session/date range.

Requirements for active session:

- View courses they teach or manage.
- Manage academic classes for managed course/session.
- Manage subjects for managed course/session.
- Manage students/enrollments for managed course/session.
- Create attendance for managed course scope.
- Edit attendance only where policy allows.

Requirements for closed/archived session:

- View records they were involved in.
- Cannot create/edit/delete unless Admin/Moderator grants special override.

### Lecturer / Teacher

A lecturer/teacher is assigned through teaching assignments.

Requirements for active session:

- View courses/classes/subjects/students related to their teaching assignments.
- Create attendance only for assigned subject/class.
- Edit attendance only for assigned subject/class where policy allows.

Requirements for closed/archived session:

- Read-only view for records they were involved in.

### Classrep

A classrep is a user who records attendance for their assigned academic class.

Requirements:

- Record attendance for subjects/classes within allowed scope.
- View relevant attendance sessions.
- Carry forward automatically when next academic class is generated, unless manually changed.
- Closed/archived session is read-only.

### Student

Student role is currently minimal.

Requirements:

- Can authenticate if account exists and is active.
- Future scope may include profile and own attendance view.

## 9. Permission Principles

1. Admin and Moderator are admin-like, except Moderator cannot manage Admin users/roles.
2. Assignment history must not be overwritten.
3. Current authority is determined by assignment in selected academic session and relevant date.
4. Closed/archived session is read-only by default.
5. Former manager/lecturer/classrep may view historical records they were involved in.
6. UI must hide or disable unavailable actions, not merely show empty action columns.
7. Backend policies must enforce the same restrictions even if frontend is bypassed.

## 10. Core Functional Requirements

### 10.1 Authentication And Account

Requirements:

- Login using email, username, or phone number.
- Register account.
- New registration is inactive by default until approved.
- Verify email.
- Reset password.
- Update profile.
- Upload/change profile picture.
- Update password.
- Delete account where allowed.
- Use custom Malay email templates/notifications.
- Queue email notifications.

### 10.2 Dashboard

Requirements:

- Show role-aware overview.
- Show relevant counts and quick summary.
- In target architecture, dashboard must be aware of selected academic session.
- Dashboard content should use full available panel width and align left, not centered narrow content.

### 10.3 Courses

Current requirements:

- CRUD courses.
- Course has name and code.
- Course may have a course manager.

Target requirements:

- Course manager moves from `courses.manager_id` to `course_manager_assignments`.
- Course may define `total_semesters` to support semester progression.
- Course may later define semester pattern/duration settings.

### 10.4 Academic Sessions

Target requirements:

- CRUD academic sessions.
- Mark current session.
- Support draft, active, closed, archived.
- Selected academic session should affect dashboard, classes, students, attendance, and reports.
- Closed/archived session should be view-only by default.

### 10.5 Intakes

Target requirements:

- CRUD intakes.
- Assign students/enrollments to an intake.
- Use intake with academic session to determine semester progression.
- Allow one intake to appear across many academic sessions.

### 10.6 Academic Classes

Current equivalent: classrooms.

Target requirements:

- CRUD academic classes by academic session, intake, and course.
- Store `semester_number`.
- Assign classrep.
- Auto carry forward classrep from previous academic class when generating next class.
- Assign teaching assignments through class/subject/lecturer.
- Maintain historical class records.

### 10.7 Subjects

Requirements:

- CRUD subjects/mata pelajaran.
- Subject belongs to course.
- Manager can manage subjects within assigned course/session.
- Lecturer can view subjects they teach.

### 10.8 Lecturers

Requirements:

- Admin/Moderator can CRUD lecturers.
- Lecturer records are user accounts with Lecturer role.
- Lecturer can be assigned as course manager.
- Lecturer can be assigned to teach subjects/classes.
- Lecturer list should show all involved courses clearly.

### 10.9 Students

Requirements:

- CRUD students.
- Student fields include name, student ID, NRIC, email, gender, age if retained, and placement.
- Student ID must normalize to uppercase and remove spaces on frontend and backend.
- NRIC must accept numbers and dash only.
- NRIC validation must exist on frontend and backend.
- Student index should show NRIC/Nombor IC.
- Student index should not show age inside Maklumat column.
- Student export must support CSV and PDF.
- PDF student export can omit email and gender to keep layout readable.

Target requirements:

- Move placement from `students.classroom_id` to `student_enrollments`.
- Student transfer course is future-ready, not full release-one workflow.

### 10.10 Attendance

Requirements:

- Create attendance.
- Edit attendance where policy allows.
- View attendance details.
- Filter attendance by date, class, subject, and course for Admin/Moderator.
- Export attendance to PDF and CSV.
- Attendance show page must include Student ID.
- Create/edit pages need a Back button.
- Attendance mobile table should remain readable and avoid overly narrow columns.

Target requirements:

- Add `attendance_sessions`.
- `attendances` become child rows.
- Attendance permissions resolve through academic session, class, subject, teaching assignment, and recorder.

### 10.11 Reports And Export

Requirements:

- Student export: CSV and PDF.
- Attendance export: CSV and PDF.
- PDF reports should include formal school-style header.
- Export must respect filters and permissions.
- Export must avoid exposing data outside user scope.

### 10.12 System Settings

Requirements:

- Admin/Moderator can update system settings where authorized.
- Settings include site title, logo, favicon, and branding-related values.
- Default/fallback app name should use EduFlow consistently.
- Auth pages and layouts should use environment/settings values, not hardcoded app name where possible.

### 10.13 Navigation And Layout

Requirements:

- Sidebar should be reusable component.
- Navigation item config should be centralized.
- Active menu state should remain active on index/create/edit/show pages.
- Sidebar logo should show logo row first and title row second.
- Sidebar inactive menu items should have clear bottom border.
- Responsive layout must work on mobile.
- Tables should use reusable table styling.
- Light mode primary color: `#228260`.
- Dark mode primary color: `#32BA83`.

## 11. UI Requirements

General:

- Use dense, clear admin panel UI rather than marketing-style layouts inside the dashboard.
- Avoid empty action columns for roles without action permission.
- Use reusable components for tables, sidebar, navigation, buttons, inputs, and forms where practical.
- All pages must be usable on mobile and desktop.
- Text must not overflow buttons, cards, table cells, or panels.

Tables:

- Light mode table header should have strong contrast.
- Row striping should be visible in light and dark mode.
- Mobile table layout must remain readable.
- Action columns should be hidden entirely if no action is available.

Forms:

- Show validation errors clearly.
- Normalize Student ID frontend before submit.
- Validate Student ID backend.
- Validate NRIC frontend and backend.

## 12. Email And Queue Requirements

Requirements:

- Email verification, password reset, registration notifications, and other notifications may be queued.
- Production users must configure real SMTP.
- Default Laravel log mailer is acceptable only for local development.
- API-based mail providers require users to install provider packages and add provider variables themselves.
- Queue worker must be documented and required for real email sending.

Operational requirements:

- Local: `php artisan queue:work`.
- Production VPS: Supervisor/systemd.
- Shared hosting: cron using `queue:work --stop-when-empty`.
- Scheduler cron should be documented separately if scheduled tasks are added.

## 13. Default Development Data

After `php artisan migrate:fresh --seed` in local environment:

- Admin: `admin@example.com` / `password`
- Moderator: `moderator@example.com` / `password`
- Lecturers: randomly generated / `password`
- Seeded classreps: `classrep1@example.com`, `classrep2@example.com`, etc. / `password`

When a classrep is appointed manually and a user is created from a student record, default password is:

```text
password123
```

These credentials are for development only.

## 14. Deployment Requirements

Production setup must include:

- `APP_ENV=production`
- `APP_DEBUG=false`
- Correct `APP_URL`
- Real database
- Real SMTP configuration
- `php artisan migrate --seed --force`
- `php artisan make:admin`
- `php artisan storage:link`
- `npm run build`
- Queue worker or cron fallback
- Writable `storage/` and `bootstrap/cache/`
- Web root pointed to `public/`
- Cached config/views where appropriate

## 15. Non-Functional Requirements

Security:

- All protected routes require authentication.
- Role middleware protects broad route groups.
- Policies enforce fine-grained ownership/scope.
- Moderator must not manage Admin role/users.
- Backend validation must not rely on frontend only.
- Uploaded files must be constrained by type/size.

Performance:

- Index pages should use pagination where record counts can grow.
- Search should avoid expensive unbounded queries.
- Export should respect filters and avoid loading unrelated records.

Maintainability:

- Prefer reusable UI components.
- Keep role/permission logic in policies and model helper methods.
- Keep academic-session selection centralized.
- Keep domain naming consistent.
- Avoid duplicating table markup and navigation data.

Accessibility:

- Forms must have labels.
- Buttons and links must have clear text or accessible labels.
- Color should not be the only indicator of status.

## 16. Testing Requirements

Automated tests should cover:

- Authentication flows.
- Registration inactive-by-default behavior.
- Email verification and password reset.
- Admin and Moderator permissions.
- Moderator cannot manage Admin.
- Course CRUD.
- Academic session CRUD once implemented.
- Intake CRUD once implemented.
- Academic class CRUD once implemented.
- Course manager assignment policies.
- Teaching assignment policies.
- Student CRUD and validation.
- Student ID normalization.
- NRIC validation.
- Attendance create/edit/show/export.
- Closed session read-only behavior.
- Classrep carry-forward behavior.
- PDF/CSV export authorization.

Before release:

- `php artisan test` must pass.
- `npm run build` must pass.

## 17. Target Refactor Strategy

Phase 1: Core academic foundation

- Create `intakes`.
- Create `academic_sessions`.
- Create `academic_classes`.
- Add selected/current academic session state.
- Start replacing `classrooms` usage.

Phase 2: Enrollment

- Create `student_enrollments`.
- Move placement away from `students.classroom_id`.
- Update student CRUD and listing.
- Update classrep appointment to use `academic_class_id`.

Phase 3: Course manager assignment

- Create `course_manager_assignments`.
- Replace `courses.manager_id`.
- Implement date-range checks.
- Update manager policies and UI.

Phase 4: Teaching assignment

- Create `teaching_assignments`.
- Replace `classroom_subject`.
- Update lecturer access.
- Update subject/class assignment UI.

Phase 5: Attendance session

- Create `attendance_sessions`.
- Update `attendances` with `attendance_session_id` and `student_enrollment_id`.
- Refactor attendance create/edit/show/export.

Phase 6: Cleanup

- Remove old columns/tables after replacement.
- Update seeders, factories, tests, README, and docs.

## 18. Tables And Columns To Replace

Target cleanup:

- `classrooms` -> `academic_classes`
- `classroom_subject` -> `teaching_assignments`
- `students.classroom_id` -> `student_enrollments.academic_class_id`
- `courses.manager_id` -> `course_manager_assignments`
- attendance grouping by field combination -> `attendance_sessions`

Do not remove:

- `attendances`; it remains as attendance detail rows.

## 19. Acceptance Criteria For First Stable Release

The first stable release is acceptable when:

- Admin can manage the full academic structure.
- Moderator can manage academic structure but cannot manage Admin role/users.
- Course Manager can manage only assigned course/session scope.
- Lecturer can record attendance only for assigned subject/class scope.
- Classrep can record attendance only for assigned class scope.
- Students can be managed with valid Student ID and NRIC rules.
- Attendance can be created, edited, viewed, filtered, and exported.
- Student records can be exported.
- Email setup and queue setup are documented.
- Default development credentials are documented.
- Academic session/intake structure is either implemented or clearly documented as active refactor scope.
- Tests and build pass.

## 20. Documentation Rules

README should stay user-facing and installation-focused.

This PRD should stay product/system-focused and include:

- Role rules.
- Domain model.
- Feature requirements.
- Validation rules.
- Refactor direction.
- Release criteria.

When changing major behavior:

1. Update this PRD.
2. Update tests or add tests.
3. Update README only with user-facing setup or feature summary.

## 21. Glossary

- Admin: full system administrator.
- Moderator: admin-like user without Admin role management rights.
- Lecturer: teacher/pensyarah user.
- Course Manager: lecturer assigned to manage a course in an academic session/date range.
- Classrep: ketua kelas user who records attendance for a class.
- Intake: sesi kemasukan / student cohort.
- Academic Session: sesi latihan / operating academic session.
- Academic Class: class snapshot in one academic session.
- Subject: mata pelajaran.
- Teaching Assignment: lecturer-subject-class assignment for a session.
- Attendance Session: parent record for one attendance-taking event.
