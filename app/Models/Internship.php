<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id', 'title', 'description', 'requirements', 'location',
        'work_mode', 'duration', 'start_date', 'application_deadline',
        'slots_available', 'is_paid', 'stipend', 'status', 'approval_status',
        'reviewed_by', 'coordinator_remarks',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'application_deadline' => 'date',
            'is_paid' => 'boolean',
        ];
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function applications()
    {
        return $this->hasMany(InternshipApplication::class);
    }

    public function scopeOpenAndApproved($query)
    {
        return $query->where('status', 'open')->where('approval_status', 'approved');
    }

    public function isDeadlinePassed(): bool
    {
        return $this->application_deadline && $this->application_deadline->isPast();
    }
}
