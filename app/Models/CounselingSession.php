<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'guru_id',
        'category',
        'topic',
        'preferred_date',
        'preferred_time',
        'room_or_media',
        'status',
        'initiated_by',
        'counselor_notes',
        'rejection_reason',
        'rescheduled_reason',
        'completed_at',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
