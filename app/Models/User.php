<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const DEFAULT_PICTURE = 'images/default.jpg';

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'gender',
        'username',
        'phone_number',
        'address',
        'email',
        'password',
        'picture',
        'role_id',
        'classroom_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scopeWhereRoleName($query, string|array $roles)
    {
        $roles = array_map('strtolower', (array) $roles);

        return $query->whereHas('role', function ($roleQuery) use ($roles) {
            $roleQuery->whereIn(\DB::raw('LOWER(name)'), $roles);
        });
    }

    public function roleName(): ?string
    {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        return $this->role ? strtolower($this->role->name) : null;
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = (array) $roles;

        return in_array($this->roleName(), array_map('strtolower', $roles), true);
    }

    public function isAdminLike(): bool
    {
        return $this->hasRole(['admin', 'moderator']);
    }

    public function isLecturer(): bool
    {
        return $this->hasRole('lecturer');
    }

    public function isClassrep(): bool
    {
        return $this->hasRole('classrep');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function managedCourses()
    {
        return $this->hasMany(Course::class, 'manager_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user');
    }

    public function teachingClassrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_subject', 'lecturer_id', 'classroom_id')->distinct();
    }

    public function teachingSubjects()
    {
        return $this->belongsToMany(Subject::class, 'classroom_subject', 'lecturer_id', 'subject_id')->distinct();
    }

    public function managedCourseIds()
    {
        return $this->managedCourses()->pluck('id');
    }

    public function teachingCourseIds()
    {
        return $this->teachingClassrooms()->pluck('course_id');
    }

    public function accessibleCourseIds()
    {
        return $this->managedCourseIds()
            ->merge($this->teachingCourseIds())
            ->unique()
            ->values();
    }

    public function teachingClassroomIds()
    {
        return $this->teachingClassrooms()->pluck('classrooms.id');
    }

    public function managesCourse($course): bool
    {
        $managerId = is_object($course) ? $course->manager_id : $course;

        return (int) $managerId === (int) $this->id;
    }

    public function teachesClassroom(int $classroomId): bool
    {
        return $this->teachingClassrooms()->where('classrooms.id', $classroomId)->exists();
    }

    public function teachesSubjectInClassroom(int $classroomId, int $subjectId): bool
    {
        return $this->teachingSubjects()
            ->where('subjects.id', $subjectId)
            ->wherePivot('classroom_id', $classroomId)
            ->exists();
    }

    public function hasCustomPicture(): bool
    {
        return filled($this->picture) && $this->picture !== self::DEFAULT_PICTURE && $this->picture !== 'default.jpg';
    }
}
