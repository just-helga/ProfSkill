<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;

    public function theme() {
        return $this->belongsTo(Theme::class);
    }

    public function speaker() {
        return $this->belongsTo(Speaker::class);
    }
}
