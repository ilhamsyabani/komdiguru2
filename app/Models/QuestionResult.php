<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionResult extends Model
{
    use HasFactory;

    protected $table = 'question_results';

    protected $guarded = ['id'];

    public function categoryResult()
    {
        return $this->belongsTo(CategoryResult::class);
    }
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
