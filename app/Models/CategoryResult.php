<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryResult extends Model
{
    use HasFactory;

    public $guarded = [];

    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function range()
    {
        return $this->belongsTo(Range::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function questionResult()
    {
        return $this->hasMany(QuestionResult::class);
    }


}
