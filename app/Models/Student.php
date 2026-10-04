<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_id_number', 'university', 'faculty', 'department',
        'program', 'year_of_study', 'gpa', 'bio', 'skills', 'cv_path',
        'profile_photo_path', 'linkedin_url', 'assigned_coordinator_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'assigned_coordinator_id');
    }

    public function applications()
    {
        return $this->hasMany(InternshipApplication::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function activeInternship()
    {
        return $this->applications()->where('status', 'approved')->latest()->first();
    }
}
