<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function burgers()
    {
        return $this->hasMany(Burger::class);
    }
}
