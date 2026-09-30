<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['questionnaire_id', 'teks_pertanyaan', 'tipe_jawaban', 'aspek', 'is_wajib'];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}