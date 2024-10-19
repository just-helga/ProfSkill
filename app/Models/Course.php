<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function theme() {
        return $this->belongsTo(Theme::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
