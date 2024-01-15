<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function options(){
        return $this->hasMany(Option::class);
    }
}