<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'student_id', 'email', 'age', 'gender', 'classroom_id'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

}
