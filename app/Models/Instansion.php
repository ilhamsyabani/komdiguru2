<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instansion extends Model
{
    use HasFactory;

    public $guarded = [];

    public function users(){
        return $this->hasMany(User::class);
    }
}
