<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    use HasFactory;

    protected $table = 'internship_applications';

    protected $fillable = [
        'internship_id', 'student_id', 'cover_letter', 'resume_path',
        'employer_status', 'employer_feedback',
        'coordinator_status', 'coordinator_remarks', 'reviewed_by', 'reviewed_at',
        'status', 'applied_at',
    ];

    protected function casts(): array
    {
        return [
            'applied_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'application_id');
    }

    /**
     * Recompute the overall status from employer + coordinator decisions.
     * Differentiator: an application is only truly "approved" once BOTH
     * the employer has accepted the student AND the university coordinator
     * has approved/authorized the placement.
     */
    public function recomputeStatus(): void
    {
        if ($this->employer_status === 'rejected' || $this->coordinator_status === 'rejected') {
            $this->status = 'rejected';
        } elseif ($this->employer_status === 'accepted' && $this->coordinator_status === 'approved') {
            $this->status = 'approved';
        } elseif ($this->employer_status === 'pending' && $this->coordinator_status === 'pending') {
            $this->status = 'pending';
        } else {
            $this->status = 'under_review';
        }
        $this->save();
    }
}
