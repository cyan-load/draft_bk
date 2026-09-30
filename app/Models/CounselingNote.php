<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'guru_id',
        'tanggal',
        'kategori',
        'keluhan_masalah',
        'layanan_diberikan',
        'tindak_lanjut_evaluasi',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
