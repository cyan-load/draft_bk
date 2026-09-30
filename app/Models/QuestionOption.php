<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $fillable = ['question_id', 'teks_opsi', 'bobot_nilai'];
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}