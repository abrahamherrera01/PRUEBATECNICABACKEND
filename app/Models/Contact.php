<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public function emails(){
        return $this->hasMany(Email::class);
    }

    public function phones(){
        return $this->hasMany(Phone::class);
    }

    public function address(){
        return $this->hasMany(Address::class);
    }
}
