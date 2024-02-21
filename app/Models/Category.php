<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $guarded = [];

    public function categoryQuestions()
    {
        return $this->hasMany(Question::class);
    }

    public function categoryFeedback(){
        return $this->hasMany(Range::class, 'category_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    public function result(){
        return $this->hasMany(Result::class);
    }

    public function ranges(){
        return $this->hasMany(Range::class);
    }


    
}
