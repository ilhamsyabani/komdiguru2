<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    public $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot(['option_id', 'points']);
    }

    public function categoryResults()
    {
        return $this->hasMany(CategoryResult::class, 'result_id');
    }
}
