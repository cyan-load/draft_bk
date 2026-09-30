<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $fillable = [
        'judul',
        'jenis_instrumen',
        'deskripsi',
        'target_kelas',
        'status', // 'draft', 'published', 'finished'
        'is_active',
        'published',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class, 'questionnaire_id');
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isPublished()
    {
        return $this->status === 'published' || $this->is_active == 1 || $this->published == 1;
    }

    public function isFinished()
    {
        return $this->status === 'finished';
    }
}