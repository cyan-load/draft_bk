<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'nis',
        'email',
        'nama',
        'kelas',
        'alamat',
        'nomor_telepon',
        'nomor_telepon_orang_tua',
        'foto',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'nama_ayah',
        'nama_ibu',
        'hobi',
        'cita_cita',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class, 'student_id');
    }

    public function counselingSessions()
    {
        return $this->hasMany(CounselingSession::class, 'student_id')->orderBy('created_at', 'desc');
    }

    public function counselingNotes()
    {
        return $this->hasMany(CounselingNote::class, 'student_id')->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');
    }

    public function getFotoUrlAttribute()
    {
        if (!empty($this->foto)) {
            if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
                return $this->foto;
            }
            return asset('storage/' . $this->foto);
        }
    }
}