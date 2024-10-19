<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    public function courses() {
        return $this->hasMany(Course::class);
    }

    public function webinars() {
        return $this->hasMany(Webinar::class);
    }
}
