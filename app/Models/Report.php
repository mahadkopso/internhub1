<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id', 'student_id', 'title', 'report_type', 'week_number',
        'description', 'file_path', 'submission_date', 'status',
        'coordinator_feedback', 'reviewed_by', 'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'submission_date' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function application()
    {
        return $this->belongsTo(InternshipApplication::class, 'application_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
