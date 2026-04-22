<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withPivot('lecturer_id');
    }

    public function lecturers()
    {
        return $this->belongsToMany(User::class, 'classroom_user', 'classroom_id', 'user_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'classroom_subject', 'classroom_id', 'lecturer_id')->distinct();
    }

    public function classrep()
    {
        return $this->hasOne(User::class, 'classroom_id')->where('role_id', 5);
    }
}
